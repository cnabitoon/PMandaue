<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Complaint extends MY_Controller {

    protected $tab_title = '';

    public function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
    }

    public function index() {
        redirect();
    }

    public function post() {
        $this->tab_title = 'Post Complaint';

        if (!$this->session->userdata('user_id')) {
            $this->session->set_flashdata('errors', ['Please login to post a complaint.']);
            $this->session->set_flashdata('redirect', 'complaint-post');
            redirect('login');
        }

        if ($this->session->userdata('type') !== 'u') {
            $this->session->set_flashdata('errors', ['Post Complaint is only available for user accounts.']);
            redirect();
        }

        $errors = FALSE;
        if ($this->input->method(TRUE) === 'GET') {
            $this->generate_page('complaint-post', ['errors' => $errors]);
        } else {
            $this->load->model('Complaint_model', 'complaint');
            $this->load->helper('array');
            $has_errors = $this->validate();

            if ($has_errors) {
                $this->generate_page('complaint-post', ['errors' => $has_errors]);
            } else {
                $input = $this->input->post();
                $complaint = elements(['category', 'title', 'description'], $input);
                $complaint['location'] = '';
                $complaint['barangay'] = '';
                $complaint['latitude'] = 0;
                $complaint['longitude'] = 0;
                $complaint['image_filename'] = $input['image'];
                $complaint['poster_id'] = $this->session->userdata('user_id');
                $complaint['is_anonymous'] = (int) isset($input['is_anonymous']);

                if ($this->complaint->add($complaint)) {
                    $this->session->set_flashdata('infos', ['Complaint created.']);
                    redirect();
                } else {
                    $this->generate_page('complaint-post', ['errors' => 'Complaint creation failed.']);
                }
            }
        }
    }

    public function validate() {
        $errors = [];
        $this->form_validation->set_rules('category', 'Category', 'callback__validate_category');
        $this->form_validation->set_rules('title', 'Title', 'required');
        $this->form_validation->set_rules('description', 'Description', 'required');
        if ($this->form_validation->run() == FALSE) {
             $errors = array_merge($errors, array_values($this->form_validation->error_array()));
        } else {
            $upload_errors = $this->handle_upload();
            if ($upload_errors) {
                $errors = array_merge($errors, $upload_errors);
            }
        }
        return $errors;
    }

    function handle_upload() {
        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'jpg|jpeg|png';
        $config['max_size'] = 100;
        $config['max_width'] = 1024;
        $config['max_height'] = 768;

        $this->load->library('upload', $config);

        if (isset($_FILES['image']) && !empty($_FILES['image']['name'])) {
            if ($this->upload->do_upload('image')) {
                $upload_data = $this->upload->data();
                $_POST['image'] = $upload_data['file_name'];
                return [];
            } else {
                return array_filter(explode(',', $this->upload->display_errors('', ',')));
            }
        } else {
            return ['You must upload an image!'];
        }
    }
    
    public function _validate_category($category){
        $this->form_validation->set_message('_validate_category', 'Please select a valid category.');
        return in_array($category, ['p', 'e', 't']);
    }


}
