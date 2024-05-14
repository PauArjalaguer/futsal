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
            'receiverName' => $_POST['refereeName'], "message" => "El teu usuari i contrassenya és ".$_POST['refereeEmail']." i ".$password."</strong>", 'idSender' => 267, 'idReceiver' => $accountId);
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
            l.id as idLeague, distance
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
    }

}
