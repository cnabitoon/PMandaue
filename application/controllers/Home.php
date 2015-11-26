<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MY_Controller {

    protected $tab_title = 'Home';
    
    public function index() {
        $this->generate_page('home');
    }
    
}
