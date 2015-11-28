<?php

class Account extends MY_Controller {

    protected $tab_title = '';

    public function index() {
        redirect();
    }

    public function verify() {
        $infos = FALSE; $errors = FALSE; 
        if ($this->session->userdata('user_id')) {
            $errors = ['Account verification failed. Please logout first.'];
        } else {
            $email = $this->input->get('email');
            $verification_code = $this->input->get('code');
            $this->load->model('Account_model', 'account');

            if ($this->account->verify($email, $verification_code)) {
                $infos = ['Account verification success', 'You may now login.'];
            } else {
                $errors = ['Account verification failed.'];
            }
        }

        $this->session->set_flashdata('errors', $errors);
        $this->session->set_flashdata('infos', $infos);
        redirect();
    }

}
