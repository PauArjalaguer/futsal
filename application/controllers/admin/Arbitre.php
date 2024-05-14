<?php

class Arbitre extends CI_Controller {

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
            $idReferee = $session['idReferee'];
            $this->load->view('templates/admin/header', $session);
            $data['get_mail_notread'] = $this->mail_model->get_mail_notread($session['id']);
            $this->load->view('templates/admin/notifications', $data);
            $data['get_user_permissions'] = $this->user_model->get_user_permissions($session['id']);
            //print_r($session);
            $this->load->view('admin/menu', $data);
            $this->load->view('templates/admin/content');
            $data['get_matches'] = $this->arbitre_model->get_matches($idReferee);
            //echo "<pre>"; print_r( $data['get_matches']);
            $this->load->view('admin/arbitre_llistat', $data);
            $this->load->view('templates/admin/footer');
        } else {
            redirect('admin/login', 'refresh');
        }
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
            $data['localGoals'] = $this->competicio_model->get_goals_by_idMatch_and_idTeam($idMatch, $data['idLocal']);
            $data['visitorGoals'] = $this->competicio_model->get_goals_by_idMatch_and_idTeam($idMatch, $data['idVisitor']);

            $data['localPlayers'] = $this->competicio_model->get_players_by_idTeam($data['idLocal'], $idMatch);
            $data['visitorPlayers'] = $this->competicio_model->get_players_by_idTeam($data['idVisitor'], $idMatch);

            $data['referees'] = $this->competicio_model->get_referees();
            $data['referees_by_match'] = $this->competicio_model->get_referees_by_match($idMatch);

            $data['accepted'] = $this->arbitre_model->get_match_status_by_idReferee($idMatch, $session['idReferee']);

            //echo "<pre>"; print_r($data); echo "</pre>";
            $this->load->view('admin/arbitre_partit', $data);
            $this->load->view('templates/admin/footer');
        } else {
            //If no session, redirect to login page
            redirect('admin/login', 'refresh');
        }
    }

    function edita($idReferee) {
        if ($this->session->userdata('logged_in')) {
            $session = $this->session->userdata('logged_in');
            //$idReferee = $session['idReferee'];
            $this->load->view('templates/admin/header', $session);
            $data['get_mail_notread'] = $this->mail_model->get_mail_notread($session['id']);
            $this->load->view('templates/admin/notifications', $data);
            $data['get_user_permissions'] = $this->user_model->get_user_permissions($session['id']);
            //print_r($session);
            $this->load->view('admin/menu', $data);
            $this->load->view('templates/admin/content');
            $data = $this->arbitre_model->get_referee_info($idReferee);
            $data['get_delegations'] = $this->arbitre_model->get_delegations();
            $this->load->view('admin/arbitre_edita', $data);
            $this->load->view('templates/admin/footer');
        } else {
            redirect('admin/login', 'refresh');
        }
    }

    function modifica($idReferee) {
        if ($this->session->userdata('logged_in')) {
            $session = $this->session->userdata('logged_in');
            $idSeason = $session['idSeason'];
            $this->arbitre_model->update_referee_info();
            $this->log_model->insert_log($session['id'], $idReferee, 'ha modificat informació de l\' arbitre');
            redirect("admin/arbitres");
        } else {
            redirect('admin/login', 'refresh');
        }
    }

    function dietes() {
        $data = $this->arbitre_model->get_all_referees();
        //echo "<pre>"; print_r($data); echo "</pre>";
        foreach ($data as $r) {
            //echo "<hr>" . $r->name;
            $d = $this->arbitre_model->get_matches($r->id);
            foreach ($d as $m) {
                $dow = date('w', strtotime($m->updateddatetime));
                $hour = date('H', strtotime($m->updateddatetime));
                $h = explode(" ", $m->updateddatetime);
                $hour = $h[1];
                $allowance = 0;
                echo "<br />&bull;  Partit " . $m->idMatch . " Dia $dow Hora $hour //" . $m->updateddatetime;

                //DIETES DISSABTE
                if ($dow == 6) {
                    $allowance = 0;
                    echo "<br />Dissabte ";
                    if ($hour < "15:00") {
                        $allowance = 6;
                        echo " abans de les 15:  $allowance &euro;";
                    }
                    if ($hour >= "21:00") {
                        $allowance = 10;
                        echo " després de les 21:  $allowance &euro;";
                    }
                } else if ($dow == 0) {
                    $allowance = 0;
                    echo "<br />Diumenge ";

                    if ($hour >= "20:00") {
                        $allowance = 10;
                        echo " després de les 20:  $allowance &euro;";
                    } else {
                        echo " abans de les 20 no hi ha dieta";
                        $allowance = 0;
                    }
                } else {
                    $allowance = 0;
                    echo "<br />Setmanal ";
                    if ($hour <= "22:29") {
                        $allowance = 10;
                        echo " abans de les 22:30:  $allowance &euro;";
                    } else {
                        $allowance = 20;
                        echo " després de les 22:30:  $allowance &euro;";
                    }
                }
                if ($m->isDriver == 0) {
                    $m->distance = 0;
                }
                echo "Update " . $m->idMatch . " -  $allowance - " . $m->isDriver . " - " . $m->distance;
                $this->arbitre_model->update_allowance_and_km($r->id, $m->idMatch, $allowance, $m->distance);
            }
        }
    }

    function accepta_partit($idMatch, $idReferee) {
        if ($this->session->userdata('logged_in')) {
            $session = $this->session->userdata('logged_in');
            $idSeason = $session['idSeason'];
            $this->arbitre_model->update_match_status_by_idReferee($idMatch, $idReferee, 1);
            $this->log_model->insert_log($session['id'], $idMatch, 'ha acceptat el partit ');
            redirect("admin/arbitre/partit/" . $idMatch);
        } else {
            redirect('admin/login', 'refresh');
        }
    }

    function rebutja_partit($idMatch, $idReferee) {
        if ($this->session->userdata('logged_in')) {
            $session = $this->session->userdata('logged_in');
            $idSeason = $session['idSeason'];
            $this->arbitre_model->update_match_status_by_idReferee($idMatch, $idReferee, 2);
            $this->log_model->insert_log($session['id'], $idMatch, 'ha rebutjat el partit ');
            redirect("admin/arbitre/partit/" . $idMatch);
        } else {
            redirect('admin/login', 'refresh');
        }
    }

}

?>