<?php

class Equip extends CI_Controller {

    private $idSeason;

    function __construct() {
        parent::__construct();
        $this->load->model('admin/user_model');
        $this->load->model('admin/equips_model');
        $this->load->model('admin/mail_model');
        $this->load->helper('form');
        $this->idSeason = CURRENT_SEASON;
    }

    function index($idTeam) {
        if ($this->session->userdata('logged_in')) {
            $session = $this->session->userdata('logged_in');
            $this->load->view('templates/admin/header', $session);
            $data['get_mail_notread'] = $this->mail_model->get_mail_notread($session['id']);
            $this->load->view('templates/admin/notifications', $data);
            $data['get_user_permissions'] = $this->user_model->get_user_permissions($session['id']);
            $this->load->view('admin/menu', $data);
            // unset($data);
            $data = $this->equips_model->get_team_info($idTeam, $session['idClub']);

            $data['get_players_by_idTeam_and_idClub'] = $this->equips_model->get_players_by_idTeam_and_idClub($idTeam, $session['idClub'], $this->idSeason);
            $data['get_cards_by_idTeam'] = $this->equips_model->get_cards_by_idTeam($idTeam, $session['idClub'], $this->idSeason);
            $data['get_scorers_by_idTeam'] = $this->equips_model->get_scorers_by_idTeam($idTeam, $session['idClub'], $this->idSeason);
            $this->load->view('templates/admin/content');
            $this->load->view('admin/equip', $data);
            $this->load->view('templates/admin/footer');
        } else {
            //If no session, redirect to login page
            redirect('admin/login', 'refresh');
        }
    }

}

?>