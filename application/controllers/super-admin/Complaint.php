<?php

defined('BASEPATH') OR exit('No direct script access allowed');

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
        if ($complaints === 'invalid type') {
            redirect('super-admin/complaint?type=pending');
        } else {
            switch ($type) {
                case 'pending' : $type = 'Pending';
                    break;
                case 'ongoing' : $type = 'Ongoing';
                    break;
                case 'solved' : $type = 'Solved';
                    break;
                case 'deleted-declined' : $type = 'Deleted - Declined';
                    break;
                case 'deleted-spam' : $type = 'Deleted - Spam';
                    break;
                case 'deleted-ongoing' : $type = 'Deleted - Ongoing';
                    break;
                case 'deleted-solved' : $type = 'Deleted - Solved';
                    break;
                default: $type = 'Error';
                    break;
            }
            $this->generate_page('super-admin/complaint', ['complaints' => $complaints, 'type' => $type, 'errors' => $errors]);
        }
    }

    public function view() {
        $this->tab_title = 'View Complaint';
        $infos = isset($_SESSION['infos']) ? $_SESSION['infos'] : FALSE;
        $errors = isset($_SESSION['errors']) ? $_SESSION['errors'] : FALSE;
        $id = $this->input->get('id');
        if ($id == '') {
            redirect('super-admin/complaint');
        }
        $complaint = $this->complaint->get($id);

        if ($complaint) {
            $this->load->model('Account_model', 'account');
            $poster_id = $complaint['poster_id'];
            $poster_name = $this->account->get_fullname($poster_id);
            $complaint['id'] = $id;
            $complaint['poster_name'] = $poster_name;
            unset($complaint['poster_id']);
            $complaint['status'] = $this->complaint->get_status($id);
            $complaint['image_filename'] = base_url("uploads/{$complaint['image_filename']}");
            $this->generate_page('super-admin/complaint-view', ['complaint' => $complaint, 'infos' => $infos, 'errors' => $errors]);
        } else {
            $this->session->set_flashdata('errors', ['Complaint not found.']);
            redirect('super-admin/complaint');
        }
    }

    public function edit() {
        $this->tab_title = 'Edit Complaint';
        $infos = FALSE;
        $errors = FALSE;
        $id = $this->input->get('id');
        if ($id == '') {
            redirect('super-admin/complaint');
        }

        $complaint = $this->complaint->get($id);
        if ($complaint) {
            $complaint['id'] = $id;
            $complaint['image_url'] = base_url("uploads/{$complaint['image_filename']}");
        } else {
            $this->session->set_flashdata('errors', ['Complaint not found.']);
            redirect('super-admin/complaint');
        }

        if ($this->input->method(TRUE) === 'GET') {
            $this->generate_page('super-admin/complaint-edit', ['complaint' => $complaint, 'infos' => $infos, 'errors' => $errors]);
        } else {
            $has_errors = $this->validate();
            if ($has_errors) {
                $this->generate_page("super-admin/complaint-edit", ['complaint' => $complaint, 'infos' => $infos, 'errors' => $has_errors]);
            } else {
                $this->load->helper('array');
                $input = $this->input->post();
                $original_image_filename = $complaint['image_filename'];
                $complaint = elements(['category', 'title', 'description'], $input);
                $complaint['id'] = $id;
                $complaint['image_filename'] = (isset($input['image'])) ? $input['image'] : $original_image_filename;
                $complaint['poster_id'] = $this->session->userdata('user_id');
                $complaint['is_anonymous'] = (int) isset($input['is_anonymous']);

                if ($this->complaint->edit($complaint)) {
                    $infos = ['Complaint edit successful.'];
                } else {
                    $errors = ['Complaint edit failed.'];
                }
                $complaint['image_url'] = base_url("uploads/{$complaint['image_filename']}");
                $this->generate_page('super-admin/complaint-edit', ['complaint' => $complaint, 'infos' => $infos, 'errors' => $errors]);
            }
        }
    }

    public function accept() {
        $id = $this->input->get('id');
        if ($id == '') {
            redirect('super-admin/complaint');
        }
        $complaint = $this->complaint->get($id);

        if ($complaint) {
            $success = $this->complaint->accept($id);
            if ($success) {
                $this->session->set_flashdata('infos', ['Status changed to Ongoing.']);
                redirect("super-admin/complaint/view?id={$id}");
            } else {
                $this->session->set_flashdata('errors', ['Complaint cannot be accepted.']);
                redirect("super-admin/complaint/view?id={$id}");
            }
        } else {
            $this->session->set_flashdata('errors', ['Complaint not found.']);
            redirect("super-admin/complaint");
        }
    }

    public function solved() {
        $id = $this->input->get('id');
        if ($id == '') {
            redirect('super-admin/complaint');
        }
        $complaint = $this->complaint->get($id);

        if ($complaint) {
            $success = $this->complaint->solved($id);
            if ($success) {
                $this->session->set_flashdata('infos', ['Status changed to Solved.']);
                redirect("super-admin/complaint/view?id={$id}");
            } else {
                $this->session->set_flashdata('errors', ['Complaint cannot be Marked as Solved.']);
                redirect("super-admin/complaint/view?id={$id}");
            }
        } else {
            $this->session->set_flashdata('errors', ['Complaint not found.']);
            redirect("super-admin/complaint");
        }
    }

    public function delete() {
        $id = $this->input->get('id');
        if ($id == '') {
            redirect('super-admin/complaint');
        }
        $complaint = $this->complaint->get($id);

        if ($complaint) {
            $success = $this->complaint->delete($id);
            if ($success) {
                $this->session->set_flashdata('infos', ['Complaint archived.']);
                redirect("super-admin/complaint/view?id={$id}");
            } else {
                $this->session->set_flashdata('errors', ['Complaint cannot be Deleted.']);
                redirect("super-admin/complaint/view?id={$id}");
            }
        } else {
            $this->session->set_flashdata('errors', ['Complaint not found.']);
            redirect("super-admin/complaint");
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
            return [];
        }
    }

    public function _validate_category($category) {
        $this->form_validation->set_message('_validate_category', 'Please select a valid category.');
        return in_array($category, ['p', 'e', 't']);
    }

}
