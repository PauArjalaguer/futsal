<?php

class Comite extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('admin/user_model');
        $this->load->model('admin/competicio_model');
        $this->load->model('admin/Cache_model');
        $this->load->model('admin/log_model');
        $this->load->model('admin/mail_model');
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
            $data['get_all_finished_matches'] = $this->competicio_model->get_all_finished_matches();

            $this->load->view('templates/admin/content');
            $this->load->view('admin/comite_llistat', $data);
            $this->load->view('templates/admin/footer');
        } else {
//If no session, redirect to login page
            redirect('admin/login', 'refresh');
        }
    }

}
