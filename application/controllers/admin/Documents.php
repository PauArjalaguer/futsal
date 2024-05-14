<?php

class Documents extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('admin/user_model');
        $this->load->model('admin/Documents_model');
        $this->load->model('admin/mail_model');
        $this->load->model('admin/log_model');

        $this->load->library('table');
        $this->load->helper('form');
        $this->load->helper('functions_helper');
    }

    function index() {
        if ($this->session->userdata('logged_in')) {
            $session = $this->session->userdata('logged_in');
            $this->load->view('templates/admin/header', $session);

            $data['get_mail_notread'] = $this->mail_model->get_mail_notread($session['id']);
            $this->load->view('templates/admin/notifications', $data);

            $data['get_user_permissions'] = $this->user_model->get_user_permissions($session['id']);
            $this->load->view('admin/menu', $data);
            $data['get_all_documents'] = $this->Documents_model->get_all_documents();

            $this->load->view('templates/admin/content');
            $this->load->view('admin/documents_llistat', $data);
            $this->load->view('templates/admin/footer');
        } else {
//If no session, redirect to login page
            redirect('admin/login', 'refresh');
        }
    }

    function edita($id) {
        if ($this->session->userdata('logged_in')) {
            $session = $this->session->userdata('logged_in');
            $this->load->view('templates/admin/header', $session);

            $data['get_mail_notread'] = $this->mail_model->get_mail_notread($session['id']);
            $this->load->view('templates/admin/notifications', $data);

            $data['get_user_permissions'] = $this->user_model->get_user_permissions($session['id']);
            $data['get_all_categories'] = $this->Documents_model->get_all_categories();
            $this->load->view('admin/menu', $data);
            $data = $this->Documents_model->get_document_by_id($id);

            $this->load->view('templates/admin/content');
            $this->load->view('admin/documents_edita', $data);
            $this->load->view('templates/admin/footer');
        } else {
//If no session, redirect to login page
            redirect('admin/login', 'refresh');
        }
    }

    public function modifica($id) {
        if ($this->session->userdata('logged_in')) {
            $session = $this->session->userdata('logged_in');
            $idSeason = $session['idSeason'];
            $this->Documents_model->update_document($id);
            $this->log_model->insert_log($session['id'], $id, 'ha modificat el document');

            redirect("admin/documents/edita/" . $id);
        } else {
            redirect('admin/login', 'refresh');
        }
    }

    public function esborra($id) {
        if ($this->session->userdata('logged_in')) {
            $session = $this->session->userdata('logged_in');
            $this->Documents_model->delete_document($id);
            $this->log_model->insert_log($session['id'], $id, 'ha eliminat el document');

            redirect("admin/documents");
        } else {
            redirect('admin/login', 'refresh');
        }
    }

    public function puja_arxiu($id) {
        if ($this->session->userdata('logged_in')) {
            $session = $this->session->userdata('logged_in');
            if (!empty($_FILES)) {
                $tempFile = $_FILES['file']['tmp_name'];
                $fileName = "content/documentacio/" . $_FILES['file']['name'];
                $targetFile = $fileName;


                if (move_uploaded_file($tempFile, $targetFile)) {
                    $this->Documents_model->insert_document($_FILES['file']['name']);
                    $this->log_model->insert_log($session['id'], 2, 'ha insertat un documents');

                    echo json_encode($name);
                }
            }
        } else {
            redirect('admin/login', 'refresh');
        }
    }

}
