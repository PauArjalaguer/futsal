<?php

class Noticia extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('admin/user_model');
        $this->load->model('admin/Noticies_model');
        $this->load->model('admin/Cache_model');
        $this->load->model('admin/mail_model');
        $this->load->model('admin/log_model');
        $this->load->helper('functions_helper');
        $this->load->helper('form');
    }

    function index() {
        if ($this->session->userdata('logged_in')) {
            $session = $this->session->userdata('logged_in');
            $this->load->view('templates/admin/header', $session);
            $data['get_mail_notread'] = $this->mail_model->get_mail_notread($session['id']);
            $this->load->view('templates/admin/notifications', $data);
            $data['get_user_permissions'] = $this->user_model->get_user_permissions($session['id']);
            $this->load->view('admin/menu', $data);
            $this->load->view('templates/admin/content');
            $this->load->view('admin/noticia', $data);
            $this->load->view('templates/admin/footer');
        } else {
            redirect('admin/login', 'refresh');
        }
    }

    public function cache_control($id) {
        $data = $this->Cache_model->select_cache_entries($id, 'news');       
        $url = $data['urlString'];
        $u = explode(";", $url);
        for ($a = 0; $a < count($u); $a++) {          
            if ($u[$a] == 'init') {
                //echo "delete init";
                $this->output->delete_cache("/");
            }
            $this->output->delete_cache($u[$a]);
        }
        $this->Cache_model->delete_cache_entries($id, 'news');
        $data = $this->Noticies_model->get_news_by_id($id);
        $url = 'init;/noticies;';
        $url .= "/noticies/detall/" . $id . "-" . teamUrlFormat($data['title']);
        $this->Cache_model->insert_cache_entries($id, 'news', $url);
    }

    public function crea() {
        if ($this->session->userdata('logged_in')) {
            $session = $this->session->userdata('logged_in');
            $id = $this->Noticies_model->insert_news();
            $this->log_model->insert_log($session['id'], $id, 'ha creat la notícia');
            redirect('admin/noticia/edita/' . $id, 'refresh');
        } else {
            redirect('admin/login', 'refresh');
        }
    }

    function edita($id) {
        if ($this->session->userdata('logged_in')) {
            $session = $this->session->userdata('logged_in');
            $this->load->view('templates/admin/header', $session);
            $data['get_mail_notread'] = $this->mail_model->get_mail_notread($session['id']);
            $this->load->view('templates/admin/notifications', $data);
            $data['get_user_permissions'] = $this->user_model->get_user_permissions($session['id']);
            $this->load->view('admin/menu', $data);
            $data = $this->Noticies_model->get_news_by_id($id);
//echo "<pre>"; print_r($data); echo "</pre>";
            $data['get_news_categories'] = $this->Noticies_model->get_news_categories();
            $this->load->view('templates/admin/content');
            $this->load->view('admin/noticia', $data);
            $this->load->view('templates/admin/footer');
        } else {
            redirect('admin/login', 'refresh');
        }
    }

    public function modifica($id) {
        if ($this->session->userdata('logged_in')) {
            $session = $this->session->userdata('logged_in');
            $idSeason = $session['idSeason'];
            $this->Noticies_model->update_news($id);
            $this->log_model->insert_log($session['id'], $id, 'ha modificat la notícia');
            $this->cache_control($id);
            redirect("admin/noticia/edita/" . $id);
        } else {
            redirect('admin/login', 'refresh');
        }
    }

    public function puja_imatge($id) {
        if ($this->session->userdata('logged_in')) {
            $session = $this->session->userdata('logged_in');
            if (!empty($_FILES)) {
                $tempFile = $_FILES['file']['tmp_name'];
                $fileName = "images/dynamic/newsImages/" . $id . ".jpg";
                $targetFile = $fileName;

                $ext = explode(".", $_FILES['file']['name']);
                $num = count($ext);
                $name = "$id." . $ext[$num - 1];
                if (move_uploaded_file($tempFile, $targetFile)) {
                    $this->Noticies_model->update_news_image($id, $name);
                    $this->log_model->insert_log($session['id'], $id, 'ha modificat la foto de la notícia');
                    $this->cache_control($id);
                    echo json_encode($name);
                }
            }
        } else {
            redirect('admin/login', 'refresh');
        }
    }

    public function elimina_imatge($id) {
        if ($this->session->userdata('logged_in')) {
            $session = $this->session->userdata('logged_in');
            $this->Noticies_model->delete_news_image($id);
            $this->log_model->insert_log($session['id'], $id, 'ha eliminat la foto de la notícia');
            $this->cache_control($id);
            redirect("admin/noticia/edita/" . $id);
        } else {
            redirect('admin/login', 'refresh');
        }
    }

    public function llista() {
        if ($this->session->userdata('logged_in')) {
            $session = $this->session->userdata('logged_in');
            $this->load->view('templates/admin/header', $session);
            $data['get_mail_notread'] = $this->mail_model->get_mail_notread($session['id']);
            $this->load->view('templates/admin/notifications', $data);
            $data['get_user_permissions'] = $this->user_model->get_user_permissions($session['id']);
            $this->load->view('admin/menu', $data);
            $data['get_news'] = $this->Noticies_model->get_news();
            $this->load->view('templates/admin/content');
            $this->load->view('admin/noticies_llista', $data);
            $this->load->view('templates/admin/footer');
        } else {
            redirect('admin/login', 'refresh');
        }
    }

    public function publica($id) {
        if ($this->session->userdata('logged_in')) {
            $session = $this->session->userdata('logged_in');
            $this->Noticies_model->publish_new($id);
            $this->log_model->insert_log($session['id'], $id, 'ha publicat la notícia');
            $this->cache_control($id);
            redirect("admin/noticia/llista");
        } else {
            redirect('admin/login', 'refresh');
        }
    }

    public function esborrany($id) {
        if ($this->session->userdata('logged_in')) {
            $session = $this->session->userdata('logged_in');
            $this->Noticies_model->draft_new($id);
            $this->log_model->insert_log($session['id'], $id, 'ha despublicat la notícia');
            $this->cache_control($id);
            redirect("admin/noticia/llista");
        } else {
            redirect('admin/login', 'refresh');
        }
    }

    public function esborra($id) {
        if ($this->session->userdata('logged_in')) {
            $session = $this->session->userdata('logged_in');
            $this->Noticies_model->delete_new($id);
            $this->log_model->insert_log($session['id'], $id, 'ha eliminat la notícia');
            $this->cache_control($id);
            redirect("admin/noticia/llista");
        } else {
            redirect('admin/login', 'refresh');
        }
    }

}

?>