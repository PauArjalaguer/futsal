<?php

Class Arbitre_model extends CI_Model {

    function get_all_referees() {
        $this->db->select('id,name,delegationName');
        $this->db->from('rfrReferees r');
        $this->db->join('delegations d', 'd.idDelegation=r.idDelegation');
        $this->db->where('isDeleted', 0);
        $this->db->order_by('delegationName, name');
        $query = $this->db->get();
        return $query->result();
    }

    function get_referee_info($idReferee) {
        $this->db->select('r.id,r.name,birthdate,dni, city, province,bankAccount,r.idDelegation,delegationName, telephone, email');
        $this->db->from('rfrReferees r');
        $this->db->join('delegations d', 'd.idDelegation=r.idDelegation');
        $this->db->join('usersAccounts u', 'u.idReferee=r.id');
        $this->db->where('r.id', $idReferee);
        $query = $this->db->get(); //echo $idReferee." ".$this->db->last_query();
        return $query->row_array();
    }

    function get_delegations() {
        $this->db->select('idDelegation,delegationName');
        $this->db->from('delegations');

        $query = $this->db->get(); //echo $idReferee." ".$this->db->last_query();
        return $query->result();
    }

    function insert_referee() {
        $data = array('name' => $_POST['refereeName'], 'idDelegation' => $_POST['delegation']);
        $this->db->insert('rfrreferees', $data);
        $insert_id = $this->db->insert_id();
        $password = generateRandomString();
        $data = array('name' => $_POST['refereeName'], 'login' => $_POST['refereeEmail'], 'email' => $_POST['refereeEmail'], 'password' => $password, 'idReferee' => $insert_id);
        $this->db->insert('usersaccounts', $data);
        $accountId = $this->db->insert_id();
        $data1 = array('subject' => 'FCFS - Alta arbitre.', 'senderName' => 'Federació Catalana de Futbol Sala',
            'receiverName' => $_POST['refereeName'], "message" => "El teu usuari i contrassenya és " . $_POST['refereeEmail'] . " i " . $password . "</strong>", 'idSender' => 267, 'idReceiver' => $accountId);
        $this->db->set('insertedDate', 'NOW()', FALSE);
        $this->db->insert('mailControl', $data1);
        return $insert_id;
    }

    function update_referee_info() {
        $data = array('name' => $_POST['rfrName'], 'birthDate' => invertdateformat($_POST['rfrBirthdate']), 'dni' => $_POST['rfrDni'], 'city' => $_POST['rfrCity'], 'province' => $_POST['rfrProvince'], 'idDelegation' => $_POST['rfrDelegation'], 'telephone' => $_POST['rfrTelephone'], 'bankAccount' => $_POST['rfrAccount']);
        $this->db->where('id', $_POST['rfrId']);
        $this->db->update('rfrReferees', $data);

        $data = array('email' => $_POST['rfrEmail'], 'login' => $_POST['rfrEmail']);
        $this->db->where('idReferee', $_POST['rfrId']);
        $this->db->update('usersAccounts', $data);
    }

    function get_matches($idReferee) {
        $query = $this->db->query("SELECT 
            t1.name as local,
            t2.name as visitor,
           m.id as idMatch,
            m.statusId,
            t1.id as idLocal,
            t2.id as idVisitor,
           c1.image as localImage,
            c2.image as visitorImage,
            cl.complexName,
            cl.complexAddress,
            r.name as roundName,
            r.id as roundId,
            r.initialDate,
            r.endDate,
            m.updateddatetime,
            date_format(m.updateddatetime,'%j')  as date_format,
            datediff(now(),updateddatetime) as dies,
            l.id as idLeague, distance,
            isDriver
        from matches m
join rounds r on r.id=m.idRound
join teams t1 on t1.id=m.idLocal
join teams t2 on t2.id=m.idvisitor
join clubs c1 on c1.id=t1.idclub
join clubs c2 on c2.id=t2.idclub
left join complex cl on cl.id=m.place
join leagues l on l.id=r.idleague
join divisions d on d.id=l.iddivision
join cmptMatch_Referee cr on cr.idmatch=m.id
join rfrReferees ref on ref.id=cr.idReferee
left join complex_to_delegation_distance cdd on cdd.idComplex=m.place and cdd.idDelegation=ref.idDelegation
where 
l.idseason=" . CURRENT_SEASON . " and idReferee=" . $idReferee . " order by r.name asc");
        return $query->result();
    }

    function update_allowance_and_km($idReferee, $idMatch, $allowance, $distance) {
        $data = array('allowance' => $allowance, 'km' => $distance);
        $this->db->where('idMatch', $idMatch);
        $this->db->where('idReferee', $idReferee);
        $this->db->update('cmptMatch_Referee', $data);
        echo "<br />" . $this->db->last_query() . "<hr />";

        $this->db->query("update cmptMatch_Referee set excludeKM=1 where isDriver=0");
    }

    function get_match_status_by_idReferee($idMatch, $idReferee) {
        $this->db->select('accepted');
        $this->db->from('cmptMatch_Referee');
        $this->db->where('idMatch', $idMatch);
        $this->db->where('idReferee', $idReferee);
        $query = $this->db->get();
        return $query->row_array();
    }

    function update_match_status_by_idReferee($idMatch, $idReferee, $status) {
        $data = array('accepted' => $status);
        $this->db->where('idMatch', $idMatch);
        $this->db->where('idReferee', $idReferee);
        $this->db->update('cmptMatch_Referee', $data);

        $this->db->select('matches.id, idLocal,idVisitor, updateddatetime, statusId, complex.id as idComplex,comment,complex.complexName, complexAddress, t1.name as localName,t2.name as visitorName, rounds.id as idRound,rounds.name as roundName, leagues.id as idLeague, leagues.name as leagueName, c1.image as localImage, c2.image as visitorImage, localResult, visitorResult, initialDate,endDate, t2.idClub, u1.id as account1,u2.id as account2 ');
        $this->db->from('matches');
        $this->db->join('complex', 'matches.place=complex.id', 'left');
        $this->db->join('teams t1', 'matches.idLocal=t1.id');
        $this->db->join('teams t2', 'matches.idVisitor=t2.id');
        $this->db->join('clubs c1', 't1.idClub=c1.id');
        $this->db->join('clubs c2', 't2.idClub=c2.id');
        $this->db->join('rounds', 'rounds.id=matches.idRound');
        $this->db->join('results', 'results.idMatch=matches.id', 'left');
        $this->db->join('leagues', 'leagues.id=rounds.idLeague');
        $this->db->join('usersAccounts u1', 'u1.idClub=c1.id', 'left');
        $this->db->join('usersAccounts u2', 'u2.idClub=c2.id', 'left');
        $this->db->where('matches.id', $idMatch);
        $query = $this->db->get();
        $r = $query->row_array();
        $session = $this->session->userdata('logged_in');
        $localName = $r['localName'];
        $visitorName = $r['visitorName'];
          $playingDay = $r['updateddatetime'];
        $m = explode(" ", $playingDay);
        $hour = $m[1];
        if ($status == 1) {
            $data1 = array('subject' => 'FCFS - ' . $session['name'] . ' ha acceptat el partit ' . $localName . '- ' . $visitorName, 'senderName' => 'Federació Catalana de Futbol Sala', 'receiverName' => 'Arbitratge', 'message' => $session['name'] . ' ha acceptat el partit ' . $localName . ' - ' . $visitorName . "<br />Es celebrarà el " . invertdateformat($playingDay) . " a les " . $hour, 'idSender' => 267, 'idReceiver' => 267);
        } else {
            $data1 = array('subject' => 'FCFS - ' . $session['name'] . ' ha rebutjat el partit ' . $localName . '- ' . $visitorName, 'senderName' => 'Federació Catalana de Futbol Sala', 'receiverName' => 'Arbitratge', 'message' => $session['name'] . ' ha rebutjat el partit ' . $localName . ' - ' . $visitorName . "<br />Es celebrarà el " . invertdateformat($playingDay) . " a les " . $hour, 'idSender' => 267, 'idReceiver' => 267);
        }
        $this->db->set('insertedDate', 'NOW()', FALSE);
        $this->db->insert('mailControl', $data1);
    }

}
