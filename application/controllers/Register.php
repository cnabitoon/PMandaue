<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends MY_Controller {

    protected $tab_title = 'Register';

    public function __construct() {
        parent::__construct();
        if ($this->session->userdata('user_id')) {
            redirect();
        }
        $this->load->library('form_validation');
    }

    public function index() {
        $errors = FALSE;
        if ($this->input->method(TRUE) === 'GET') {
            $this->generate_page('register', ['errors' => $errors]);
        } else {
            $this->load->model('Account_model', 'account');
            $this->load->helper(['string', 'array']);
            $this->form_validation->set_rules('username', 'Username', 'required|is_unique[account.username]|regex_match[/^(?=.{8,20}$)(?![_.])(?!.*[_.]{2})[a-zA-Z0-9._]+(?<![_.])$/]');
            $this->form_validation->set_rules('firstname', 'First Name', 'required');
            $this->form_validation->set_rules('lastname', 'Last Name', 'required');
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[account.email]');
            $this->form_validation->set_rules('contact_number', 'Contact Number', 'required|exact_length[11]|is_unique[account.contact_number]');
            $this->form_validation->set_rules('password', 'Password', 'required');
            $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[password]');

            if ($this->form_validation->run() == FALSE) {
                $errors = array_values($this->form_validation->error_array());
                $this->generate_page('register', ['errors' => $errors]);
            } else {
                $input = $this->input->post();
                $account = elements(['username', 'firstname', 'lastname', 'email', 'contact_number'], $input);
                $account['password_salt'] = uniqid();
                $account['password_hash'] = md5($input['password'] . $account['password_salt']);
                $account['verification_code'] = random_string('alnum', 6);
                if ($this->account->add($account)) {
                    $this->session->set_flashdata('infos', ['Account created.', 'Please check your email for verification link.']);
                    redirect('login');
                } else {
                    $this->generate_page('register', ['errors' => 'Account creation failed.']);
                }
            }
        }
    }

}
