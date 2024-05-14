<?php

class Clubs extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('admin/clubs_model');
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
            redirect("admin/clubs/edita/" . $session['idClub']);
        } else {
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

    public function edita($idClub) {
        if ($this->session->userdata('logged_in')) {
            $session = $this->session->userdata('logged_in');
            $this->load->view('templates/admin/header', $session);
            $data['get_mail_notread'] = $this->mail_model->get_mail_notread($session['id']);
            $this->load->view('templates/admin/notifications', $data);
            $data['get_user_permissions'] = $this->user_model->get_user_permissions($session['id']);
            $this->load->view('admin/menu', $data);
            $this->load->view('templates/admin/content');
            if ($session['idClub']) {
                $idClub = $session['idClub'];
            }
            $data = $this->clubs_model->get_club_info($idClub);
            $this->load->view('admin/club_edita', $data);
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
            redirect("admin/clubs/edita/" . $idClub);
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
                $name = teamUrlFormat($session['name']) . "." . $ext[$num - 1];
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

   

}

?>