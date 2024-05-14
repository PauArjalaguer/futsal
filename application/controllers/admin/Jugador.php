<?php

class Jugador extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('admin/mail_model');
        $this->load->model('admin/user_model');
        $this->load->model('admin/equips_model');
        $this->load->model('admin/jugador_model');
        $this->load->model('admin/log_model');
        $this->load->helper(array('url', 'html', 'form'));
    }

    function nou() {
        if ($this->session->userdata('logged_in')) {
            $session = $this->session->userdata('logged_in');
            $idSeason = $session['idSeason'];
            $idPlayer = $this->jugador_model->insert_player($idSeason);
            $this->log_model->insert_log($session['id'], $idPlayer, 'ha creat el jugador');
            redirect("admin/jugador/edita/" . $idPlayer);
        } else {
            redirect('admin/login', 'refresh');
        }
    }

    function check_percent($idPlayer) {
        $n = 0;
        if ($this->session->userdata('logged_in')) {
            $session = $this->session->userdata('logged_in');
            $idSeason = $session['idSeason'];
            $data = $this->jugador_model->get_player_info_idPlayerOnly($idPlayer);

            if ($data['firstName']) {
                $n++;
            }
            if ($data['surName']) {
                $n++;
            }
            if ($data['position']) {
                $n++;
            }


            if ($data['birthdate']) {
                $n++;
            }
            if ($data['addressCity']) {
                $n++;
            }
            if ($data['addressProvince']) {
                $n++;
            }


            if ($data['address']) {
                $n++;
            }
            if ($data['addressNumber']) {
                $n++;
            }


            if ($data['cp']) {
                $n++;
            }


            if ($data['image']) {
                $n++;
            }
            if ($data['insuranceScan']) {
                $n++;
            }

            if ($data['DNIscan']) {
                $n++;
            }
            $status = ($n / 12) * 100;
            $this->jugador_model->check_percent_update($data['idCard'], $status);
        } else {
            redirect('admin/login', 'refresh');
        }
    }

    function edita($idPlayer) {
        $this->check_percent($idPlayer);
        if ($this->session->userdata('logged_in')) {
            $session = $this->session->userdata('logged_in');
            $idSeason = $session['idSeason'];
            $this->load->view('templates/admin/header', $session);
            $data['get_mail_notread'] = $this->mail_model->get_mail_notread($session['id']);
            $this->load->view('templates/admin/notifications', $data);
            $data['get_user_permissions'] = $this->user_model->get_user_permissions($session['id']);
            $this->load->view('admin/menu', $data);

            $data = $this->jugador_model->get_player_info($idPlayer, $session['idClub'], $idSeason);
            $data['get_player_positions'] = $this->jugador_model->get_player_positions();
            $this->load->view('templates/admin/content');
            $this->load->view('admin/jugador_edita', $data);
            $this->load->view('templates/admin/footer');
        } else {
            redirect('admin/login', 'refresh');
        }
    }

    function modifica($idPlayer) {
        if ($this->session->userdata('logged_in')) {
            $session = $this->session->userdata('logged_in');
            $idSeason = $session['idSeason'];
            $this->jugador_model->update_player_info();
            $this->log_model->insert_log($session['id'], $idPlayer, 'ha modificat el jugador');
            redirect("admin/jugador/edita/" . $idPlayer);
        } else {
            redirect('admin/login', 'refresh');
        }
    }

    public function puja_foto($idPlayer) {
        $this->check_percent($idPlayer);
        if ($this->session->userdata('logged_in')) {
            $session = $this->session->userdata('logged_in');
            if (!empty($_FILES)) {
                $tempFile = $_FILES['file']['tmp_name'];
                $fileName = "images/dynamic/playersImages/" . $idPlayer . ".jpg";
                $targetFile = $fileName;
                if (move_uploaded_file($tempFile, $targetFile)) {
                    $this->jugador_model->update_player_image($idPlayer);
                    $this->log_model->insert_log($session['id'], $idPlayer, 'ha modificat la foto del jugador');
                }
            }
        }
    }

    function elimina_foto($idPlayer, $url) {
        if ($this->session->userdata('logged_in')) {
            $session = $this->session->userdata('logged_in');
            $idSeason = $session['idSeason'];
            $this->jugador_model->delete_player_image($idPlayer);
            $this->log_model->insert_log($session['id'], $idPlayer, 'ha eliminat la foto del jugador');
            $this->check_percent($idPlayer);
            // redirect("admin/jugador/edita/" . $idPlayer);
            $url = urldecode(urldecode($url));
            $url = str_replace("/futsal_v3", "", $url);
            redirect($url);
        } else {
            redirect('admin/login', 'refresh');
        }
    }

    public function puja_document($idPlayer) {
        if ($this->session->userdata('logged_in')) {
            $session = $this->session->userdata('logged_in');
            if (!empty($_FILES)) {
                $type = $this->uri->segment(5);
                // $type = 'dni';
                $tempFile = $_FILES['file']['tmp_name'];

                $fileName = "images/dynamic/playersImages/" . $idPlayer . "_" . $type . ".jpg";
                $targetFile = $fileName;
                if (move_uploaded_file($tempFile, $targetFile)) {
                    $this->jugador_model->update_player_scan($idPlayer, $type);
                    $this->check_percent($idPlayer);
                    $this->log_model->insert_log($session['id'], $idPlayer, 'ha modificat el ' . $type . ' del jugador');
                }
            }
        }
    }

    function elimina_document($idPlayer, $type, $url) {
        if ($this->session->userdata('logged_in')) {
            // $type = $this->uri->segment(5);
            $session = $this->session->userdata('logged_in');
            $idSeason = $session['idSeason'];
            $this->jugador_model->delete_player_scan($idPlayer, $type);
            $this->log_model->insert_log($session['id'], $idPlayer, 'ha eliminat ' . $type . ' del jugador');
            $this->check_percent($idPlayer);
            //redirect("admin/jugador/edita/" . $idPlayer);
            $url = urldecode(urldecode($url));
            $url = str_replace("/futsal_v3", "", $url);
            // echo $url;
            redirect($url);
        } else {
            redirect('admin/login', 'refresh');
        }
    }

    function elimina($idPlayer, $idTeam) {
        if ($this->session->userdata('logged_in')) {
            $session = $this->session->userdata('logged_in');
            $idSeason = $session['idSeason'];
            $this->jugador_model->delete_player($idPlayer, $idSeason);
            $this->log_model->insert_log($session['id'], $idPlayer, 'ha eliminat el jugador');
            redirect("admin/equip/" . $idTeam);
        } else {
            redirect('admin/login', 'refresh');
        }
    }

    function activa($idPlayer, $idTeam) {
        if ($this->session->userdata('logged_in')) {
            $session = $this->session->userdata('logged_in');
            $idSeason = $session['idSeason'];
            $this->jugador_model->activate_player($idPlayer, $idSeason, $idTeam);
            $this->log_model->insert_log($session['id'], $idPlayer, 'ha eliminat el jugador');
            redirect("admin/jugador/edita/" . $idPlayer);
        } else {
            redirect('admin/login', 'refresh');
        }
    }

    function marca_com_validat($idPlayer, $idTeam, $idClub) {
        if ($this->session->userdata('logged_in')) {
            $session = $this->session->userdata('logged_in');
            $idSeason = $session['idSeason'];
            $this->jugador_model->mark_as_payed($idPlayer);
            $this->log_model->insert_log($session['id'], $idPlayer, 'ha validat el jugador');
            redirect("admin/gestio_clubs/equip/" . $idTeam."/".$idClub);
            //$this->control_economic->saldo($idClub);
        } else {
            redirect('admin/login', 'refresh');
        }
    }

    function busca_dni() {
        if ($this->session->userdata('logged_in')) {
            $session = $this->session->userdata('logged_in');
            $data['idTeam'] = $_POST['idTeam'];
            $dni = $_POST['dni'];
            $data['dni_search'] = $this->jugador_model->dni_search($dni);
            //print_r($data);
            $this->load->view('admin/busca_dni', $data);
        } else {
            redirect('admin/login', 'refresh');
        }
    }

}
