<?php

class Index extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('admin/user_model');
        $this->load->model('admin/log_model');
        $this->load->model('admin/mail_model');
    }

    function index() {
        if ($this->session->userdata('logged_in')) {
            $session = $this->session->userdata('logged_in');
            $this->load->view('templates/admin/header', $session);

            $data['get_mail_notread'] = $this->mail_model->get_mail_notread($session['id']);
            $this->load->view('templates/admin/notifications', $data);

            $data['get_user_permissions'] = $this->user_model->get_user_permissions($session['id']);
            $this->load->view('admin/menu', $data);
            $this->load->view('templates/admin/content', $session);
        } else {
            //If no session, redirect to login page
            redirect('admin/login', 'refresh');
        }
    }

    function logout() {
        $session = $this->session->userdata('logged_in');

        $this->log_model->insert_log($session['id'], 0, 'ha fet logout.');
        $this->session->unset_userdata('logged_in');
        session_destroy();
        redirect('init_controller', 'refresh');
    }

}

?>