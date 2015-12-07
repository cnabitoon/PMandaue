<?php

defined('BASEPATH') OR exit('No direct script access allowed');

//super-admin
class Account extends MY_Controller {

    protected $tab_title = '';

    public function __construct() {
        parent::__construct();
        if ($this->session->userdata('type') !== 'sa') {
            show_error('Unauthorized', "401");
        }
    }

    public function index() {
        $this->tab_title = 'Accounts';
        $this->generate_page('super-admin/account');
    }
    
}
