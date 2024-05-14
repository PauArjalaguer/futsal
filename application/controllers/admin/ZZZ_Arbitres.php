<?php

class Arbitres extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('admin/arbitre_model');
          $this->load->model('admin/competicio_model');
        $this->load->model('admin/user_model');
        $this->load->model('admin/log_model');
        $this->load->model('admin/Cache_model');
        $this->load->model('admin/mail_model');
        $this->load->helper('functions_helper');
        $this->load->library('table');
        $this->load->helper('form');
    }

    public function index() {
         if ($this->session->userdata('logged_in')) {
            $session = $this->session->userdata('logged_in');
            $idReferee=$session['idReferee'];
            $this->load->view('templates/admin/header', $session);
            $data['get_mail_notread'] = $this->mail_model->get_mail_notread($session['id']);
            $this->load->view('templates/admin/notifications', $data);
            $data['get_user_permissions'] = $this->user_model->get_user_permissions($session['id']);
            //print_r($session);
            $this->load->view('admin/menu', $data);
            $this->load->view('templates/admin/content');
            $data['get_all_referees'] = $this->arbitre_model->get_all_referees();
               $data['get_delegations'] = $this->arbitre_model->get_delegations();
           //echo "<pre>"; print_r($data); echo "</pre>";
                  $this->load->view('admin/arbitres_llistat', $data);
            $this->load->view('templates/admin/footer');
        } else {
            redirect('admin/login', 'refresh');
        }
    }
      function nou() {
        if ($this->session->userdata('logged_in')) {
            $session = $this->session->userdata('logged_in');
            $idReferee = $this->arbitre_model->insert_referee();
            $this->log_model->insert_log($session['id'], $idReferee, 'ha creat l\' arbitre');
            redirect("admin/arbitre/edita/".$idReferee);
        } else {
            redirect('admin/login', 'refresh');
        }
    }
}
    