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
}    