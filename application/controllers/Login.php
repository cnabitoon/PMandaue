<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends MY_Controller {

    protected $tab_title = 'Login';

    public function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
    }

    public function index() {
        $errors = FALSE;
        if ($this->input->method(TRUE) === 'GET') {
            $this->generate_page('login', ['errors' => $errors]);
        } else {  //POST
            $this->load->model('Account_model', 'account');
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email|callback_existing_email|callback_verified_email');
            $this->form_validation->set_rules('password', 'Password', 'required');
            if ($this->form_validation->run() == FALSE) {
                $errors = array_values($this->form_validation->error_array());
                $this->generate_page('login', ['errors' => $errors]);
            } else {  //no form validation errors
                $input = $this->input->post();
                $account = $this->account->login($input['email'], $input['password']);
                if ($account) {   //login successfull
                    $account['user_id'] = $account['id'];
                    unset($account['id']);
                    $this->session->set_userdata($account);
                    redirect();
                } else {
                    $this->generate_page('login', ['errors' => ['Invalid username/password.']]);
                }
            }
        }
    }

    function existing_email($email) {
        $this->form_validation->set_message("existing_email", "Email doesn't exist.");
        return $this->account->exists($email);
    }

    function verified_email($email) {
        $this->form_validation->set_message("verified_email", "Email unverified.");
        if (!$this->account->exists($email)) {
            return TRUE;
        }
        return $this->account->verified($email);
    }

}
