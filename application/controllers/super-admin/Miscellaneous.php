<?php

defined('BASEPATH') OR exit('No direct script access allowed');

//super-admin
class Miscellaneous extends MY_Controller {

    protected $tab_title = '';

    public function __construct() {
        parent::__construct();
        if ($this->session->userdata('type') !== 'sa') {
            show_error('Unauthorized', "401");
        }
        $this->load->model('Miscellaneous_model', 'miscellaneous');
        $this->load->library('form_validation');
    }

    public function index() {
        $this->tab_title = 'Miscellaneous';
        $errors = isset($_SESSION['errors']) ? $_SESSION['errors'] : FALSE;
        $type = ($this->input->get('type') == '') ? 'hotlines' : $this->input->get('type');
        $miscellaneous = $this->miscellaneous->get_all($type);
        if ($miscellaneous === 'invalid type') {
            redirect('super-admin/miscellaneous?type=hotlines');
        } else {
            $this->generate_page('super-admin/miscellaneous', ['miscellaneous' => $miscellaneous, 'type' => ucfirst($type), 'errors' => $errors]);
        }
    }

    public function add_hotline() {
        $infos = isset($_SESSION['infos']) ? $_SESSION['infos'] : FALSE;
        $errors = isset($_SESSION['errors']) ? $_SESSION['errors'] : FALSE;
        if ($this->input->method(TRUE) === 'GET') {
            $this->generate_page('super-admin/hotline-add', ['infos' => $infos, 'errors' => $errors]);
        } else {
            $this->form_validation->set_rules('title', 'Title', 'required');
            $this->form_validation->set_rules('number', 'Number', 'required');
            if ($this->form_validation->run() == FALSE) {
                $errors = array_values($this->form_validation->error_array());
                $this->generate_page('super-admin/hotline-add', ['infos' => $infos, 'errors' => $errors]);
            } else {
                $input = $this->input->post();
                $this->load->helper('array');
                $hotline = elements(['title', 'number'], $input);
                if ($this->miscellaneous->add_hotline($hotline)) {
                    $infos = ["Hotline added ({$hotline['title']} - {$hotline['number']})."];
                } else {
                    $errors = ['Hotline addition failed.'];
                }
                $this->generate_page('super-admin/hotline-add', ['infos' => $infos, 'errors' => $errors]);
            }
        }
    }

    public function add_announcement() {
        $infos = isset($_SESSION['infos']) ? $_SESSION['infos'] : FALSE;
        $errors = isset($_SESSION['errors']) ? $_SESSION['errors'] : FALSE;
        if ($this->input->method(TRUE) === 'GET') {
            $this->generate_page('super-admin/announcement-add', ['infos' => $infos, 'errors' => $errors]);
        } else {
            $this->form_validation->set_rules('title', 'Title', 'required');
            $this->form_validation->set_rules('description', 'Description', 'required');
            if ($this->form_validation->run() == FALSE) {
                $errors = array_values($this->form_validation->error_array());
                $this->generate_page('super-admin/announcement-add', ['infos' => $infos, 'errors' => $errors]);
            } else {
                $input = $this->input->post();
                $this->load->helper('array');
                $announcement = elements(['title', 'description'], $input);
                if ($this->miscellaneous->add_announcement($announcement)) {
                    $infos = ["Announcement added ({$announcement['title']})."];
                } else {
                    $errors = ['Announcement addition failed.'];
                }
                $this->generate_page('super-admin/announcement-add', ['infos' => $infos, 'errors' => $errors]);
            }
        }
    }

    public function delete_hotline() {
        $id = $this->input->get('id');

        if ($id == '') {
            redirect('super-admin/miscellaneous');
        }

        $hotline = $this->miscellaneous->get_hotline($id);

        if ($hotline) {
            $success = $this->miscellaneous->delete_hotline($id);
            if ($success) {
                $this->session->set_flashdata('infos', ['Hotline deleted.']);
                redirect("super-admin/miscellaneous?type=hotlines");
            } else {
                $this->session->set_flashdata('errors', ['Hotline cannot be deleted.']);
                redirect("super-admin/miscellaneous?type=hotlines");
            }
        } else {
            $this->session->set_flashdata('errors', ['Hotline not found.']);
            redirect("super-admin/miscellaneous?type=hotlines");
        }
    }

    public function delete_announcement() {
        $id = $this->input->get('id');

        if ($id == '') {
            redirect('super-admin/miscellaneous');
        }

        $announcement = $this->miscellaneous->get_announcement($id);

        if ($announcement) {
            $success = $this->miscellaneous->delete_announcement($id);
            if ($success) {
                $this->session->set_flashdata('infos', ['Announcement deleted.']);
                redirect("super-admin/miscellaneous?type=announcements");
            } else {
                $this->session->set_flashdata('errors', ['Announcement cannot be deleted.']);
                redirect("super-admin/miscellaneous?type=announcements");
            }
        } else {
            $this->session->set_flashdata('errors', ['Announcement not found.']);
            redirect("super-admin/miscellaneous?type=announcements");
        }
    }

}
