<?php

class Complaint_model extends CI_Model {
    public function add($complaint) {
        return $this->db->insert('complaint', $complaint);
    }
    public function get_all_accepted(){
        //return $this->db->select('complaint_id')->from('accepted_complaint')->get()->result_array();
    }
}
