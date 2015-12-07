<?php

class Miscellaneous_model extends CI_Model {

    public function get_hotline($id) {
        $this->db->select('id, title, number');
        $this->db->from('hotline');
        $this->db->where('id', $id);
        return $this->db->get()->result_array();
    }
    
    public function get_announcement($id) {
        $this->db->select('id, title, description');
        $this->db->from('announcement');
        $this->db->where('id', $id);
        return $this->db->get()->result_array();
    }
    
    public function add_hotline($hotline) {
        return $this->db->insert('hotline', $hotline);
    }
    
    public function add_announcement($announcement) {
        return $this->db->insert('announcement', $announcement);
    }

    public function get_all($type = FALSE, $limit = FALSE, $page = 1) {
        if ($type == 'hotlines') {
            $this->db->select('id, title, number');
            $this->db->from('hotline');
            return $this->db->get()->result_array();
        } else if ($type == 'announcements') {
            $this->db->select('id, title, description');
            $this->db->from('announcement');
            $this->db->limit($limit);
            $this->db->order_by('id', 'DESC');
            return $this->db->get()->result_array();
        } else {
            return 'invalid type';
        }
    }

    public function delete_hotline($id) {
        $this->db->where('id', $id);
        return $this->db->delete('hotline');
    }
    
    public function delete_announcement($id) {
        $this->db->where('id', $id);
        return $this->db->delete('announcement');
    }

}
