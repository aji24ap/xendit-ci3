<?php

class M_Xendit extends CI_Model{
    
    public function updateStatus($external_id, $status){
        // Update status pesanan berdasarkan external ID
        $this->db->where('external_id', $external_id);
        $this->db->update('payments', ['status' => $status]);
    }

    function get_data($table){
        return $this->db->get($table);
    }

    public function ambil_status($external_id) {
        // Query database untuk mendapatkan status transaksi berdasarkan external_id
        $query = $this->db->get_where('payments', array('external_id' => $external_id));

        // Periksa apakah ada hasil query
        if ($query->num_rows() > 0) {
            // Ambil status transaksi dari hasil query
            $row = $query->row();
            return $row->status;
        } else {
            return null;
        }
    }

    public function updatePaymentChannel($external_id, $payment_channel) {
        $data = array(
            'pembayaran' => $payment_channel
        );

        $this->db->where('external_id', $external_id);
        $this->db->update('payments', $data);
    }
}    