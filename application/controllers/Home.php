<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MY_Controller {

    protected $tab_title = 'Home';
    

    public function index() {
        $this->load->model('Complaint_model','complaint');
        $placemarkers = $this->complaint->get_placemarkers();
        $infos = isset($_SESSION['infos']) ? $_SESSION['infos'] : FALSE;
        $errors = isset($_SESSION['errors']) ? $_SESSION['errors'] : FALSE;
        $this->generate_page('home',['infos' => $infos, 'errors' => $errors, 'placemarkers' => $placemarkers]);
    }

}
