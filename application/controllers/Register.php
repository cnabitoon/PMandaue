<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends MY_Controller {

    protected $tab_title = 'Register';

    public function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
    }

    public function index() {
        $errors = FALSE;
        if ($this->input->method(TRUE) === 'GET') {
            $this->generate_page('register', ['errors' => $errors]);
        } else {  //POST
            $this->load->model('Account_model', 'account');
            $this->load->helper(['string', 'array']);
            $this->form_validation->set_rules('firstname', 'First Name', 'required');
            $this->form_validation->set_rules('lastname', 'Last Name', 'required');
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[account.email]');
            $this->form_validation->set_rules('contact_number', 'Contact Number', 'required|exact_length[11]');
            $this->form_validation->set_rules('password', 'Password', 'required');
            $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[password]');

            if ($this->form_validation->run() == FALSE) {
                $errors = array_values($this->form_validation->error_array());
                $this->generate_page('register', ['errors' => $errors]);
            }else{  //no form validation errors
                $input = $this->input->post();
                $account = elements(['firstname', 'lastname', 'email', 'contact_number'], $input);
                $account['password_salt'] = uniqid();
                $account['password_hash'] = md5($input['password'] . $account['password_salt']);
                $account['verification_code'] = random_string('alnum', 6);
                if ($this->account->create($account)) {
                    echo "Account created.";
                } else {
                    echo "Account creation failed.";
                }
            }
        }
    }

}
