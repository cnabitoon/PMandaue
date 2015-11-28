<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MY_Controller {

    protected $tab_title = 'Home';

    public function index() {
        $infos = FALSE;
        if (isset($_SESSION['infos'])) {
            $infos = $_SESSION['infos'];
        }
        $this->generate_page('home',['infos' => $infos]);
    }

}
