<?php

class Complaint_model extends CI_Model {
    public function add($complaint) {
        return $this->db->insert('complaint', $complaint);
    }
    
    public function edit($complaint) {
        $this->db->where('id', $complaint['id']);
        $this->db->update('complaint', $complaint);
        return $this->db->error();
    }

    public function accept($id) {
        if($this->get_status($id) != 'Pending'){
            return FALSE;
        }
        $complaint['complaint_id'] = $id;
        $complaint['accepted_by'] = $this->session->userdata('user_id');
        return $this->db->insert('accepted_complaint', $complaint);
    }
    
    public function solved($id) {
        if($this->get_status($id) != 'Ongoing'){
            return FALSE;
        }
        $complaint['solved_by'] = $this->session->userdata('user_id');
        $complaint['datetime_solved'] = date('Y-m-d H:i:s');
        $this->db->where('complaint_id', $id);
        $this->db->update('accepted_complaint', $complaint);
        return $this->db->error();
    }

    public function get($id){
        $this->db->select('category, title, description, location, barangay, image_filename, poster_id');
        $this->db->from('complaint');
        $this->db->where('id', $id);
        return $this->db->get()->row_array();
    }
    
    public function get_all($type = FALSE, $page = 1){
        $this->db->select('c.id, c.datetime_posted, c.category, c.title, c.is_spam, c.location, c.barangay, ac.datetime_solved, ac.datetime_accepted');
        $this->db->from('complaint AS c');
        $this->db->join('accepted_complaint AS ac', 'ac.complaint_id = c.id', 'left');
        $this->db->where('is_deleted', 0);
        if($type === 'pending'){
           $this->db->where('ac.complaint_id IS NULL', FALSE, FALSE);
        }else if($type === 'ongoing'){
            $this->db->where('ac.complaint_id IS NOT NULL', FALSE, FALSE);
            $this->db->where('ac.datetime_solved IS NULL', FALSE, FALSE);
        }else if($type === 'solved'){
            $this->db->where('ac.datetime_solved IS NOT NULL', FALSE, FALSE);
        }
        $this->db->order_by('c.id','DESC');
        return $this->db->get()->result_array();
    }
    
    public function get_status($id){
        $this->db->select('is_deleted, is_spam');
        $this->db->from('complaint');
        $this->db->where('id', $id);
        $complaint = $this->db->get()->row_array();
        
        if($complaint['is_spam'] == 1){
            return "Deleted - Spam";
        }else if($complaint['is_deleted'] == 1){
            return "Deleted - Not Spam";
        }
        
        $this->db->select('c.id');
        $this->db->from('complaint AS c');
        $this->db->join('accepted_complaint AS ac', 'ac.complaint_id = c.id');
        $this->db->where('ac.complaint_id', $id);
        $rows = $this->db->get()->num_rows();
        if($rows == 0){
            return "Pending";
        }else{
            $this->db->select('complaint_id');
            $this->db->from('accepted_complaint');
            $this->db->where('complaint_id', $id);
            $this->db->where('datetime_solved IS NOT NULL', FALSE, FALSE);
            $rows = $this->db->get()->num_rows();
            if($rows == 0){
                return "Ongoing";
            }else{
                return "Solved";
            }
        }  
    }
}
