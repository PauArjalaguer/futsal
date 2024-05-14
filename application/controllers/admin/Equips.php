<?php

class Equips extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('admin/user_model');
        $this->load->model('admin/equips_model');
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
            $data['get_all_teams'] = $this->equips_model->get_all_teams($session['idClub']);
            $this->load->view('templates/admin/content');
            $this->load->view('admin/equips', $data);
            $this->load->view('templates/admin/footer');
        } else {
            redirect('admin/login', 'refresh');
        }
    }

}

?>