<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MY_Controller {

    protected $tab_title = 'Home';
    

    public function index() {
        $this->load->model('Complaint_model','complaint');
        $this->load->model('Miscellaneous_model','miscellaneous');
        $placemarkers = $this->complaint->get_placemarkers();
        $hotlines = $this->miscellaneous->get_all('hotlines');
        $announcements= $this->miscellaneous->get_all('announcements',5);
        $infos = isset($_SESSION['infos']) ? $_SESSION['infos'] : FALSE;
        $errors = isset($_SESSION['errors']) ? $_SESSION['errors'] : FALSE;
        $this->generate_page('home',['infos' => $infos, 'errors' => $errors, 'placemarkers' => $placemarkers, 
            'hotlines' => $hotlines, 'announcements' => $announcements]);
    }

}
