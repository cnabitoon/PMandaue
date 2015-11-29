<?php

class Complaint_model extends CI_Model {
    public function add($complaint) {
        return $this->db->insert('complaint', $complaint);
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
    
    public function get($id){
        $this->db->select('category, title, description, location, barangay, image_filename, poster_id');
        $this->db->from('complaint');
        $this->db->where('id', $id);
        return $this->db->get()->row_array();
    }
    
    public function get_status($id){
        //assuming not deleted and not spam
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
