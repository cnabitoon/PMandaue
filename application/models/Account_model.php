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
    public function login($username,$password){
        $result = $this->db->select('password_salt')->from('account')->where('username',$username)->get()->row_array();
        $this->db->select('id, firstname, lastname, type')->from('account')->where(['username'=>$username,'password_hash'=>  md5($password . $result['password_salt'])]);
        $this->db->where('last_login IS NOT NULL',false,false);
        return $this->db->get()->row_array();
        
    }
    
    public function get_fullname($id){
        $this->db->select('firstname, lastname');
        $this->db->from('account');
        $this->db->where('id', $id);
        $result = $this->db->get()->row_array();
        return $result['firstname'] . " " . $result['lastname'];
    }


    public function is_existing($username){
        return $this->db->select('id')->from('account')->where('username',$username)->get()->num_rows() > 0;
    }
    public function is_verified($username){
        $this->db->select('id')->from('account')->where('username',$username);
        $this->db->where('last_login IS NOT NULL',false,false);
        return $this->db->get()->num_rows() > 0;
    }
}
