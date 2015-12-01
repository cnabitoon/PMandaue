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
        if ($this->get_status($id) != 'Pending') {
            return FALSE;
        }
        $complaint['complaint_id'] = $id;
        $complaint['accepted_by'] = $this->session->userdata('user_id');
        return $this->db->insert('accepted_complaint', $complaint);
    }

    public function solved($id) {
        if ($this->get_status($id) != 'Ongoing') {
            return FALSE;
        }
        $complaint['solved_by'] = $this->session->userdata('user_id');
        $complaint['datetime_solved'] = date('Y-m-d H:i:s');
        $this->db->where('complaint_id', $id);
        $this->db->update('accepted_complaint', $complaint);
        return $this->db->error();
    }

    public function delete($id) {
        $this->db->select('is_deleted');
        $this->db->from('complaint');
        $this->db->where('id', $id);
        $result = $this->db->get()->row_array();
        if ($result['is_deleted'] == 1) {
            return FALSE;
        }
        $complaint['is_deleted'] = 1;
        $this->db->where('id', $id);
        $this->db->update('complaint', $complaint);
        return $this->db->error();
    }
    
    public function get($id) {
        $this->db->select('category, title, description, location, barangay, image_filename, poster_id');
        $this->db->from('complaint');
        $this->db->where('id', $id);
        return $this->db->get()->row_array();
    }

    public function get_all($type = FALSE, $page = 1) {
        $this->db->select('c.id, c.datetime_posted, c.category, c.title, c.image_filename, c.is_spam, c.location, c.barangay, ac.datetime_solved, ac.datetime_accepted');
        $this->db->from('complaint AS c');
        $this->db->join('accepted_complaint AS ac', 'ac.complaint_id = c.id', 'left');

        if ($type === 'pending') {
            $this->db->where('is_deleted', 0);
            $this->db->where('ac.complaint_id IS NULL', FALSE, FALSE);
        } else if ($type === 'ongoing') {
            $this->db->where('is_deleted', 0);
            $this->db->where('ac.complaint_id IS NOT NULL', FALSE, FALSE);
            $this->db->where('ac.datetime_solved IS NULL', FALSE, FALSE);
        } else if ($type === 'solved') {
            $this->db->where('is_deleted', 0);
            $this->db->where('ac.datetime_solved IS NOT NULL', FALSE, FALSE);
        } else if ($type == 'deleted-declined') {
            $this->db->where('is_deleted', 1);
            $this->db->where('is_spam', 0);
            $this->db->where('ac.complaint_id IS NULL', FALSE, FALSE);
        } else if ($type == 'deleted-spam') {
            $this->db->where('is_spam', 1);
            $this->db->where('ac.complaint_id IS NULL', FALSE, FALSE);
        } else if ($type == 'deleted-ongoing') {
            $this->db->where('is_deleted', 1);
            $this->db->where('ac.complaint_id IS NOT NULL', FALSE, FALSE);
            $this->db->where('ac.datetime_solved IS NULL', FALSE, FALSE);
        } else if ($type == 'deleted-solved') {
            $this->db->where('is_deleted', 1);
            $this->db->where('ac.datetime_solved IS NOT NULL', FALSE, FALSE);
        } else {
            return 'invalid type';
        }
        $this->db->order_by('c.id', 'DESC');
        return $this->db->get()->result_array();
    }

    public function get_status($id) {
        $this->db->select('is_spam, is_deleted');
        $this->db->from('complaint');
        $this->db->where('id', $id);
        $complaint = $this->db->get()->row_array();
        $is_deleted = $complaint['is_deleted'];
        
        if ($complaint['is_spam'] == 1) {
            return "Deleted - Spam";
        } 

        $this->db->select('c.id');
        $this->db->from('complaint AS c');
        $this->db->join('accepted_complaint AS ac', 'ac.complaint_id = c.id');
        $this->db->where('ac.complaint_id', $id);
        $rows = $this->db->get()->num_rows();
        if ($rows == 0) {
            if ($is_deleted == 0) {
                return "Pending";
            } else {
                return "Deleted - Declined";
            }
        } else {
            $this->db->select('complaint_id');
            $this->db->from('accepted_complaint');
            $this->db->where('complaint_id', $id);
            $this->db->where('datetime_solved IS NOT NULL', FALSE, FALSE);
            $rows = $this->db->get()->num_rows();
            if ($rows == 0) {
                if ($is_deleted == 0) {
                    return "Ongoing";
                } else {
                    return "Deleted - Ongoing";
                }
            } else {
                if ($is_deleted == 0) {
                    return "Solved";
                } else {
                    return "Deleted - Solved";
                }
            }
        }
    }

}
