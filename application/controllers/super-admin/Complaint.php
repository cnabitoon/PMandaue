<?php

//super-admin
class Complaint extends MY_Controller {

    protected $tab_title = '';

    public function __construct() {
        parent::__construct();
        if ($this->session->userdata('type') !== 'sa') {
            show_error('Unauthorized', "401");
        }
        $this->load->model('Complaint_model', 'complaint');
        $this->load->library('form_validation');
    }

    public function index() {
        $errors = isset($_SESSION['errors']) ? $_SESSION['errors'] : FALSE;
        $this->tab_title = 'View All Complaints';
        $type = ($this->input->get('type') == '') ? 'pending' : $this->input->get('type');
        $complaints = $this->complaint->get_all($type);
        $this->generate_page('super-admin/complaint-view-all', ['complaints' => $complaints, 'type' => ucfirst($type), 'errors' => $errors]);    
    }

    public function view(){
        $this->tab_title = 'View Complaint';
        $id = $this->input->get('id');
        if($id == ''){
            redirect('super-admin/complaint');
        }
        $complaint = $this->complaint->get($id);
        
        if($complaint){
            $this->load->model('Account_model', 'account');
            $poster_id = $complaint['poster_id'];
            $poster_name = $this->account->get_fullname($poster_id);
            $complaint['id'] = $id;
            $complaint['poster_name'] = $poster_name;
            unset($complaint['poster_id']);
            $complaint['status'] = $this->complaint->get_status($id);
            $complaint['image_filename'] = base_url("uploads/{$complaint['image_filename']}");
            $this->generate_page('super-admin/complaint-view',['complaint' => $complaint]);
        }else{
            $this->session->set_flashdata('errors', ['Complaint not found.']);
            redirect('super-admin/complaint');
        }
    }
    
    public function edit(){
        $this->tab_title = 'Edit Complaint';
        $errors = FALSE;
        $id = $this->input->get('id');
        if($this->input->method(TRUE) === 'GET'){
            if($id == ''){
                redirect('super-admin/complaint');
            }
            $complaint = $this->complaint->get($id);

            if($complaint){
                $complaint['id'] = $id;
                $complaint['image_filename'] = base_url("uploads/{$complaint['image_filename']}");
                $this->generate_page('super-admin/complaint-edit',['complaint' => $complaint, 'errors' => $errors]);
            }else{
                $this->session->set_flashdata('errors', ['Complaint not found.']);
                redirect('super-admin/complaint');
            }
        }else{
            $has_errors = $this->validate();
            if($has_errors){
                
            }else{
                
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
    
    public function _validate_category($category){
        $this->form_validation->set_message('_validate_category', 'Please select a valid category.');
        return in_array($category, ['p', 'e', 't']);
    }
    
}
