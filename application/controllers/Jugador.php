<?php

class Jugador extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('jugador_model');
        $this->load->library('table');
        $this->load->helper('functions_helper');
    }

    public function index($id) {
        $id_array = explode("-", $id);
        $id = $id_array[0];
           $n = 60 * 24;

        $data = $this->jugador_model->get_player_info($id, $idSeason=CURRENT_SEASON);
        $data['get_player_stats'] = $this->jugador_model->get_player_stats($id, $idSeason=CURRENT_SEASON);
        $data['get_previous_teams'] = $this->jugador_model->get_previous_teams($id);
        
        $this->load->view('templates/header');

        $this->load->view('jugador', $data);
        $this->load->view('templates/footer');
        $this->output->cache($n);
    }

}
