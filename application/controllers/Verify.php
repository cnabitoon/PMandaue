<?php

class Verify extends MY_Controller {
    
    protected $tab_title = 'Home';


    public function account(){
        $email = $this->input->get('email');
        $verification_code = $this->input->get('code');
        $this->load->model('Account_model', 'account');
        if($this->account->verify($email, $verification_code)){
            echo "Account Verified";
        }else{
            echo "Verification failed";
        }
        $this->generate_page('home');
    }
}
