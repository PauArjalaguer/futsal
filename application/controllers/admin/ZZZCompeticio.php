<?php

class Competicio extends CI_Controller {

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
// unset($data);

            $data['get_leagues_by_idSeason'] = $this->competicio_model->get_leagues_by_idSeason(CURRENT_SEASON);
            $data['get_divisions'] = $this->competicio_model->get_divisions();

            $this->load->view('templates/admin/content');
            $this->load->view('admin/competicions', $data);
            $this->load->view('templates/admin/footer');
        } else {
//If no session, redirect to login page
            redirect('admin/login', 'refresh');
        }
    }

    public function cache_control($idRound, $idLeague) {
        $data = $this->Cache_model->select_cache_entries($idLeague, 'leagues');
        $url = $data['urlString'];
        $u = explode(";", $url);
        for ($a = 0; $a < count($u); $a++) {
            if ($u[$a] == 'init') {
// echo "delete init";
                $this->output->delete_cache("/");
            }
            $this->output->delete_cache($u[$a]);
        }
        $this->Cache_model->delete_cache_entries($idLeague, 'leagues');
        $data = $this->competicio_model->get_league_info($idLeague);
        $url = 'init;';
        $url .= "/competicio/lliga/" . $idLeague . "-" . teamUrlFormat($data['name']);
        $this->Cache_model->insert_cache_entries($idLeague, 'leagues', $url);

        $data = $this->Cache_model->select_cache_entries($idRound, 'rounds');
        $url = $data['urlString'];
        $u = explode(";", $url);
        for ($a = 0; $a < count($u); $a++) {
            if ($u[$a] == 'init') {
// echo "delete init";
                $this->output->delete_cache("/");
            }
            $this->output->delete_cache($u[$a]);
        }
        $this->Cache_model->delete_cache_entries($idRound, 'rounds');
        $data = $this->competicio_model->get_league_info($idLeague);
        $url = 'init;';
        $url .= "/competicio/lliga/" . $idLeague . "/jornada/" . $idRound . "/resultats;";
        $url .= "/competicio/lliga/" . $idLeague . "/jornada/" . $idRound . "/classificacio;";
        $url .= "/competicio/lliga/" . $idLeague . "/jornada/" . $idRound . "/sancions;";
        $this->Cache_model->insert_cache_entries($idRound, 'rounds', $url);
    }

    function nova() {
        if ($this->session->userdata('logged_in')) {
            $session = $this->session->userdata('logged_in');
            $idCompetition = $this->competicio_model->insert_competition();
            $this->log_model->insert_log($session['id'], $idCompetition, 'ha creat la lliga');
            redirect("admin/competicio");
        } else {
            redirect('admin/login', 'refresh');
        }
    }

    function edita($idLeague) {
        if ($this->session->userdata('logged_in')) {
            $session = $this->session->userdata('logged_in');
            $this->load->view('templates/admin/header', $session);
            $data['get_mail_notread'] = $this->mail_model->get_mail_notread($session['id']);
            $this->load->view('templates/admin/notifications', $data);
            $data['get_user_permissions'] = $this->user_model->get_user_permissions($session['id']);
            $this->load->view('admin/menu', $data);
            $data = $this->competicio_model->get_league_info($idLeague);
            $data['get_divisions'] = $this->competicio_model->get_divisions();
            $data['get_all_teams'] = $this->competicio_model->get_all_teams();
            $data['get_teams_by_idLeague'] = $this->competicio_model->get_teams_by_idLeague($idLeague);

            $this->load->view('templates/admin/content');
            $this->load->view('admin/competicio_edita', $data);
            $this->load->view('templates/admin/footer');
        } else {
//If no session, redirect to login page
            redirect('admin/login', 'refresh');
        }
    }

    function introduir_equip() {
        if ($this->session->userdata('logged_in')) {
            $session = $this->session->userdata('logged_in');
            $idCompetition = $this->competicio_model->insert_team_in_league();
            $this->log_model->insert_log($session['id'], $idCompetition, 'ha introduit equip a la lliga');
            redirect("admin/competicio/" . $idCompetition);
        } else {
            redirect('admin/login', 'refresh');
        }
    }

    function eliminar_equip($idLeague, $idTeam) {
        if ($this->session->userdata('logged_in')) {
            $session = $this->session->userdata('logged_in');
            $idCompetition = $this->competicio_model->delete_team_in_league($idLeague, $idTeam);
            $this->log_model->insert_log($session['id'], $idCompetition, 'ha eliminat un equip a la lliga');
            redirect("admin/competicio/" . $idCompetition);
        } else {
            redirect('admin/login', 'refresh');
        }
    }

    function generar_calendari($idLeague,$numberOfPhases) {
        if ($this->session->userdata('logged_in')) {
            $session = $this->session->userdata('logged_in');
            $this->competicio_model->clear_calendar($idLeague);

            $last_position = $this->competicio_model->get_last_position($idLeague);
            $position = $last_position['position'];
            $with_no_position = $this->competicio_model->get_teams_with_no_position($idLeague);
            foreach ($with_no_position as $i) {
                $position++;
                echo $i->idTeam . " " . $position . "<br />";
                $this->competicio_model->update_team_positions($idLeague, $i->idTeam, $position);
            }

            $numberOfTeams = count($this->competicio_model->get_teams_by_idLeague($idLeague));
            if (is_float($numberOfTeams / 2)) {
                $this->competicio_model->insert_null_team_in_league($idLeague);
                $numberOfTeams + 1;
            }
            $d = $this->competicio_model->get_rounds_by_pattern($numberOfTeams,$numberOfPhases);
            foreach ($d as $match) {
//echo "JORNADA: ".$match->idRound." LOCAL: ".$match->idLocal." VISITANT: ".$match->idVisitor."<br />";
                $this->competicio_model->insert_round($match->idRound, $idLeague);
            }
            foreach ($d as $match) {
// echo "JORNADA: " . $match->idRound . " LOCAL: " . $match->idLocal . " VISITANT: " . $match->idVisitor . "<br />";
                $this->competicio_model->insert_matches($match->idRound, $idLeague, $match->idLocal, $match->idVisitor);
            }
            $this->competicio_model->clear_incomplete($idLeague);
            $this->log_model->insert_log($session['id'], $idLeague, 'ha generat el calendari de ');
            redirect('admin/competicio/calendari/' . $idLeague, 'refresh');
        } else {
            redirect('admin/login', 'refresh');
        }
    }

    function ordenar($idLeague) {
        $i = 1;
        foreach ($_POST['item'] as $value) {
            $idTeam = $value;
            $this->competicio_model->order_teams_in_league($idLeague, $idTeam, $i);

            $i++;
        }
    }

    function calendari($idLeague) {
        if ($this->session->userdata('logged_in')) {
            $session = $this->session->userdata('logged_in');
            $this->load->view('templates/admin/header', $session);
            $data['get_mail_notread'] = $this->mail_model->get_mail_notread($session['id']);
            $this->load->view('templates/admin/notifications', $data);
            $data['get_user_permissions'] = $this->user_model->get_user_permissions($session['id']);
            $this->load->view('admin/menu', $data);

            $data = $this->competicio_model->get_league_info($idLeague);
            $data['get_calendar'] = $this->competicio_model->get_calendar($idLeague);
            $data['get_all_status'] = $this->competicio_model->get_all_status();
            $this->load->view('templates/admin/content');
            $this->load->view('admin/calendari', $data);
            $this->load->view('templates/admin/footer');
        } else {
//If no session, redirect to login page
            redirect('admin/login', 'refresh');
        }
    }

    function modifica_estat_lliga() {

        if ($this->session->userdata('logged_in')) {
            // print_r($_POST);
            $idLeague = $_POST['idLeague'];
            $session = $this->session->userdata('logged_in');
            $data = $this->competicio_model->update_league();
            $this->log_model->insert_log($session['id'], $idLeague, 'ha canviat dades de la lliga ');
            redirect('admin/competicio/' . $idLeague, 'refresh');
        } else {
//If no session, redirect to login page
            redirect('admin/login', 'refresh');
        }
    }

    function generar_jornada($idLeague, $idRound) {
        $d = $this->competicio_model->get_last_round_of_league($idLeague);
        //print_r($_POST);
        $n = 0;
        $date = $_POST['initialDate'];
        $_POST['endDate'] = date("d-m-Y", strtotime($date) + 86400);

        // echo "DATA:" . $date;
        for ($a = $idRound; $a <= $d['id']; $a++) {
            $tstamp = strtotime($date);
            $tstamp2 = strtotime('+ ' . $n . ' week', $tstamp);
            $date2 = date('d-m-Y', $tstamp2);
            $this->generar_jornada_2($a, $date2);
            $n++;
        }
        redirect('admin/competicio/calendari/' . $idLeague, 'refresh');
    }

    function generar_jornada_2($idRound, $date) {
        $this->competicio_model->update_round_dates($idRound, $date);
        $data = $this->competicio_model->get_matches_by_idRound($idRound);
        foreach ($data as $row) {
            $d = $this->competicio_model->get_match_time_and_place_by_idTeam($row->idLocal);
            $idLeague = $this->competicio_model->update_matches_set_time_and_place($row->idLocal, $idRound, $d['playingDay'], $d['playingHour'], $d['playingComplex']);
        }
        $data = $this->competicio_model->get_league_info($idLeague);
        $this->output->delete_cache('/competicio/lliga/' . $idLeague . "-" . teamUrlFormat($data['name']));
        // redirect('admin/competicio/calendari/' . $idLeague, 'refresh');
    }

    function partit($idMatch) {
        if ($this->session->userdata('logged_in')) {
            $session = $this->session->userdata('logged_in');
            $this->load->view('templates/admin/header', $session);
            $data['get_mail_notread'] = $this->mail_model->get_mail_notread($session['id']);
            $this->load->view('templates/admin/notifications', $data);
            $data['get_user_permissions'] = $this->user_model->get_user_permissions($session['id']);
            $this->load->view('admin/menu', $data);
            $this->load->view('templates/admin/content');
            $data = $this->competicio_model->get_match_info($idMatch);

            $data['get_all_complex'] = $this->competicio_model->get_all_complex();
            $data['localGoals'] = $this->competicio_model->get_goals_by_idMatch_and_idTeam($idMatch, $data['idLocal']);
            $data['visitorGoals'] = $this->competicio_model->get_goals_by_idMatch_and_idTeam($idMatch, $data['idVisitor']);

            $data['localPlayers'] = $this->competicio_model->get_players_by_idTeam($data['idLocal'], $idMatch);
            $data['visitorPlayers'] = $this->competicio_model->get_players_by_idTeam($data['idVisitor'], $idMatch);

            $data['referees'] = $this->competicio_model->get_referees();
            $data['referees_by_match'] = $this->competicio_model->get_referees_by_match($idMatch);

//echo "<pre>"; print_r($data); echo "</pre>";
            $this->load->view('admin/partit', $data);
            $this->load->view('templates/admin/footer');
        } else {
//If no session, redirect to login page
            redirect('admin/login', 'refresh');
        }
    }

    function modifica_partit($idMatch) {
        if ($this->session->userdata('logged_in')) {
            $session = $this->session->userdata('logged_in');
            $data['get_user_permissions'] = $this->user_model->get_user_permissions($session['id']);
            $data = $this->competicio_model->update_match_info($idMatch);
            $this->log_model->insert_log($session['id'], $idMatch, 'ha modificat el partit ');
            redirect('admin/competicio/partit/' . $idMatch, 'refresh');
        } else {
//If no session, redirect to login page
            redirect('admin/login', 'refresh');
        }
    }

    function actualitza_classificacio($idRound, $idLeague) {
        $data = $this->competicio_model->get_teams_by_idLeague($idLeague);
        foreach ($data as $teams) {
            $idTeam = $teams->id;
            $results = $this->competicio_model->get_results_by_idTeam_and_idLeague($idTeam, $idLeague, $idRound);
// echo "<pre>"; print_r($results); echo "</pre>";
            $draws = 0;
            $wins = 0;
            $loses = 0;
            $goalsF = 0;
            $goalsC = 0;
            $playedMatches = 0;
            $points = 0;
            foreach ($results as $re) {
// echo "Local: " . $re->idLocal . " Visitant: " . $re->idVisitor . " Gols Local:" . $re->localResult . " Gols Visitant: " . $re->visitorResult . "<br />";
                if ($idTeam == $re->idLocal) {
                    $local = 1;
                    $goalsF = $goalsF + $re->localResult;
                    $goalsC = $goalsC + $re->visitorResult;
                    if ($re->localResult > $re->visitorResult) {
                        $wins++;
                        $points = $points + 3;
                    } else if ($re->localResult < $re->visitorResult) {
                        $loses++;
                    }
                } else {
                    $local = 0;
                    $goalsF = $goalsF + $re->visitorResult;
                    $goalsC = $goalsC + $re->localResult;
                    if ($re->localResult < $re->visitorResult) {
                        $wins++;
                        $points = $points + 3;
                    } else if ($re->localResult > $re->visitorResult) {
                        $loses++;
                    }
                }
                if ($re->localResult == $re->visitorResult) {
                    $draws++;
                    $points = $points + 1;
                }
                $playedMatches++;
            }
            $this->competicio_model->insert_classification($idTeam, $idLeague, $playedMatches, $wins, $draws, $loses, $goalsC, $goalsF, $idRound, $points);
            $data = $this->competicio_model->get_classification_by_idLeague_and_idRound($idLeague, $idRound);
// echo "<pre>";print_r($data);echo "</pre>";
            $n = 0;
            foreach ($data as $re) {
                $n++;
                $this->competicio_model->update_positions($re->idTeam, $n, $idRound, $idLeague);
            }
        }
    }

    function modifica_resultat($idMatch, $userType) {
        if ($this->session->userdata('logged_in')) {
            $session = $this->session->userdata('logged_in');
            $data['get_user_permissions'] = $this->user_model->get_user_permissions($session['id']);
            $data = $this->competicio_model->update_match_result($idMatch);
            $this->log_model->insert_log($session['id'], $idMatch, 'ha modificat el resultat del partit ');

            $data = $this->competicio_model->get_match_info($idMatch);
            $idRound = $data['idRound'];
            $idLeague = $data['idLeague'];            //
//
            $data = $this->competicio_model->get_last_round_with_results($idLeague);
            $lastIdRound = $data['idRound'];
            for ($a = $idRound; $a <= $lastIdRound; $a++) {
                $this->actualitza_classificacio($a, $idLeague);
            }
            $this->cache_control($lastIdRound, $idLeague);
            if ($userType == "admin") {
                redirect('admin/competicio/partit/' . $idMatch, 'refresh');
            } else {
                redirect('admin/arbitre/partit/' . $idMatch, 'refresh');
            }
        } else {
//If no session, redirect to login page
            redirect('admin/login', 'refresh');
        }
    }

    function introdueix_incidencia($idMatch) {
        if ($this->session->userdata('logged_in')) {
            $session = $this->session->userdata('logged_in');
            $data['get_user_permissions'] = $this->user_model->get_user_permissions($session['id']);
            $data = $this->competicio_model->update_match_comment($idMatch);
            $this->log_model->insert_log($session['id'], $idMatch, 'ha introduit una incidencia al partit ');
            $data = $this->competicio_model->get_match_info($idMatch);
            if (strlen($_POST['comment']) > 10) {
                $this->mail_model->insert_mail($session['name'], "Comitè de competició", "FCFS - Incidencia partit " . $data['localName'] . " - " . $data['visitorName'], " El partit " . $data['localName'] . " - " . $data['visitorName'] . " (jornada " . $data['roundName'] . " de " . $data['leagueName'] . ") té una incidencia: <br />" . $_POST['comment'], 267, 267);
            }
            redirect('admin/arbitre/partit/' . $idMatch, 'refresh');
        }
    }

    function tancar_partit($idMatch) {
        if ($this->session->userdata('logged_in')) {
            $session = $this->session->userdata('logged_in');
            $data['get_user_permissions'] = $this->user_model->get_user_permissions($session['id']);
            $data = $this->competicio_model->update_match_status($idMatch, 4);
            $this->log_model->insert_log($session['id'], $idMatch, 'ha tancat el partit ');
            redirect('admin/arbitre/partit/' . $idMatch, 'refresh');
        }
    }

    function actualitza_gol() {
        if ($this->session->userdata('logged_in')) {
            $session = $this->session->userdata('logged_in');
            $data['get_user_permissions'] = $this->user_model->get_user_permissions($session['id']);
            $data = $this->competicio_model->update_goals_byIdGoal();

            redirect('admin/competicio/partit/' . $idMatch, 'refresh');
        } else {
//If no session, redirect to login page
            redirect('admin/login', 'refresh');
        }
    }

    function actualitza_dades_acta() {
        $f = explode("_", $_POST['item']);
        print_r($_POST);
        $value = $_POST['value'];
        if ($f[0] == 'isCaptain' or $f[0] == 'active') {
            $value = $_POST['checked'];
        }
        if ($f[0] == 'number' or $f[0] == 'isCaptain') {
            $this->competicio_model->update_match_data_by_idMatch_and_idPlayer($f[0], $f[1], $f[2], $f[3], $value);
        }

        if ($f[0] == 'yellowCards' or $f[0] == 'blueCards') {
            $this->competicio_model->update_match_cards_by_idMatch_and_idPlayer($f[0], $f[1], $f[2], $f[3], $value);
        }
        if ($f[0] == 'active') {
            if ($value == 1) {
                $this->competicio_model->update_match_data_by_idMatch_and_idPlayer("idPlayer", $f[1], $f[2], $f[3], $f[0]);
            } else {
                $this->competicio_model->delete_match_data_by_idMatch_and_idPlayer($f[1], $f[2]);
            }
        }
    }

}
