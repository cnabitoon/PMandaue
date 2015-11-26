<?php


class MY_Controller extends CI_Controller {
  
    private $view_data = [];
    
    public function __construct(){
        parent::__construct();
    }
    
    public function generate_page($view, $data = FALSE){
        $this->view_data['content'] = $this->load->view($view, $data, TRUE);
        $this->view_data['tab_title'] = $this->tab_title;
        $this->load->view('layout', $this->view_data);
    }
}
