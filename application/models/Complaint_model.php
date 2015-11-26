<?php

class Complaint_model extends CI_Model {
    public function create($complaint) {
        return $this->db->insert('complaint', $complaint);
    }
}
