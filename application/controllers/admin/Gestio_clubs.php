<?php

class Gestio_clubs extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('admin/clubs_model');
        $this->load->model('admin/equips_model');
        $this->load->model('admin/competicio_model');
        $this->load->model('admin/jugador_model');
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
            $this->load->view('templates/admin/header', $session);

            $data['get_mail_notread'] = $this->mail_model->get_mail_notread($session['id']);
            $this->load->view('templates/admin/notifications', $data);

            $data['get_user_permissions'] = $this->user_model->get_user_permissions($session['id']);
            $this->load->view('admin/menu', $data);
            // unset($data);

            $data['get_all_clubs'] = $this->clubs_model->get_all_clubs();
            // echo "<pre>"; print_r($data); echo "</pre>";
            $this->load->view('templates/admin/content');
            $this->load->view('admin/gestio_clubs', $data);
            $this->load->view('templates/admin/footer');
        } else {
            //If no session, redirect to login page
            redirect('admin/login', 'refresh');
        }
    }

    public function cache_control($id) {
        $data = $this->Cache_model->select_cache_entries($id, 'clubs');
        $url = $data['urlString'];
        $u = explode(";", $url);
        for ($a = 0; $a < count($u); $a++) {
            if ($u[$a] == 'init') {
                echo "delete init";
                $this->output->delete_cache("/");
            }
            $this->output->delete_cache($u[$a]);
        }
        $this->Cache_model->delete_cache_entries($id, 'clubs');
        $data = $this->clubs_model->get_club_info($id);
        $url = '/clubs;';
        $url .= "/clubs/info/" . $id . "-" . teamUrlFormat($data['name']);
        $this->Cache_model->insert_cache_entries($id, 'clubs', $url);
    }

    function nou() {
        if ($this->session->userdata('logged_in')) {
            $session = $this->session->userdata('logged_in');
            $idClub = $this->clubs_model->insert_club();
            $this->log_model->insert_log($session['id'], $idClub, 'ha creat el club');
            redirect("admin/gestio_clubs/edita/" . $idClub);
        } else {
            redirect('admin/login', 'refresh');
        }
    }

    public function edita($idClub) {
        if ($this->session->userdata('logged_in')) {
            $session = $this->session->userdata('logged_in');
            $this->load->view('templates/admin/header', $session);
            $data['get_mail_notread'] = $this->mail_model->get_mail_notread($session['id']);
            $this->load->view('templates/admin/notifications', $data);
            $data['get_user_permissions'] = $this->user_model->get_user_permissions($session['id']);
            $this->load->view('admin/menu', $data);
            $this->load->view('templates/admin/content');

            $data = $this->clubs_model->get_club_info($idClub);
            $data['get_all_teams'] = $this->equips_model->get_all_teams($idClub);
            $data['get_all_users_by_idClub'] = $this->clubs_model->get_all_users_by_idClub($idClub);

            $this->load->view('admin/gestio_clubs_edita', $data);

            $this->load->view('templates/admin/footer');
        } else {
            redirect('admin/login', 'refresh');
        }
    }

    function modifica($idClub) {
        if ($this->session->userdata('logged_in')) {
            $session = $this->session->userdata('logged_in');
            $idSeason = $session['idSeason'];
            $this->clubs_model->update_clubs_info();
            $this->log_model->insert_log($session['id'], $idClub, 'ha modificat el club');
            $teamName = teamUrlFormat($_POST['clubName']);
            //echo $teamName;
            $this->cache_control($idClub);
            redirect("admin/gestio_clubs/edita/" . $idClub);
        } else {
            redirect('admin/login', 'refresh');
        }
    }

    public function puja_foto($idClub) {
        if ($this->session->userdata('logged_in')) {
            $session = $this->session->userdata('logged_in');

            if (!empty($_FILES)) {
                $tempFile = $_FILES['file']['tmp_name'];
                $ext = explode(".", $_FILES['file']['name']);
                $num = count($ext);
                $data = $this->clubs_model->get_club_info($idClub);

                $name = teamUrlFormat($data['name']) . "." . $ext[$num - 1];
                $fileName = "images/dynamic/clubsImages/" . $name;

                $targetFile = $fileName;
                if (move_uploaded_file($tempFile, $targetFile)) {
                    $sql = $this->clubs_model->update_club_image($idClub, $name);
                    $this->log_model->insert_log($session['id'], $idClub, ' ha modificat l\'escut del club');
                    $this->cache_control($idClub);
                    echo json_encode($name);
                }
            }
        }
    }

    function nou_equip() {
        if ($this->session->userdata('logged_in')) {
            $session = $this->session->userdata('logged_in');
            $idTeam = $this->clubs_model->insert_team();
            $this->log_model->insert_log($session['id'], $idTeam, 'ha creat l\' equip');
            redirect("admin/gestio_clubs/edita/" . $_POST['idClub']);
        } else {
            redirect('admin/login', 'refresh');
        }
    }

    function equip($idTeam, $idClub) {
        if ($this->session->userdata('logged_in')) {
            $session = $this->session->userdata('logged_in');
            $this->load->view('templates/admin/header', $session);
            $data['get_mail_notread'] = $this->mail_model->get_mail_notread($session['id']);
            $this->load->view('templates/admin/notifications', $data);
            $data['get_user_permissions'] = $this->user_model->get_user_permissions($session['id']);
            $this->load->view('admin/menu', $data);
            $this->load->view('templates/admin/content');

            $data = $this->equips_model->get_team_info($idTeam, $idClub);
            $data['get_players_by_idTeam_and_idClub'] = $this->equips_model->get_players_by_idTeam_and_idClub($idTeam, $idClub, CURRENT_SEASON);
            $data['get_all_complex'] = $this->competicio_model->get_all_complex();
            $this->load->view('admin/gestio_clubs_equip', $data);
            $this->load->view('templates/admin/footer');
        } else {
            redirect('admin/login', 'refresh');
        }
    }

    function modifica_equip($idTeam, $idClub) {
        if ($this->session->userdata('logged_in')) {
            $session = $this->session->userdata('logged_in');
            $idSeason = $session['idSeason'];
           // $this->form_validation->set_rules('username', 'Username', 'required');
            // if ($this->form_validation->run() == FALSE) {
            $this->equips_model->update_team_info($idTeam);
            $this->log_model->insert_log($session['id'], $idTeam, 'ha modificat l \' equip');

            redirect("admin/gestio_clubs/equip/" . $idTeam . "/" . $idClub);
        } else {
            redirect('admin/login', 'refresh');
        }
    }

    function verifica_jugador($idPlayer, $idTeam, $idClub) {
        if ($this->session->userdata('logged_in')) {
            $session = $this->session->userdata('logged_in');
            $this->load->view('templates/admin/header', $session);
            $data['get_mail_notread'] = $this->mail_model->get_mail_notread($session['id']);
            $this->load->view('templates/admin/notifications', $data);

            $data['get_user_permissions'] = $this->user_model->get_user_permissions($session['id']);
            $this->load->view('admin/menu', $data);
            $this->load->view('templates/admin/content');

            $data = $this->jugador_model->get_player_info($idPlayer, $idClub, CURRENT_SEASON);
            $data['get_player_positions'] = $this->jugador_model->get_player_positions();
            $this->load->view('admin/gestio_clubs_jugador', $data);
            $this->load->view('templates/admin/footer');
        } else {
            redirect('admin/login', 'refresh');
        }
    }

    function modifica_jugador($idPlayer, $idTeam, $idClub) {
        if ($this->session->userdata('logged_in')) {
            $session = $this->session->userdata('logged_in');
            $idSeason = $session['idSeason'];
            //print_r($session);
            $playerName = $this->jugador_model->update_player_info();
            $this->log_model->insert_log($session['id'], $idPlayer, 'ha modificat el jugador');
            $u = $this->clubs_model->get_all_users_by_idClub($idClub);
            //print_r($u);
            foreach ($u as $user) {
                $this->mail_model->insert_mail('Federació Catalana de Futbol Sala', $user->name, "Revisió de la fitxa de " . $playerName, "S' han modificat les dades del jugador <a href='".base_url()."admin/jugador/edita/$idPlayer'>$playerName.</a>", 267, $user->id);
            }
            redirect("admin/gestio_clubs/verifica_jugador/" . $idPlayer . "/" . $idTeam . "/" . $idClub);
        } else {
            redirect('admin/login', 'refresh');
        }
    }

    function nou_usuari() {
        if ($this->session->userdata('logged_in')) {
            $session = $this->session->userdata('logged_in');
            $idUser = $this->clubs_model->insert_user();
            $this->log_model->insert_log($session['id'], $_POST['idClub'], 'ha creat un compte per al club');
            $data = $this->clubs_model->get_user_info($idUser);
            $this->mail_model->insert_mail('Federació Catalana de Futbol Sala', $data['name'], "FCFS - Credencials", "El teu nom d' usuari i contrassenya &eacute;s: <br /> <strong>Login: </strong>" . $data['login'] . " <br /><strong> Contrassenya: </strong> " . $data['password'] . " <br /><br />Pots accedir al teu perfil, fent click <a href='http://www.futsal.cat/admin/login'>aquí</a>.", 267, $idUser);
            redirect("admin/gestio_clubs/edita/" . $_POST['idClub']);
        } else {
            redirect('admin/login', 'refresh');
        }
    }

}
