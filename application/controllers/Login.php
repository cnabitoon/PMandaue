<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends MY_Controller {

    protected $tab_title = 'Login';

    public function __construct() {
        parent::__construct();
        if ($this->session->userdata('user_id')) {
            redirect();
        }
        $this->load->library('form_validation');
    }

    public function index() {
        $infos = isset($_SESSION['infos']) ? $_SESSION['infos'] : FALSE;
        $errors = isset($_SESSION['errors']) ? $_SESSION['errors'] : FALSE;
        if ($this->input->method(TRUE) === 'GET') {
            $redirect = isset($_SESSION['redirect']) ? $_SESSION['redirect'] : FALSE;
            $this->generate_page('login', ['infos' => $infos, 'errors' => $errors, 'redirect' => $redirect]);
        } else {
            $this->load->model('Account_model', 'account');
            $this->form_validation->set_rules('username', 'Username', 'required|callback__existing_account|callback__verified_account');
            $this->form_validation->set_rules('password', 'Password', 'required');
            $input = $this->input->post();
            if ($this->form_validation->run() == FALSE) {
                $errors = array_values($this->form_validation->error_array());
                $this->generate_page('login', ['infos' => $infos, 'errors' => $errors, 'redirect' => $input['redirect']]);
            } else {
                $account = $this->account->login($input['username'], $input['password']);
                if ($account) {
                    $account['user_id'] = $account['id'];
                    unset($account['id']);
                    $this->session->set_userdata($account);

                    if ($input['redirect'] === 'complaint-post') {
                        if ($account['type'] === 'u') { //standard user
                            redirect('complaint/post');
                        } else {
                            $this->session->set_flashdata('errors', ['Post Complaint is only available for standard user accounts.']);
                            redirect();
                        }
                    }else{
                        if($account['type'] === 'sa'){  //super admin
                            redirect('super-admin/complaint?type=pending');
                        }else if($account['type'] === 'g'){  //government
                            redirect('government/complaint?type=pending');
                        }else{  //standard user
                            redirect();
                        }
                    }
                } else {
                    $this->generate_page('login', ['infos' => $infos, 'errors' => ['Invalid username/password.'], 'redirect' => $input['redirect']]);
                }
            }
        }
    }

    function _existing_account($username) {
        $this->form_validation->set_message("_existing_account", "Account doesn't exist.");
        return $this->account->is_existing($username);
    }

    function _verified_account($username) {
        $this->form_validation->set_message("_verified_account", "Account unverified.");
        if (!$this->account->is_existing($username)) {
            return TRUE;
        }
        return $this->account->is_verified($username);
    }

}
