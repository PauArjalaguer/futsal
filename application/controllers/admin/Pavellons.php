<?php

class Pavellons extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('admin/arbitre_model');
        $this->load->model('admin/pavellons_model');
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
            $idReferee = $session['idReferee'];
            $this->load->view('templates/admin/header', $session);
            $data['get_mail_notread'] = $this->mail_model->get_mail_notread($session['id']);
            $this->load->view('templates/admin/notifications', $data);
            $data['get_user_permissions'] = $this->user_model->get_user_permissions($session['id']);
            //print_r($session);
            $this->load->view('admin/menu', $data);
            $this->load->view('templates/admin/content');
            $data['get_all_complex'] = $this->pavellons_model->get_all_complex();
            $this->load->view('admin/pavellons_llistat', $data);
            $this->load->view('templates/admin/footer');
        } else {
            redirect('admin/login', 'refresh');
        }
    }

    function nou() {
        if ($this->session->userdata('logged_in')) {
            $session = $this->session->userdata('logged_in');
            $idComplex = $this->pavellons_model->insert_complex();
            $this->log_model->insert_log($session['id'], $idComplex, 'ha creat el pavelló');
            $this->calcula_kilometratge($idComplex);
            redirect("admin/pavellons/edita/" . $idComplex);
        } else {
            redirect('admin/login', 'refresh');
        }
    }

    public function edita($idComplex) {
        if ($this->session->userdata('logged_in')) {
            $session = $this->session->userdata('logged_in');
            $this->load->view('templates/admin/header', $session);
            $data['get_mail_notread'] = $this->mail_model->get_mail_notread($session['id']);
            $this->load->view('templates/admin/notifications', $data);
            $data['get_user_permissions'] = $this->user_model->get_user_permissions($session['id']);
            $this->load->view('admin/menu', $data);
            $this->load->view('templates/admin/content');

            $data = $this->pavellons_model->get_complex_info($idComplex);
            $data['get_distance_to_delegations'] = $this->pavellons_model->get_distance_to_delegations($idComplex);

            $this->load->view('admin/pavellons_edita', $data);

            $this->load->view('templates/admin/footer');
        } else {
            redirect('admin/login', 'refresh');
        }
    }

    function modifica($idComplex) {
        if ($this->session->userdata('logged_in')) {
            $session = $this->session->userdata('logged_in');
            $this->pavellons_model->update_complex_info();
            $this->log_model->insert_log($session['id'], $idComplex, 'ha modificat el pavelló');
            $this->calcula_kilometratge($idComplex);
            redirect("admin/pavellons/edita/" . $idComplex);
        } else {
            redirect('admin/login', 'refresh');
        }
    }

    function calcula_kilometratge($idComplex) {
        $data = $this->pavellons_model->get_complex_info($idComplex);
        $complexAddress = $data['complexAddress'];
        $data = $this->pavellons_model->get_delegations();

        foreach ($data as $del) {
            $idDelegation = $del->idDelegation;
            // echo "<hr />" . $del->idDelegation . " - $complexAddress a " . $del->delegationAddress;
            $from = urlencode($complexAddress);
            $to = urlencode($del->delegationAddress);

            $d = file_get_contents("http://maps.googleapis.com/maps/api/distancematrix/json?origins=$from&destinations=$to&language=en-EN&sensor=false");

            $d = json_decode($d);
            //echo "<pre>"; print_r($data);echo "</pre>";
            $distance = intval($d->rows[0]->elements[0]->distance->text);
            // echo " - Distancia: $distance km";

            $this->pavellons_model->update_delegation_distance($idComplex, $idDelegation, $distance);
        }
    }

    function fusiona($idComplex) {
        if ($this->session->userdata('logged_in')) {
            $session = $this->session->userdata('logged_in');
            $this->load->view('templates/admin/header', $session);
            $data['get_mail_notread'] = $this->mail_model->get_mail_notread($session['id']);
            $this->load->view('templates/admin/notifications', $data);
            $data['get_user_permissions'] = $this->user_model->get_user_permissions($session['id']);
            $this->load->view('admin/menu', $data);
            $this->load->view('templates/admin/content');
            $data = $this->pavellons_model->get_complex_info($idComplex);
            $data['get_all_complex'] = $this->pavellons_model->get_all_complex();

            $this->load->view('admin/pavellons_fusiona', $data);

            $this->load->view('templates/admin/footer');
        } else {
            redirect('admin/login', 'refresh');
        }
    }

    function fusiona_pavello($idAEliminar, $idComplex) {
        $this->pavellons_model->update_complex_matches_to_fused_complex($idAEliminar, $idComplex);
        if ($this->session->userdata('logged_in')) {
            $session = $this->session->userdata('logged_in');
            $this->log_model->insert_log($session['id'], $idComplex, 'ha fusionat el pavelló');
        }
        redirect("admin/pavellons/fusiona/" . $idComplex);
    }

}
