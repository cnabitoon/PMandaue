<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Complaint extends MY_Controller {

    protected $tab_title = '';

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('user_id')) {
            redirect('login');
            //$this->generate_page('login',['errors' => ['Please login to post a complaint']]);
        }
        $this->load->library('form_validation');
    }

    public function post() {
        $this->tab_title = 'Post Complaint';

        $errors = FALSE;
        if ($this->input->method(TRUE) === 'GET') {
            $this->generate_page('post-complaint', ['errors' => $errors]);
        } else { //POST
            $this->load->model('Complaint_model', 'complaint');
            $this->load->helper('array');
            $this->form_validation->set_rules('title', 'Title', 'required');
            $this->form_validation->set_rules('description', 'Description', 'required');
            $this->form_validation->set_rules('image', 'Image', 'callback_handle_upload');

            if ($this->form_validation->run() == FALSE) {
                $errors = array_values($this->form_validation->error_array());
                $this->generate_page('post-complaint', ['errors' => $errors]);
            }else {  //no form validation errors
                $input = $this->input->post();
                $complaint = elements(['category', 'title', 'description'], $input);
                $complaint['datetime_posted'] = date('Y-m-d H:i:s');
                $complaint['location'] = '';
                $complaint['barangay'] = '';
                $complaint['latitude'] = 0;
                $complaint['longitude'] = 0;
                $complaint['image_filename'] = $input['image'];
                $complaint['poster_id'] = $this->session->user_id;
                if(isset($_POST['is_anonymous'])){
                    $complaint['is_anonymous'] = 1;
                }else{
                    $complaint['is_anonymous'] = 0;
                }
                if ($this->complaint->create($complaint)){
                    echo "Complaint created.";
                } else {
                    echo "Complaint creation failed.";
                }
            }
        }
    }

    function handle_upload() {
        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'jpg';
        $config['max_size'] = 100;
        $config['max_width'] = 1024;
        $config['max_height'] = 768;

        $this->load->library('upload', $config);

        if (isset($_FILES['image']) && !empty($_FILES['image']['name'])) {
            if ($this->upload->do_upload('image')) {
                // set a $_POST value for 'image' that we can use later
                $upload_data = $this->upload->data();
                $_POST['image'] = $upload_data['file_name'];
                return true;
            } else {
                // possibly do some clean up ... then throw an error
                $this->form_validation->set_message('handle_upload', $this->upload->display_errors());
                return false;
            }
        } else {
            // throw an error because nothing was uploaded
            $this->form_validation->set_message('handle_upload', "You must upload an image!");
            return false;
        }
    }

}