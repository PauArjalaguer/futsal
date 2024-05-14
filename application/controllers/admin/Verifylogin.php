<?php

class VerifyLogin extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('admin/login_model', '', TRUE);
        $this->load->model('admin/log_model');
    }

    function index() {
        //This method will have the credentials validation
        $this->load->library('form_validation');

        $this->form_validation->set_rules('username', 'Username', 'trim|required');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|callback_check_database');

        if ($this->form_validation->run() == FALSE) {
            //Field validation failed.  User redirected to login page
            $this->load->view('admin/login');
        } else {
            //Go to private area
            redirect('admin/index', 'refresh');
        }
    }

    function check_database($password) {
        //Field validation succeeded.  Validate against database
        $username = $this->input->post('username');

        //query the database
        $result = $this->login_model->login($username, $password);

        if ($result) {
            $sess_array = array();
            foreach ($result as $row) {
                $sess_array = array(
                    'id' => $row->id,
                    'name' => $row->name,
                    'idClub' => $row->idClub,
                    'idReferee' => $row->idReferee,
                    'idSeason' => CURRENT_SEASON
                );

                $this->session->set_userdata('logged_in', $sess_array);
                $this->log_model->insert_log($row->id, 0, 'ha fet login.');
            }
            return TRUE;
        } else {
            $this->form_validation->set_message('check_database', 'Invalid username or password');
            return false;
        }
    }

    function auto($token, $idAccount, $url) {
        // echo $idAccount." ".$token;
        $result = $this->login_model->login_with_token($idAccount, $token);
        //
        if ($result) {

            $sess_array = array();

            $sess_array = array(
                'id' => $result['id'],
                'name' => $result['name'],
                'idClub' => $result['idClub'],
                'idReferee' => $result['idReferee'],
                'idSeason' => CURRENT_SEASON);


            $this->session->set_userdata('logged_in', $sess_array);
            $this->log_model->insert_log($idAccount, 0, 'ha fet login des de email.');
            //print_r($this->session->userdata);
            $url = str_replace("-", "/", $url);
            redirect($url);
            
        } else {
            $this->form_validation->set_message('check_database', 'Invalid username or password');
            return false;
        }
    }

}

?>