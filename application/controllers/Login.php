<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends MY_Controller {

    protected $tab_title = 'Login';

    public function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
    }

    public function index() {
        $infos = isset($_SESSION['infos']) ? $_SESSION['infos'] : FALSE;
        $errors = isset($_SESSION['errors']) ? $_SESSION['errors'] : FALSE;
        $redirect = isset($_SESSION['redirect']) ? $_SESSION['redirect'] : FALSE;
        if ($this->input->method(TRUE) === 'GET') {
            $this->generate_page('login', ['infos' => $infos, 'errors' => $errors, 'redirect' => $redirect]);
        } else {
            $this->load->model('Account_model', 'account');
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email|callback_existing_email|callback_verified_email');
            $this->form_validation->set_rules('password', 'Password', 'required');
            $input = $this->input->post();
            if ($this->form_validation->run() == FALSE) {
                $errors = array_values($this->form_validation->error_array());
                $this->generate_page('login', ['infos' => $infos, 'errors' => $errors, 'redirect' => $redirect]);
            } else {
                $account = $this->account->login($input['email'], $input['password']);
                if ($account) {
                    $account['user_id'] = $account['id'];
                    unset($account['id']);
                    $this->session->set_userdata($account);
                    if ($input['redirect'] === 'complaint-post' && $account['type'] === 'u') {
                        redirect('complaint/post');
                    } else if ($input['redirect'] === 'complaint-post' &&
                            ($account['type'] === 'g' || $account['type'] === 'sa')) {
                        $this->session->set_flashdata('errors', ['Post Complaint is only available for user accounts.']);
                        redirect('home');
                    } else {
                        redirect();
                    }
                } else {
                    $this->generate_page('login', ['infos' => $infos, 'errors' => ['Invalid username/password.'], 'redirect' => $redirect]);
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
