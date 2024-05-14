<?php

class Gestio_partits extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('admin/clubs_model');
        $this->load->model('admin/user_model');
        $this->load->model('admin/log_model');
        $this->load->model('admin/mail_model');
        $this->load->model('admin/Cache_model');
        $this->load->model('admin/Competicio_model');
        $this->load->helper('functions_helper');
        $this->load->library('table');
        $this->load->helper('form');
    }

    public function index() {
        if ($this->session->userdata('logged_in')) {
            $session = $this->session->userdata('logged_in');
            $this->load->view('templates/admin/header', $session);
            $data['get_mail_notread'] = $this->mail_model->get_mail_notread($session['id']);
            $this->load->view('templates/admin/notifications', $data);
            $data['get_user_permissions'] = $this->user_model->get_user_permissions($session['id']);
            $this->load->view('admin/menu', $data);
            $this->load->view('templates/admin/content');
            $data['get_matches_by_idClub'] = $this->Competicio_model->get_matches_by_idClub($session['idClub']);
            
            // echo "<pre>";print_r($data);echo "</pre>";
            $this->load->view('admin/gestio_partits', $data);
            $this->load->view('templates/admin/footer');
        } else {
            redirect('admin/login', 'refresh');
        }
    }

    public function partit($idMatch) {
        if ($this->session->userdata('logged_in')) {
            $session = $this->session->userdata('logged_in');
            $this->load->view('templates/admin/header', $session);
            
            $data['get_mail_notread'] = $this->mail_model->get_mail_notread($session['id']);
            $this->load->view('templates/admin/notifications', $data);
            
            $data['get_user_permissions'] = $this->user_model->get_user_permissions($session['id']);
            $this->load->view('admin/menu', $data);
            
            $this->load->view('templates/admin/content');
            $data = $this->Competicio_model->get_match_info($idMatch);
            $data['get_last_date_change_by_idMatch']=$this->Competicio_model->get_last_date_change_by_idMatch($idMatch);
            $data['get_all_complex'] = $this->Competicio_model->get_all_complex();

            $this->load->view('admin/gestio_partit', $data);
            $this->load->view('templates/admin/footer');
        } else {
            redirect('admin/login', 'refresh');
        }
    }

    function modifica_partit($idMatch) {
        if ($this->session->userdata('logged_in')) {
            $session = $this->session->userdata('logged_in');
            $data['get_user_permissions'] = $this->user_model->get_user_permissions($session['id']);
            $data = $this->Competicio_model->get_match_info($idMatch);
            
            if (invertdateformat($_POST['matchDate']) == $data['initialDate'] || invertdateformat($_POST['matchDate']) == $data['endDate']) {
               // echo "DINS LA JORNADA";
                $this->Competicio_model->update_match_info($idMatch);
                $this->log_model->insert_log($session['id'], $idMatch, 'ha modificat la data del partit ');
            } else {
                $this->log_model->insert_log($session['id'], $idMatch, 'ha solicitat el canvi de data del partit ');
                $this->mail_model->insert_mail($session['name'], $data['visitorName'], "FCFS - Canvi d\' horari de partit"," sol·licita el canvi del partit " . $data['localName'] . " - " . $data['visitorName'] . " (jornada " . $data['roundName'] . " de " . $data['leagueName'] . ") a " . $_POST['matchDate'], $data['account1'], $data['account2']);
                $data = $this->Competicio_model->insert_date_change($idMatch, $data['idLocal']);
            }
            // echo "data inici jornada: " . $data['initialDate'] . " data final: " . $data['endDate'] . " DATA PROPOSADA:" . invertdateformat($_POST['matchDate']);
            redirect('admin/gestio_partits/partit/' . $idMatch, 'refresh');
        } else {
            //If no session, redirect to login page
            redirect('admin/login', 'refresh');
        }
    }

}
