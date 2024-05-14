<?php

class Legal extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
         $this->load->helper('functions_helper');
        $this->load->model('documentacio_model');
        $this->load->library('table');
    }

    public function index() {
        
        $this->load->view('templates/header');
        $this->load->view('legal');
        $this->load->view('templates/footer');
       // $this->output->cache($n);
    }
}
?>
