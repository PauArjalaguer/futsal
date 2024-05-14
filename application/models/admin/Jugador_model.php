<?php

Class Jugador_model extends CI_Model {

    function insert_player($idSeason) {

        list($firstName, $surName, $surName2) = explode(' ', $_POST['playerName']);
        $surName = $surName . " " . $surName2;
        $data = array('name' => $_POST['playerName'], 'firstName' => $firstName, 'surName' => $surName);

        $this->db->insert('players', $data);
        $insert_id = $this->db->insert_id();

        $data = array('idPlayer' => $insert_id, 'idSeason' => $idSeason, 'idTeam' => $_POST['idTeam']);
        $this->db->set('insertedDate', 'NOW()', FALSE);
        $this->db->insert('player_team_season', $data);
        return $insert_id;
    }

    function get_player_positions() {
        $this->db->select('id,position');
        $this->db->from('playerPositions');
        $query = $this->db->get();
        return $query->result();
    }

    function get_player_info($idPlayer, $idClub, $idSeason) {
        $this->db->select('players.id    , birthdate
    ,players.name as playerName
    ,players.image
    ,dni
    ,DNIscan
    ,nif
    ,address
    ,addressNumber
    ,Floor as addressFloor
    ,Door as addressDoor
    ,City as addressCity
    ,Province as addressProvince
    ,cp
    ,Nationality
    ,CountryOfBirth
    ,CityOfBirth
    ,ProvinceOfBirth
    ,Email as playerEmail
    ,notes as playerNotes
    ,playerCards_warned.text as rejectedReason
    ,idUniversity
    ,player_team_season.id as idCard
    ,teams.id as idTeam
    ,teams.name as teamName
    ,teams.idClub
    ,insuranceScan
    ,firstName
    ,surName
    ,position
    ,statusPercent
    ,player_insurance.scan
    ,isPayed ');
        $this->db->from('players');
        $this->db->join('player_team_season', 'players.id=player_team_season.idPlayer');
        $this->db->join('teams', 'teams.id=player_team_season.idteam');
        $this->db->join('playerCards_warned', 'playerCards_warned.idCard=player_team_season.id', 'left');
        $this->db->join('player_insurance', 'player_insurance.idplayer=players.id', 'left');
        $this->db->where('players.id', $idPlayer);
        $this->db->where('teams.idclub', $idClub);
        $this->db->where('idSeason', $idSeason);
        $query = $this->db->get();

        return $query->row_array();
        //  echo $this->db->last_query();
    }

    function get_player_info_idPlayerOnly($idPlayer) {
        $this->db->select('players.id    , birthdate
    ,players.name as playerName
    ,players.image
    ,dni
    ,DNIscan
    ,nif
    ,address
    ,addressNumber
    ,Floor as addressFloor
    ,Door as addressDoor
    ,City as addressCity
    ,Province as addressProvince
    ,cp
    ,Nationality
    ,CountryOfBirth
    ,CityOfBirth
    ,ProvinceOfBirth
    ,Email as playerEmail
    ,notes as playerNotes
    ,playerCards_warned.text as rejectedReason
    ,idUniversity
    ,player_team_season.id as idCard
    ,teams.id as idTeam
    ,teams.name as teamName
    ,teams.idClub
    ,insuranceScan
    ,firstName
    ,surName
    ,position
    ,statusPercent
   
    ,isPayed ');
        $this->db->from('players');
        $this->db->join('player_team_season', 'players.id=player_team_season.idPlayer');
        $this->db->join('teams', 'teams.id=player_team_season.idteam');
        $this->db->join('playerCards_warned', 'playerCards_warned.idCard=player_team_season.id', 'left');
        // $this->db->join('player_insurance', 'player_insurance.idplayer=players.id', 'left');
        $this->db->where('players.id', $idPlayer);

        $this->db->where('idSeason', CURRENT_SEASON);
        $query = $this->db->get();

        return $query->row_array();
        //  echo $this->db->last_query();
    }

    function update_player_info() {
        $n = 0;
        /* echo "<pre>";
          print_r($_POST);
          echo "</pre>"; */
        if ($_POST['playerBirthDate']) {
            $d = explode("-", $_POST['playerBirthDate']);
            $_POST['playerBirthDate'] = $d[2] . "-" . $d[1] . "-" . $d[0];
        }
        $data = array('name' => $_POST['playerName'] . " " . $_POST['playerSurname'], 'firstName' => $_POST['playerName'], 'surName' => $_POST['playerSurname'], 'dni' => $_POST['playerDNI'], 'nif' => $_POST['playerNIF'], 'birthdate' => $_POST['playerBirthDate'], 'address' => $_POST['playerStreet'], 'addressNumber' => $_POST['playerStreetNumber'], 'floor' => $_POST['playerFloor'], 'door' => $_POST['playerDoor'], 'city' => $_POST['playerCity'], 'cp' => $_POST['playerCP'], 'province' => $_POST['playerProvince'], 'notes' => $_POST['playerNotes'], 'provinceOfBirth' => $_POST['playerProvince'], 'provinceOfBirth' => $_POST['playerProvince']);
        $this->db->where('id', $_POST['idPlayer']);
        $this->db->update('players', $data);
        // echo $this->db->last_query();

        if ($_POST['playerName']) {
            $n++;
        }
        if ($_POST['playerSurname']) {
            $n++;
        }
        if ($_POST['playerPosition']) {
            $n++;
        }

        if ($_POST['playerBirthDate']) {
            $n++;
        }
        if ($_POST['playerCity']) {
            $n++;
        }
        if ($_POST['playerProvince']) {
            $n++;
        }

        if ($_POST['playerStreet']) {
            $n++;
        }
        if ($_POST['playerStreetNumber']) {
            $n++;
        }
        if ($_POST['playerCP']) {
            $n++;
        }
        if ($_POST['playerImage']) {
            $n++;
        }
        if ($_POST['playerDNI']) {
            $n++;
        }
        if ($_POST['playerInsurance']) {
            $n++;
        }
        $status = ($n / 12) * 100;
        //echo $n . " " . $status;
        $data = array('statusPercent' => $status, 'position' => $_POST['playerPosition']);
        $this->db->set('updateddate', 'NOW()', FALSE);
        $this->db->where('id', $_POST['idCard']);
        $this->db->update('player_team_season', $data);
        return $_POST['playerName'] . " " . $_POST['playerSurname'];
    }

    function update_player_image($idPlayer) {
        $image = $idPlayer . '.jpg';
        $data = array('image' => $image);
        $this->db->where('id', $idPlayer);
        $this->db->update('players', $data);
    }

    function update_player_scan($idPlayer, $type) {
        $image = $idPlayer . '_' . $type . '.jpg';
        if ($type == 'dni') {
            $data = array('dniScan' => $image);
        } else {
            $data = array('insuranceScan' => $image);
        }

        $this->db->where('id', $idPlayer);
        $this->db->update('players', $data);
    }

    function delete_player_image($idPlayer) {

        $this->db->set('image', 'null', FALSE);
        $this->db->where('id', $idPlayer);
        $this->db->update('players');
    }

    function delete_player_scan($idPlayer, $type) {
        if ($type == 'dni') {
            $this->db->set('dniScan', 'null', FALSE);
        } else {
            $this->db->set('insuranceScan', 'null', FALSE);
        }
        $this->db->where('id', $idPlayer);
        $this->db->update('players');
    }

    function delete_player($idPlayer, $idSeason) {
        $this->db->delete('player_team_season', array('idPlayer' => $idPlayer, 'idSeason' => $idSeason));
    }

    function activate_player($idPlayer, $idSeason, $idTeam) {
        $data = array('idPlayer' => $idPlayer, 'idSeason' => $idSeason, 'idTeam' => $idTeam);
        $this->db->set('insertedDate', 'NOW()', FALSE);
        $this->db->insert('player_team_season', $data);
       // echo $this->db->last_query();
    }

    function dni_search($dni) {
        $this->db->select("id, name");
        $this->db->where("dni", $dni);
        $this->db->from("players");
        $query = $this->db->get();
        return $query->result();
    }

    function check_percent_update($idCard, $statusPercent) {
        $data = array('statusPercent' => $statusPercent);
        $this->db->set('updateddate', 'NOW()', FALSE);
        $this->db->where('id', $idCard);
        $this->db->update('player_team_season', $data);
    }

    function mark_as_payed($idPlayer) {
        $data = array('isPayed' => 1);
        $this->db->set('paymentDate', 'NOW()', FALSE);
        $this->db->where('idPlayer', $idPlayer);
        $this->db->where('idSeason', CURRENT_SEASON);
        $this->db->update('player_team_season', $data);
        //echo $this->db->last_query();
    }

}
