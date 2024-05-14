<?php

class Equip extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('clubs_model');
        $this->load->library('table');
        $this->load->helper('functions_helper');
    }

    public function index() {

     $n = 365 * (60 * 24);

        //$data['get_competitions'] = $this->competicio_model->get_competitions();

        $this->load->view('templates/header');
        //$this->load->view('competicio', $data);
        $this->load->view('templates/footer');
        $this->output->cache($n);
    }
     
}
?>