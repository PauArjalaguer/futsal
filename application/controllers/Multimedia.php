<?php

class Multimedia extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('multimedia_model');
        $this->load->helper('functions_helper');
    }

    public function index() {

        //echo "<h2>API: " . FLICKR_API_KEY . " FLICKR_ID:" . FLICKR_ID . "</h2>";
        //print_r($xml);
        $data['get_videos'] = $this->multimedia_model->get_videos();
        $this->load->view('templates/header');
        $this->load->view('multimedia', $data);
        $this->load->view('templates/footer');
        $this->output->cache(15);
    }

    public function album($photoset, $api) {

        $data = array("photoset" => $photoset, "api" => $api);
        //print_r($xml);
        $this->load->view('templates/header');
        $this->load->view('multimedia_album', $data);
        $this->load->view('templates/footer');
        $this->output->cache(15);
    }

    public function foto($photo) {
        $p = explode("-", $photo);
        $id = $p[0];
        $rest = "http://flickr.com/services/rest/?method=flickr.photos.getSizes&user_id=" . FLICKR_ID . "&api_key=" . FLICKR_API_KEY . "&photo_id=" . $id;
        $xml = simplexml_load_file($rest);

        $rest2 = "http://flickr.com/services/rest/?method=flickr.photos.getInfo&user_id=" . FLICKR_ID . "&api_key=" . FLICKR_API_KEY . "&photo_id=" . $id;

        $this->load->view('templates/header');
        $this->load->view('multimedia_photo', $xml);
        $this->load->view('templates/footer');
        $this->output->cache(15);
    }

    public function video($id) {
        $data = $this->multimedia_model->get_videos_by_id($id);
        $this->load->view('templates/header');
        $this->load->view('multimedia_video', $data);
        $this->load->view('templates/footer');
        $this->output->cache(15);
    }

}
