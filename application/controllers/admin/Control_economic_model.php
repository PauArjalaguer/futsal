<?php

Class Control_economic_model extends CI_Model {

    function get_unpayed_players($idClub) {
        $this->db->select('p.name as playerName, t.name as teamName, rate');
        $this->db->from('player_team_season pts');
        $this->db->join('players p', 'p.id=pts.idPlayer');
        $this->db->join('teams t', 't.id=pts.idTeam');
        $this->db->join('teams_divisions_per_season tds', 'tds.idTeam=t.id and tds.idSeason=pts.idSeason');
        $this->db->join('rate_division_season rds', 'rds.idDivision=tds.idDivision and rds.idSeason=pts.idSeason');

        $this->db->where('idClub', $idClub);
        $this->db->where('isPayed', 0);
        $this->db->where('statusPercent', 100);
        $query = $this->db->get();
//echo $this->db->last_query();
        return $query->result();
    }

    function get_payed_players($idClub) {
        $this->db->select('p.id,p.name as playerName, t.name as teamName, rate, paymentDate, datediff(now(),paymentDate) as d, position, tds.idDivision');
        $this->db->from('player_team_season pts');
        $this->db->join('players p', 'p.id=pts.idPlayer');
        $this->db->join('teams t', 't.id=pts.idTeam');
        $this->db->join('teams_divisions_per_season tds', 'tds.idTeam=t.id and tds.idSeason=pts.idSeason');
        $this->db->join('rate_division_season rds', 'rds.idDivision=tds.idDivision and rds.idSeason=pts.idSeason');
        $this->db->where('idClub', $idClub);
        $this->db->where('isPayed', 1);
        $this->db->where('statusPercent', 100);
        $this->db->where('pts.idSeason', CURRENT_SEASON);
        $query = $this->db->get();
        //echo $this->db->last_query();
        return $query->result();
    }

    function get_team_entries($idClub) {
        $this->db->select('t.name as teamName,rate,datetime, datediff(now(),datetime) as d, tds.idDivision,t.id');
        $this->db->from('teams_divisions_per_season tds');
        $this->db->join('teams t', 't.id=tds.idTeam');
        $this->db->join('rate_division_season_per_team rds', 'rds.idDivision=tds.idDivision and rds.idSeason=tds.idSeason');
        $this->db->where('idClub', $idClub);
        $this->db->where('tds.idSeason', CURRENT_SEASON);
        $query = $this->db->get();
        return $query->result();
    }

    function get_refereed_matches($idClub) {
        $this->db->select('m.id,t1.name as local, t2.name as visitor, rate,m.updateddatetime, datediff(now(),m.updateddatetime) as d, l.idDivision');
        $this->db->from('matches m');
        $this->db->join('teams t1', 't1.id=m.idLocal');
        $this->db->join('teams t2', 't2.id=m.idVisitor');
        $this->db->join('rounds r', 'r.id=m.idRound');
        $this->db->join('leagues l', 'l.id=r.idLeague');
        $this->db->join('rfrPricePerMatchbyDivisionAndSeason rfr', 'rfr.idDivision=l.idDivision and l.idSeason=rfr.idSeason');
        $this->db->where('t1.idClub', $idClub);
        $this->db->where('statusid', 4);
        $this->db->where('l.idSeason', CURRENT_SEASON);
        $query = $this->db->get();
        //echo $this->db->last_query();
        return $query->result();
    }

    function get_cards($idClub) {
        $this->db->select('p.name,yellowCards,blueCards, yellowCardRate, blueCardRate,m.updateddatetime,datediff(now(),m.updateddatetime) as d,idDivision');
        $this->db->from('player_card_match pcm');
        $this->db->join('matches m', 'm.id=pcm.idmatch');
        $this->db->join('rounds r', 'r.id=m.idRound');
        $this->db->join('leagues l', 'l.id=r.idLeague');
        $this->db->join('players p', 'p.id=pcm.idplayer');
        $this->db->join('player_team_season pts', 'pts.idPlayer=p.id and pts.idSeason=l.idSeason');
        $this->db->join('teams t1', 't1.id=m.idLocal');
        $this->db->join('admcardpriceperseason aps', 'l.idSeason=aps.idSeason');
        $this->db->where('t1.idClub', $idClub);
        $this->db->where('l.idSeason', CURRENT_SEASON);
        $query = $this->db->get();
        //echo $this->db->last_query();
        return $query->result();
    }

    function get_payments($idClub) {
        $this->db->select('code,amount,datetime,datediff(now(),datetime) as d');
        $this->db->from('admClubPayments');
        $this->db->where('idClub', $idClub);
        $this->db->where('idSeason', CURRENT_SEASON);
        $this->db->where('checked', 1);
        $query = $this->db->get();
        //echo $this->db->last_query();
        return $query->result();
    }

    function update_club_balance($idClub, $balance) {
        $data = array('balance' => $balance);
        $this->db->where('id', $idClub);
        $this->db->update('clubs', $data);
    }

    function get_club_balance($idClub) {
        $this->db->select('balance');
        $this->db->from('clubs');
        $this->db->where('id', $idClub);
        $query = $this->db->get();
        return $query->row_array();
    }

    function get_refereed_matches_by_idReferee($idReferee) {
        $this->db->select('t1.name as local, t2.name as visitor, price, updateddatetime, distance,allowance,excludeKM,cmr.id as idRef');
        $this->db->from('matches m');
        $this->db->join('teams t1', 't1.id=m.idLocal');
        $this->db->join('teams t2', 't2.id=m.idVisitor');
        $this->db->join('rounds r', 'r.id=m.idRound');
        $this->db->join('leagues l', 'l.id=r.idLeague');
        $this->db->join('cmptMatch_Referee cmr', 'cmr.idMatch=m.id');
        $this->db->join('rfrReferees ref', 'ref.id=cmr.idReferee');
        $this->db->join('rfrPricePerRefereeByDivisionAndSeason rfr', 'rfr.idDivision=l.idDivision and l.idSeason=rfr.idSeason and rfr.idRefereeType=cmr.idRefereeType', 'left');
        $this->db->join('complex_to_delegation_distance cd', 'cd.idComplex=m.place and cd.idDelegation=ref.idDelegation');
        $this->db->where('cmr.idReferee', $idReferee);
        $this->db->where('statusid', 4);
        $this->db->where('l.idSeason', CURRENT_SEASON);
        $this->db->order_by('updateddatetime');
        $query = $this->db->get();
         echo $this->db->last_query();
        return $query->result();
    }

    function excludeKM($idRef, $v) {
        $this->db->query("update cmptMatch_Referee set excludeKM=$v where id=" . $idRef);
    }

    function insert_payment() {
        $code = generateRandomString();
        $data = array('idClub' => $_POST['idClub'], 'amount' => $_POST['amount'], 'idSeason' => CURRENT_SEASON, 'code' => $code);
        // $this->db->insert('teams_leagues_per_season', $data);
        $this->db->insert('admClubPayments', $data);

        return $code;
    }

    function update_payment() {

        $this->db->set('datetime', 'NOW()', FALSE);
        $_POST['date'] = str_replace("/", "-", $_POST['date']);
        if ($_POST['date']) {
            $data = array('checked' => 1, 'datetime' => $_POST['date']);
        } else {
            $data = array('checked' => 1);
        }
        $this->db->where('code', $_POST['code']);
        $this->db->where('amount', $_POST['amount']);
        $this->db->update('admClubPayments', $data);

        $this->db->select('id');
        $this->db->from('admClubPayments');
        $this->db->where('code', $_POST['code']);
        $this->db->where('amount', $_POST['amount']);
        $query = $this->db->get();
        $d = $query->row_array();
        return $d['id'];
    }

    function insert_movement() {

        $data = array("idClub" => $_POST['idClub'], "amount" => $_POST['amount'], "concept" => $_POST['concept'], "datetime" => $_POST['date'], "type" => $_POST['concept'], "idSeason" => CURRENT_SEASON);
        $this->db->insert('admEconomicControlPerClub', $data);
       // echo $this->db->last_query();
    }

    function clubs_with_negative_balance() {
        $this->db->select('c.id,name,balance, totalPending,available,totalPaid');
        $this->db->from('clubs c');
        $this->db->join('admEconomicControlPerClubByTypeAndIdClub aec', 'aec.idClub=c.id');

        $this->db->order_by('c.name', 'asc');
        // $this->db->where('balance<0');
        $query = $this->db->get();

        return $query->result();
    }

    function get_player_price_by_idDivision($idDivision) {
        $this->db->select('rate,idDivision');
        $this->db->from('rate_division_season');
        $this->db->where('idSeason', CURRENT_SEASON);
        $this->db->where('idDivision', $idDivision);
        $query = $this->db->get();
        //echo $this->db->last_query();
        return $query->row_array();
    }

    function get_team_price_by_idDivision($idDivision) {
        $this->db->select('rate,idDivision');
        $this->db->from('rate_division_season_per_team');
        $this->db->where('idSeason', CURRENT_SEASON);
        $this->db->where('idDivision', $idDivision);
        $query = $this->db->get();
        //echo $this->db->last_query();
        return $query->row_array();
    }

    function get_referee_price_by_idDivision($idDivision) {
        $this->db->select('rate,idDivision');
        $this->db->from('rfrPricePerMatchbyDivisionAndSeason');
        $this->db->where('idSeason', CURRENT_SEASON);
        $this->db->where('idDivision', $idDivision);
        $query = $this->db->get();
        //echo $this->db->last_query();
        return $query->row_array();
    }

    function get_referee_fee_by_idDivision($idDivision, $idRefereeType) {
        $this->db->select('price,idDivision');
        $this->db->from('rfrPricePerRefereeByDivisionAndSeason');
        $this->db->where('idSeason', CURRENT_SEASON);
        $this->db->where('idDivision', $idDivision);
        $this->db->where('idRefereeType', $idRefereeType);
        $query = $this->db->get();
        //echo $this->db->last_query();
        return $query->row_array();
    }

    function get_card_by_idDivision($idDivision) {
        $this->db->select('yellowCardRate, blueCardRate');
        $this->db->from('admcardpriceperseason');
        $this->db->where('idSeason', CURRENT_SEASON);

        $query = $this->db->get();
        //echo $this->db->last_query();
        return $query->row_array();
    }

    function update_player_price($idDivision, $value) {
        $query = $this->db->query("SELECT idDivision FROM rate_division_season
                           WHERE idDivision = $idDivision and idSeason=" . CURRENT_SEASON . " limit 1");

        $data = array('idDivision' => $idDivision, 'idSeason' => CURRENT_SEASON, 'rate' => $value);
        // $this->db->insert('teams_leagues_per_season', $data);
        $query->num_rows() == 0 ? $this->db->insert('rate_division_season', $data) : $this->db->query("update rate_division_season set rate=$value where idSeason=" . CURRENT_SEASON . " and idDivision=$idDivision");
        echo $this->db->last_query();
    }

    function update_team_price($idDivision, $value) {
        $query = $this->db->query("SELECT idDivision FROM rate_division_season_per_team
                           WHERE idDivision = $idDivision and idSeason=" . CURRENT_SEASON . " limit 1");
//echo "<hr />".$this->db->last_query();
        $data = array('idDivision' => $idDivision, 'idSeason' => CURRENT_SEASON, 'rate' => $value);
        // $this->db->insert('teams_leagues_per_season', $data);
        $query->num_rows() == 0 ? $this->db->insert('rate_division_season_per_team', $data) : $this->db->query("update rate_division_season_per_team set rate=$value where idSeason=" . CURRENT_SEASON . " and idDivision=$idDivision");
        //   echo $this->db->last_query();
    }

    function update_referee_price($idDivision, $value) {
        $query = $this->db->query("SELECT idDivision FROM rfrPricePerMatchbyDivisionAndSeason
                           WHERE idDivision = $idDivision and idSeason=" . CURRENT_SEASON . " limit 1");
        //echo "<hr />" . $this->db->last_query();
        $data = array('idDivision' => $idDivision, 'idSeason' => CURRENT_SEASON, 'rate' => $value);
        // $this->db->insert('teams_leagues_per_season', $data);
        $query->num_rows() == 0 ? $this->db->insert('rfrPricePerMatchbyDivisionAndSeason', $data) : $this->db->query("update rfrPricePerMatchbyDivisionAndSeason set rate=$value where idSeason=" . CURRENT_SEASON . " and idDivision=$idDivision");
        //  echo $this->db->last_query();
    }

    function update_referee_fee_price($idDivision, $value, $type) {

        $query = $this->db->query("SELECT idDivision FROM rfrPricePerRefereeByDivisionAndSeason
                           WHERE idDivision = $idDivision and idSeason=" . CURRENT_SEASON . " and idRefereeType=$type limit 1");
        // echo "<hr />" . $this->db->last_query();
        $data = array('idDivision' => $idDivision, 'idSeason' => CURRENT_SEASON, 'price' => $value, 'idRefereeType' => $type);
        // $this->db->insert('teams_leagues_per_season', $data);
        $query->num_rows() == 0 ? $this->db->insert('rfrPricePerRefereeByDivisionAndSeason', $data) : $this->db->query("update rfrPricePerRefereeByDivisionAndSeason set price=$value where idSeason=" . CURRENT_SEASON . " and idDivision=$idDivision and idRefereeType=$type");
        // echo $this->db->last_query();
    }

    function update_card_price($idDivision, $value, $type) {
        if ($type = 1) {
            $t = 'yellowCardRate';
        } else {
            $t = 'blueCardRate';
        }
        $query = $this->db->query("SELECT idSeason FROM admcardpriceperseason
                           WHERE  idSeason=" . CURRENT_SEASON . " limit 1");
        //echo "<hr />" . $this->db->last_query();
        $data = array('idSeason' => CURRENT_SEASON, $t => $value);
        // $this->db->insert('teams_leagues_per_season', $data);
        $query->num_rows() == 0 ? $this->db->insert('admcardpriceperseason', $data) : $this->db->query("update admcardpriceperseason set $t=$value where idSeason=" . CURRENT_SEASON);
        //echo $this->db->last_query();
    }

    function insert_economic_control($idClub, $concept, $amount, $type, $datetime, $idItem = 0, $idDivision = 0) {
        $query = $this->db->query("SELECT concept FROM admEconomicControlPerClub
                           WHERE  idClub=" . $idClub . " and concept='" . addslashes($concept) . "' and datetime='$datetime' and amount=$amount limit 1");
        // echo "<hr />" . $this->db->last_query();
        $data = array('idClub' => $idClub, 'concept' => $concept, 'amount' => $amount, 'type' => $type, 'datetime' => $datetime, 'idSeason' => CURRENT_SEASON, 'idItem' => $idItem, 'idDivision' => $idDivision);
        // $this->db->insert('teams_leagues_per_season', $data);
        $query->num_rows() == 0 ? $this->db->insert('admEconomicControlPerClub', $data) : false;
        //echo $this->db->last_query();
    }

    function get_economic_control_by_idClub($idClub) {
        $this->db->select('aec.id,idClub, concept, datetime,type, amount,datediff(now(),datetime) as diff, isPaid, d.name');
        $this->db->from('admEconomicControlPerClub aec');
        $this->db->join('divisions d', 'd.id=aec.idDivision','left');
        $this->db->where('idClub', $idClub);
        $this->db->where('idSeason', CURRENT_SEASON);
        $this->db->order_by('datetime', 'desc');
        $query = $this->db->get();
        //echo $this->db->last_query();
        return $query->result();
    }

    function get_economic_control_by_idClub_and_type($idClub) {
        $this->db->select('*');
        $this->db->from('admEconomicControlPerClubByTypeAndIdClub aec');
        $this->db->join('clubs c', 'c.id=aec.idClub');
        $this->db->where('idClub', $idClub);
        $this->db->where('idSeason', CURRENT_SEASON);
        $query = $this->db->get();
        // echo $this->db->last_query();
        return $query->row_array();
    }

    function update_economic_control_by_idClubAndType($idClub) {
        $q = $this->db->query("select COALESCE(SUM(amount),0) as amount from admEconomicControlPerClub where idClub=" . $idClub . " and (type!='Fitxa' and type!='Fitxa delegat'  and type!='Inscripció' and type!='Arbitratge'  and type!='Tarjetes') and isPaid=1");
        $d = $q->row_array();
        // echo "<br />Total Jugadors pendents de pagar: " . 
        
        //echo $this->db->last_query();
        $totalPaidOthers = $d['amount'];
        $totalPaid = $totalPaidOthers ;
        
         $q = $this->db->query("select COALESCE(SUM(amount),0) as amount from admEconomicControlPerClub where idClub=" . $idClub . " and (type!='Fitxa'  and type!='Fitxa delegat'  and type!='Inscripció' and type!='Arbitratge'  and type!='Tarjetes') and isPaid=0");
        $d = $q->row_array();
        // echo "<br />Total Jugadors pendents de pagar: " . 
        $totalOthersToBePaid = $d['amount'];
        $totalPending = $totalOthersToBePaid ;
        
        
        
        $q = $this->db->query("select COALESCE(SUM(amount),0) as amount from admEconomicControlPerClub where idClub=" . $idClub . " and (type='Fitxa'  or type='Fitxa delegat')   and isPaid=1");
        $d = $q->row_array();
        // echo "<br />Total Jugadors pendents de pagar: " . 
        $totalPaidPlayers = $d['amount'];
        $totalPaid = $totalPaidPlayers + $totalPaid;

        $q = $this->db->query("select COALESCE(SUM(amount),0) as amount from admEconomicControlPerClub where idClub=" . $idClub . " and (type='Fitxa'  or type='Fitxa delegat') and isPaid=0");
        $d = $q->row_array();
        // echo "<br />Total Jugadors pagats: " . 
        $totalPlayersToBePaid = $d['amount'];
        $totalPending = $totalPlayersToBePaid +$totalPending;

        $q = $this->db->query("select COALESCE(SUM(amount),0) as amount from admEconomicControlPerClub where idClub=" . $idClub . " and type='Inscripció' and isPaid=0");
        $d = $q->row_array();

        $totalTeamEntriesToBePaid = $d['amount'];
        $totalPending = $totalPending + $totalTeamEntriesToBePaid;

        $q = $this->db->query("select COALESCE(SUM(amount),0) as amount from admEconomicControlPerClub where idClub=" . $idClub . " and type='Inscripció' and isPaid=1");
        $d = $q->row_array();
        //echo "<br />Total inscripcions pagades: " . 
        //
        $totalPaidTeamEntries = $d['amount'];
        $totalPaid = $totalPaid + $totalPaidTeamEntries;

        $q = $this->db->query("select COALESCE(SUM(amount),0) as amount from admEconomicControlPerClub where idClub=" . $idClub . " and type='Arbitratge' and isPaid=0");
        $d = $q->row_array();
        //echo "<br />Total arbitratges pendents de pagar: " . 
        //
        $totalRefereedMatchesToBePaid = $d['amount'];
        $totalPending = $totalPending + $totalRefereedMatchesToBePaid;

        $q = $this->db->query("select COALESCE(SUM(amount),0) as amount from admEconomicControlPerClub where idClub=" . $idClub . " and type='Arbitratge' and isPaid=1");
        $d = $q->row_array();
        //echo "<br />Total arbitratges pagades: " . 
        //
        $totalPaidRefereedMatches = $d['amount'];
        $totalPaid = $totalPaid + $totalPaidRefereedMatches;

        $q = $this->db->query("select COALESCE(SUM(amount),0) as amount from admEconomicControlPerClub where idClub=" . $idClub . " and type='Tarjetes' and isPaid=0");
        $d = $q->row_array();
        //echo "<br />Total sancions pendents de pagar: " . 
        $totalCardsToBePaid = $d['amount'];
        $totalPending = $totalPending + $totalCardsToBePaid;

        $q = $this->db->query("select COALESCE(SUM(amount),0) as amount from admEconomicControlPerClub where idClub=" . $idClub . " and type='Tarjetes' and isPaid=1");
        $d = $q->row_array();
        //echo "<br />Total sancions pagades: " . 
        $totalPaidCards = $d['amount'];
        $totalPaid = $totalPaid + $totalPaidCards;

        $q = $this->db->query("select COALESCE(SUM(amount),0) as amount from admClubPayments where idClub=" . $idClub . "  and checked=1 and idSeason=" . CURRENT_SEASON);
        $d = $q->row_array();
        //echo "<br />Total sancions pagades: " . 
        $totalPayments = $d['amount'];

        $totalPlayers = $totalPaidPlayers + $totalPlayersToBePaid;
        $totalTeamEntries = $totalPaidTeamEntries + $totalTeamEntriesToBePaid;
        $totalCards = $totalCardsToBePaid + $totalPaidCards;
        $totalRefereedMatches = $totalPaidRefereedMatches + $totalRefereedMatchesToBePaid;
        $totalOthers=$totalOthersToBePaid+$totalPaidOthers;
        $query = $this->db->query("select id from admEconomicControlPerClubByTypeAndIdClub where idClub=" . $idClub . " and idSeason=" . CURRENT_SEASON);

        $available = $totalPayments - $totalPaid;
        $data = array('idClub' => $idClub, 'idSeason' => CURRENT_SEASON, 'totalPaidPlayers' => $totalPaidPlayers, 'totalPlayersToBePaid' => $totalPlayersToBePaid, 'totalPaidTeamEntries' => $totalPaidTeamEntries, 'totalTeamEntriesToBePaid' => $totalTeamEntriesToBePaid, 'totalPaidCards' => $totalPaidCards, 'totalCardsToBePaid' => $totalCardsToBePaid, 'totalPaidRefereedMatches' => $totalPaidRefereedMatches, 'totalRefereedMatchesToBePaid' => $totalRefereedMatchesToBePaid, 'totalPlayers' => $totalPlayers, 'totalTeamEntries' => $totalTeamEntries, 'totalCards' => $totalCards, 'totalRefereedMatches' => $totalRefereedMatches, 'totalPaid' => $totalPaid, 'totalPending' => $totalPending, 'totalPayments' => $totalPayments, 'available' => $available,'totalOthersToBePaid'=>$totalOthersToBePaid, 'totalPaidOthers'=>$totalPaidOthers,'totalOthers'=>$totalOthers);
        // $this->db->insert('teams_leagues_per_season', $data);
        $this->db->where('idClub', $idClub);
        $this->db->where('idSeason', CURRENT_SEASON);
        $query->num_rows() == 0 ? $this->db->insert('admEconomicControlPerClubByTypeAndIdClub', $data) : $this->db->update('admEconomicControlPerClubByTypeAndIdClub', $data);
    }

    function insert_settlement($idClub, $item) {
        //echo $idClub . " " . $item . "<br />";
        $data = array('isPaid' => 1);
        $this->db->where('id', $item);
        $this->db->update('admEconomicControlPerClub', $data);

        $this->db->set('timestamp', 'NOW()', FALSE);
        $data = array('idClub' => $idClub, 'idSeason' => CURRENT_SEASON, 'idItem' => $item);
        $this->db->insert('admSettlements', $data);
        //echo $this->db->last_query."<br />";
    }

}
