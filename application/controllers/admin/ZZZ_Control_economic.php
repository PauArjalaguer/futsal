<?php

class Control_economic extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('admin/clubs_model');
        $this->load->model('admin/user_model');
        $this->load->model('admin/log_model');
        $this->load->model('admin/mail_model');
        $this->load->model('admin/arbitre_model');
        $this->load->model('admin/Control_economic_model');
        $this->load->model('admin/Competicio_model');
        $this->load->helper('functions_helper');

        $this->load->helper('form');
    }

    public function index() {
        if ($this->session->userdata('logged_in')) {
            $session = $this->session->userdata('logged_in');
            $this->saldo($session['idClub']);
            $this->load->view('templates/admin/header', $session);
            $data['get_mail_notread'] = $this->mail_model->get_mail_notread($session['id']);
            $this->load->view('templates/admin/notifications', $data);
            $data['get_user_permissions'] = $this->user_model->get_user_permissions($session['id']);
            $this->load->view('admin/menu', $data);
            $this->load->view('templates/admin/content');

            $data = $this->Control_economic_model->get_club_balance($session['idClub']);
            $data['get_unpayed_players'] = $this->Control_economic_model->get_unpayed_players($session['idClub']);
            $this->load->view('admin/control_economic', $data);
            $this->load->view('templates/admin/footer');
        } else {
            redirect('admin/login', 'refresh');
        }
    }

    public function admin() {
        if ($this->session->userdata('logged_in')) {
            $session = $this->session->userdata('logged_in');
            $this->load->view('templates/admin/header', $session);
            $data['get_mail_notread'] = $this->mail_model->get_mail_notread($session['id']);
            $this->load->view('templates/admin/notifications', $data);
            $data['get_user_permissions'] = $this->user_model->get_user_permissions($session['id']);
            $this->load->view('admin/menu', $data);
            $this->load->view('templates/admin/content');
            $data['get_all_clubs'] = $this->clubs_model->get_all_clubs();
            $data['clubs_with_negative_balance'] = $this->Control_economic_model->clubs_with_negative_balance();
           
            $this->load->view('admin/control_economic_admin', $data);
            $this->load->view('templates/admin/footer');
        } else {
            redirect('admin/login', 'refresh');
        }
    }

    public function club($idClub) {
        if ($this->session->userdata('logged_in')) {
            $session = $this->session->userdata('logged_in');
            $this->load->view('templates/admin/header', $session);
            $data['get_mail_notread'] = $this->mail_model->get_mail_notread($session['id']);
            $this->load->view('templates/admin/notifications', $data);
            $data['get_user_permissions'] = $this->user_model->get_user_permissions($session['id']);

            $this->load->view('admin/menu', $data);
            $this->load->view('templates/admin/content');

            $data1 = $this->Control_economic_model->get_economic_control_by_idClub_and_type($idClub);
            $data1['get_economic_control_by_idClub'] = $this->Control_economic_model->get_economic_control_by_idClub($idClub);
            $data1['get_payments'] = $this->Control_economic_model->get_payments($idClub);

            $this->load->view('admin/control_economic_club', $data1);
            $this->load->view('templates/admin/footer');
        } else {
            redirect('admin/login', 'refresh');
        }
    }

    public function saldos() {
        $data = $this->clubs_model->get_all_clubs();
        foreach ($data as $club) {
            $idClub = $club->id;
            $this->saldo($idClub);
        }
    }

     public function saldo($idClub) {
        $table = "<table>\n<tr>\n\t<td>Moviment</td>\n\t<td>Nom</td>\n\t<td>Valor</td>\n\t<td>Saldo</td>\n</tr>";
        $balance = 0;

        $data['get_payments'] = $this->Control_economic_model->get_payments($idClub);
       
        foreach ($data['get_payments'] as $payment) {
            $balance = $balance + $payment->amount;
            //  $table .= "\n<tr>\n\t<td>Pagament</td>\n\t<td>" . $payment->code . "</td>\n\t<td>" . $payment->amount . "</td>\n\t<td> $balance</td>\n</tr>";
            $concept = $payment->code;
            $amount = $payment->amount;
            $datetime = $payment->datetime;
            $type = 'Pagament';
             $totalPayments = $totalPayments + $amount;
        }
        $data['get_payed_players'] = $this->Control_economic_model->get_payed_players($idClub);
        foreach ($data['get_payed_players'] as $player) {
            $balance = $balance - $player->rate;
            
            $concept = "Fitxa " . $player->playerName;
            echo $player->position." ".$concept."<br />";
            if($player->position==2){
                $amount = $player->rate;
                 $type = 'Fitxa';                
            }else{
                $amount=50;
                $type = 'Fitxa delegat';
            }
            $datetime = $player->paymentDate;
           
            $this->Control_economic_model->insert_economic_control($idClub, $concept, $amount, $type, $datetime, $player->id,$player->idDivision);
        }
        $data['get_team_entries'] = $this->Control_economic_model->get_team_entries($idClub);
        foreach ($data['get_team_entries'] as $team) {
            $balance = $balance - $team->rate;
            $concept = "Inscripció " . $team->teamName;
            $amount = $team->rate;
            $datetime = $team->datetime;
            $type = 'Inscripció';
            $this->Control_economic_model->insert_economic_control($idClub, $concept, $amount, $type, $datetime, $team->id,$team->idDivision);
           }
        $data['get_refereed_matches'] = $this->Control_economic_model->get_refereed_matches($idClub);

        foreach ($data['get_refereed_matches'] as $match) {
            $balance = $balance - $match->rate;
            $concept = $match->local . "-" . $match->visitor;
            $amount = $match->rate;
            $datetime = $match->updateddatetime;
            $type = 'Arbitratge';
            $this->Control_economic_model->insert_economic_control($idClub, $concept, $amount, $type, $datetime, $match->id,$match->idDivision);
               }
        $data['get_cards'] = $this->Control_economic_model->get_cards($idClub);
        //echo "<pre>"; print_r($data['get_cards']);echo "</pre>";
        foreach ($data['get_cards'] as $card) {
            $totalPrice = ($card->yellowCards * $card->yellowCardRate) + ($card->blueCards * $card->blueCardRate);
            $balance = $balance - $totalPrice;

            $concept = $card->name . " - " . $card->yellowCards . " tarjetes grogues i " . $card->blueCards . " tarjetes blaves";
            $amount = $totalPrice;
            $datetime = $card->updateddatetime;
            $type = 'Tarjetes';
            $this->Control_economic_model->insert_economic_control($idClub, $concept, $amount, $type, $datetime, 0,$card->idDivision);
            }
        
        $this->Control_economic_model->update_club_balance($idClub, $balance);
        $this->Control_economic_model->update_economic_control_by_idClubAndType($idClub);
       
    }

    function fer_pagaments($idClub) {
        foreach ($_POST as $key => $value) {
            $key = str_replace("item_", "", $key);
            $this->Control_economic_model->insert_settlement($idClub, $key);
        }
        $this->saldo($idClub);
        redirect("admin/control_economic/club/" . $idClub);
    }

    function arbitre($idReferee) {
        if ($this->session->userdata('logged_in')) {
            $session = $this->session->userdata('logged_in');
            $this->load->view('templates/admin/header', $session);
            $data['get_mail_notread'] = $this->mail_model->get_mail_notread($session['id']);
            $this->load->view('templates/admin/notifications', $data);
            $data['get_user_permissions'] = $this->user_model->get_user_permissions($session['id']);
            $this->load->view('admin/menu', $data);
            $this->load->view('templates/admin/content');
            $data = $this->arbitre_model->get_referee_info($idReferee);
            $data['get_refereed_matches_by_idReferee'] = $this->Control_economic_model->get_refereed_matches_by_idReferee($idReferee);
            $this->load->view('admin/control_economic_arbitre', $data);
            $this->load->view('templates/admin/footer');
        } else {
            redirect('admin/login', 'refresh');
        }
    }

    function deshabilita_kilometratge($idRef, $idReferee, $v) {
        if ($this->session->userdata('logged_in')) {
            $session = $this->session->userdata('logged_in');
            $this->log_model->insert_log($session['id'], $idRef, 'ha deshabilitat el kilometratge al partit.');
            $this->Control_economic_model->excludeKM($idRef, $v);
            redirect("admin/control_economic/arbitre/" . $idReferee);
        } else {
            redirect('admin/login', 'refresh');
        }
    }

    function ingres() {
        if ($this->session->userdata('logged_in')) {
            $session = $this->session->userdata('logged_in');
            $data = $this->Control_economic_model->insert_payment();
            $this->log_model->insert_log($session['id'], $_POST['idClub'], 'ha fet un ingrés al club.');

            $data1 = array('subject' => 'FCFS - Comanda ' . $data . ' pagament sol·licitat per banc', 'senderName' => 'Federació Catalana de Futbol Sala',
                'receiverName' => $session['name'], 'message' => 'Ha escollit la forma de pagament per transferència bancària:
<br /><br />
<strong>DETALLS DE LA SEVA COMANDA</strong><br />

Per un import total de: <strong>' . $_POST['amount'] . '</strong> € 
<br /><br />
<strong>INFORMACIÓ DEL PAGAMENT</strong><br /><br/>
Ha d\'especificar com a concepte d\'ingrés el següent codi:

<strong>' . $data . '</strong><br /><br />
El número de compte on pot realitzar la transferència és un dels següents:
<br />
<br />Banco Popular (Espanya) IBAN: ES11 0075 0973 0606 0609 4088', 'idSender' => 267, 'idReceiver' => $session['id']);
            $this->db->set('insertedDate', 'NOW()', FALSE);
            $this->db->insert('mailControl', $data1);

            redirect('admin/Control_economic', 'refresh');
        } else {
            redirect('admin/login', 'refresh');
        }
    } 

    function ingres_verifica() {
        if ($this->session->userdata('logged_in')) {
            $session = $this->session->userdata('logged_in');
            $data = $this->Control_economic_model->update_payment();
            if ($data) {
                $this->log_model->insert_log($session['id'], $data, 'ha fet un verificat l\'ingrés al club.');
                $data1 = array('subject' => 'FCFS - Comanda ' . $_POST['code'] . ' ha estat pagada.', 'senderName' => 'Federació Catalana de Futbol Sala',
                    'receiverName' => $session['name'], 'message' => 'la comanda ' . $_POST['code'] . ' ha estat pagada.</strong>', 'idSender' => 267, 'idReceiver' => $session['id']);
                $this->db->set('insertedDate', 'NOW()', FALSE);
                $this->db->insert('mailControl', $data1);
            }
            redirect('admin/Control_economic/admin', 'refresh');
        } else {
            redirect('admin/login', 'refresh');
        }
    }

    function fer_ingres_admin($idClub) {
        $_POST['idClub']=$idClub;
        if ($this->session->userdata('logged_in')) {
            $session = $this->session->userdata('logged_in');
            $data = $this->Control_economic_model->insert_payment();
            $_POST['code']=$data;
            $this->Control_economic_model->update_payment();
            $this->log_model->insert_log($session['id'], $_POST['idClub'], 'ha fet un ingrés al club.');
         $this->saldo($idClub);
        redirect("admin/control_economic/club/" . $idClub);
            
        } else {
            redirect('admin/login', 'refresh');
        }
    }

    function preus() {
        if ($this->session->userdata('logged_in')) {
            $session = $this->session->userdata('logged_in');
            $session = $this->session->userdata('logged_in');
            $this->load->view('templates/admin/header', $session);
            $data['get_mail_notread'] = $this->mail_model->get_mail_notread($session['id']);
            $this->load->view('templates/admin/notifications', $data);
            $data['get_user_permissions'] = $this->user_model->get_user_permissions($session['id']);
            $this->load->view('admin/menu', $data);
            $this->load->view('templates/admin/content');
            $data['divisions'] = $this->Competicio_model->get_divisions();
            $this->load->view('admin/control_economic_preus', $data);
            $this->load->view('templates/admin/footer');
        } else {
            redirect('admin/login', 'refresh');
        }
    }

    function modifica_preus($table, $division, $type, $value) {
        if ($this->session->userdata('logged_in')) {
            $session = $this->session->userdata('logged_in');

            if ($table == 'player') {
                $this->Control_economic_model->update_player_price($division, $value);
                $t = " fitxa ";
            }
            if ($table == 'team') {
                $this->Control_economic_model->update_team_price($division, $value);
                $t = " inscripcio ";
            }
            if ($table == 'referee') {
                $this->Control_economic_model->update_referee_price($division, $value);
                $t = " arbitratge ";
            }
            if ($table == 'referee_fee') {
                $this->Control_economic_model->update_referee_fee_price($division, $value, $type);
                $t = ' arbitre ';
            }
            if ($table == 'cards') {
                $this->Control_economic_model->update_card_price($division, $value, $type);
                $t = ' tarjeta ';
            }
            $this->log_model->insert_log($session['id'], $division, 'ha modificat el preu de ' . $t);
        }
    }

}
