<?php

class Account_model extends CI_Model {
    public function add($account){
        return $this->db->insert('account',$account);
    }
    public function verify($email, $code){
        $this->db->select('id')->from('account')->where(['email' => $email,'verification_code' => $code]);
        $this->db->where('last_login IS NULL', FALSE, FALSE);
        $verified = $this->db->get()->num_rows() === 1;
        if($verified){
            $this->db->update('account', ['last_login' => date('Y-m-d H:i:s')], ['email' => $email]);
        }
        return $verified;
    }
    public function login($email,$password){
        $result = $this->db->select('password_salt')->from('account')->where('email',$email)->get()->row_array();
        $this->db->select('id, firstname, lastname, type')->from('account')->where(['email'=>$email,'password_hash'=>  md5($password . $result['password_salt'])]);
        $this->db->where('last_login IS NOT NULL',false,false);
        return $this->db->get()->row_array();
        
    }
    public function is_existing($email){
        return $this->db->select('id')->from('account')->where('email',$email)->get()->num_rows() > 0;
    }
    public function is_verified($email){
        $this->db->select('id')->from('account')->where('email',$email);
        $this->db->where('last_login IS NOT NULL',false,false);
        return $this->db->get()->num_rows() > 0;
    }
}
