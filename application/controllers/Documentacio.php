<?php

class Documentacio extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
         $this->load->helper('functions_helper');
        $this->load->model('documentacio_model');
           
        $this->load->library('table');
    }

    public function index() {
        $n = 15;
        $data['documents'] = $this->documentacio_model->get_documents();
       
        $data['search'] = 0;
        $this->load->view('templates/header');
        $this->load->view('documentacio', $data);
        $this->load->view('templates/footer');
        $this->output->cache($n);
    }
      public function sancions() {
        $n = 15;
       $data["documents"] = $this->documentacio_model->get_documents_sancions(); 
        $data['search'] = 0;
        $this->load->view('templates/header');
        $this->load->view('documentacio', $data);
        $this->load->view('templates/footer');
        $this->output->cache($n);
    }
    
}
?>
