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
        $redirect = 'none';
        if ($this->input->method(TRUE) === 'GET') {
            if (isset($_SESSION['errors'])) {
                $errors = $_SESSION['errors'];
            }
            if (isset($_SESSION['redirect'])) {
                $redirect = $_SESSION['redirect'];
            }
            $this->generate_page('login', ['errors' => $errors, 'redirect' => $redirect]);
        } else {  //POST
            $this->load->model('Account_model', 'account');
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email|callback_existing_email|callback_verified_email');
            $this->form_validation->set_rules('password', 'Password', 'required');
            $input = $this->input->post();
            if ($this->form_validation->run() == FALSE) {
                $errors = array_values($this->form_validation->error_array());
                if (isset($input['redirect'])) {
                    $redirect = $input['redirect'];
                }
                $this->generate_page('login', ['errors' => $errors, 'redirect' => $redirect]);
            } else {  //no form validation errors
                $account = $this->account->login($input['email'], $input['password']);
                if ($account) {   //login successfull
                    $account['user_id'] = $account['id'];
                    unset($account['id']);
                    $this->session->set_userdata($account);
                    if ($input['redirect'] === 'complaint-post' && $account['type'] === 'u') {
                        redirect('complaint/post');
                    } else {
                        redirect();
                    }
                } else {
                    if (isset($input['redirect'])) {
                        $redirect = $input['redirect'];
                    }
                    $this->generate_page('login', ['errors' => ['Invalid username/password.'], 'redirect' => $redirect]);
                }
            }
        }
    }

    function existing_email($email) {
        $this->form_validation->set_message("existing_email", "Email doesn't exist.");
        return $this->account->is_existing($email);
    }

    function verified_email($email) {
        $this->form_validation->set_message("verified_email", "Email unverified.");
        if (!$this->account->is_existing($email)) {
            return TRUE;
        }
        return $this->account->is_verified($email);
    }

}
