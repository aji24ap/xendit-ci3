<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Xendit\Xendit;
use Xendit\Exceptions\ApiException;

class Payment extends CI_Controller {
    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $data['title'] = 'Payment Page';
        $this->load->view('payment_form', $data);
    }

    public function process_payment() {
        $external_id = $this->input->post('external_id');
        $amount = $this->input->post('amount');
        $payer_email = $this->input->post('payer_email');

        //  Membuat Biaya Transaksi
        $fee = 5000;
        $harga = $amount + $fee;

        // Mengatur API Key Xendit (ganti XENDIT_API_KEY dengan API Key kamu)
        Xendit::setApiKey('XENDIT_API_KEY');

        try {
            // Membuat pembayaran menggunakan Xendit
            $payment = \Xendit\Invoice::create([
                'external_id' => $external_id,
                'payer_email' => $payer_email,
                'amount' => $harga,
                'description' => "Invoice Pembayaran $external_id",
                'invoice_duration' => 86400, // 1 hari
                'success_redirect_url' => 'https://ilham-wahyu-aji.tech/xendit/payment/data_transaksi',
                'failure_redirect_url' => 'https://ilham-wahyu-aji.tech/xendit/payment/data_transaksi',
                'currency' => 'IDR',
                'locale' => 'id',
                'items' => [
                    [
                        'quantity' => 1,
                        'price' => $harga,
                        'name' => 'Test Payment',
                        'category' => 'Electronic'
                    ]
                ],
                'fees' => [
                    [
                        'type' => 'Biaya Transaksi',
                        'value' => $fee
                    ]
                ]
            ]);    

            // Simpan data pembayaran ke dalam database
            $data = [
                'external_id' => $external_id,
                'amount' => $amount,
                'payer_email' => $payer_email,
                'status' => 'pending' // Status pembayaran awal
            ];
            $this->db->insert('payments', $data);

            // Redirect ke halaman pembayaran Xendit
            redirect($payment['invoice_url']);
        } catch (ApiException $e) {
            // Handle error pembayaran
            $error_message = $e->getMessage();
            $this->session->set_flashdata('error', $error_message);
            redirect('payment');
        }
    }

    public function callback() {
        // Mendapatkan data dari callback Xendit
        $data = file_get_contents('php://input');
        $request = json_decode($data, true);
    
        // Memeriksa kecocokan callback token (ganti XENDIT_CALLBACK_TOKEN dengan API Key kamu)
        $callback_token = 'XENDIT_CALLBACK_TOKEN';
        $callback_token_header = $_SERVER['HTTP_X_CALLBACK_TOKEN'];
    
        if ($callback_token_header == $callback_token) {
            $external_id = $request['external_id'];
            $status = $request['status'];
    
            // Load model M_Xendit
            $this->load->model('M_Xendit');
    
            switch ($status) {
                case 'PAID':
                    // Update status menjadi "Sudah Dibayar" menggunakan model
                    $this->M_Xendit->updateStatus($external_id, 'Sudah Dibayar');
                    break;
                case 'EXPIRED':
                    // Update status menjadi "Expired" menggunakan model
                    $this->M_Xendit->updateStatus($external_id, 'Expired');
                    break;
                default:
                    // Update status menjadi "Pending" menggunakan model
                    $this->M_Xendit->updateStatus($external_id, 'Pending');
                    break;
            }
        }
    }    
    
    public function data_transaksi() {
        $data['payments'] = $this->M_Xendit->get_data('payments')->result();
        $this->load->view('data_transaksi', $data);
    }

    public function bayar($external_id) {
        $data['payments'] = $this->M_Xendit->get_data('payments')->result();
        $data['payments'] = $this->db->query("SELECT * FROM payments WHERE external_id='$external_id'")->result();
        $this->load->view('bayar', $data);
    }

    public function bayar_ulang() {
        $external_id = $this->input->post('external_id');
        $amount = $this->input->post('amount');
        $payer_email = $this->input->post('payer_email');

        // Mendapatkan status transaksi dari model atau sumber data lainnya
        $status = $this->M_Xendit->ambil_status($external_id); // Ganti dengan pemanggilan model yang sesuai

        // Cek status transaksi
        if ($status === "Expired") {
            $this->session->set_flashdata('error', 'Transaksi ini sudah expired.');
            redirect('payment');
        } elseif ($status === "Sudah Dibayar") {
            $this->session->set_flashdata('error', 'Transaksi ini sudah selesai.');
            redirect('payment');
        }

        //  Membuat Biaya Transaksi
        $fee = 5000;
        $harga = $amount + $fee;

        // Mengatur API Key Xendit (ganti XENDIT_API_KEY dengan API Key kamu)
        Xendit::setApiKey('XENDIT_API_KEY');

        try {
            // Membuat pembayaran menggunakan Xendit
            $payment = \Xendit\Invoice::create([
                'external_id' => $external_id,
                'payer_email' => $payer_email,
                'amount' => $harga,
                'description' => "Invoice Pembayaran $external_id",
                'invoice_duration' => 86400, // 1 hari
                'success_redirect_url' => 'https://ilham-wahyu-aji.tech/xendit/payment/data_transaksi',
                'failure_redirect_url' => 'https://ilham-wahyu-aji.tech/xendit/payment/data_transaksi',
                'currency' => 'IDR',
                'locale' => 'id',
                'items' => [
                    [
                        'quantity' => 1,
                        'price' => $harga,
                        'name' => 'Test Payment',
                        'category' => 'Electronic'
                    ]
                ],
                'fees' => [
                    [
                        'type' => 'Biaya Transaksi',
                        'value' => $fee
                    ]
                ]
            ]);    

            // Redirect ke halaman pembayaran Xendit
            redirect($payment['invoice_url']);
        } catch (ApiException $e) {
            // Handle error pembayaran
            $error_message = $e->getMessage();
            $this->session->set_flashdata('error', $error_message);
            redirect('payment');
        }
    }
}    