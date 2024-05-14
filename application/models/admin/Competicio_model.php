<?php

Class Competicio_model extends CI_Model {

    function get_leagues_by_idSeason($idSeason) {
        $this->db->select('id, name,status');
        $this->db->from('leagues');
        $this->db->where('idSeason', $idSeason);
        $query = $this->db->get();
        return $query->result();
    }

    function get_league_info($idLeague) {
        $this->db->select('id, name,idDivision,status');
        $this->db->from('leagues');
        $this->db->where('id', $idLeague);

        $query = $this->db->get();
        return $query->row_array();
    }

    function get_divisions() {
        $this->db->select('id, name');
        $this->db->from('divisions');
        $this->db->order_by('order', 'desc');
        $query = $this->db->get();
        return $query->result();
    }

    function insert_competition() {
        $data = array('name' => $_POST['competitionName'], 'idDivision' => $_POST['division'], 'idSeason' => CURRENT_SEASON);
        $this->db->insert('leagues', $data);
        $insert_id = $this->db->insert_id();
//echo $this->db->last_query();
        return $insert_id;
    }

    function get_teams_by_idLeague($idLeague) {
        $this->db->select('teams.id, teams.name, position');
        $this->db->from('teams_leagues_per_season');
        $this->db->join('teams', 'teams_leagues_per_season.idteam=teams.id');
        $this->db->where('idLeague', $idLeague);
        $this->db->order_by('position', 'asc');
        $query = $this->db->get();

        return $query->result();
    }

    function get_all_teams() {
        $this->db->select('id, name');
        $this->db->from('teams');
        $query = $this->db->get();
        return $query->result();
    }

    function get_all_matchstatus() {
        $this->db->select('id, status');
        $this->db->from('matchstatus');
        $query = $this->db->get();
        return $query->result();
    }

    function insert_team_in_league() {
//BUSCO SI JA ESTÀ POSAT A AQUESTA LLIGA
        $query = $this->db->query("SELECT idTeam FROM teams_leagues_per_season
                           WHERE idTeam = " . $_POST['teamsSelect'] . " and idLeague=" . $_POST['idLeague'] . " and idSeason=" . CURRENT_SEASON . " limit 1");

        $data = array('idTeam' => $_POST['teamsSelect'], 'idLeague' => $_POST['idLeague'], 'idSeason' => CURRENT_SEASON);

//SI NO HO ESTÀ L' INSERTO
        $query->num_rows() == 0 ? $this->db->insert('teams_leagues_per_season', $data) : false;


//BUSCO A QUINA DIVISIÓ ESTÀ AQUESTA LLIGA
//
        $this->db->select('idDivision');
        $this->db->from('leagues');

        $this->db->where('id', $_POST['idLeague']);

        $query = $this->db->get();
        $d = $query->row_array();
        $idDivision = $d['idDivision'];

//BUSCO SI ESTÀ EN ALGUNA DIVISIÓ
        $query = $this->db->query("SELECT idTeam FROM teams_divisions_per_season
                           WHERE idTeam = " . $_POST['teamsSelect'] . " and idSeason=" . CURRENT_SEASON . " limit 1");

        $data = array('idTeam' => $_POST['teamsSelect'], 'idDivision' => $idDivision, 'idSeason' => CURRENT_SEASON);
// $this->db->insert('teams_leagues_per_season', $data);
        $query->num_rows() == 0 ? $this->db->insert('teams_divisions_per_season', $data) : false;


        return $_POST['idLeague'];
    }

    function insert_null_team_in_league($idLeague) {
        $query = $this->db->query("SELECT idTeam FROM teams_leagues_per_season
                           WHERE idTeam = 0 and idLeague=" . $idLeague . " and idSeason=" . CURRENT_SEASON . " limit 1");
        //echo $this->db->last_query();
        $data = array('idTeam' => 0, 'idLeague' => $idLeague, 'idSeason' => CURRENT_SEASON);
// $this->db->insert('teams_leagues_per_season', $data);
        $query->num_rows() == 0 ? $this->db->insert('teams_leagues_per_season', $data) : false;
    }

    function delete_team_in_league($idLeague, $idTeam) {
        $this->db->delete('teams_leagues_per_season', array('idTeam' => $idTeam, 'idLeague' => $idLeague));
        return $idLeague;
    }

    function order_teams_in_league($idLeague, $idTeam, $i) {
        $this->db->set('position', $i);
        $this->db->where('idTeam', $idTeam);
        $this->db->where('idLeague', $idLeague);
        $this->db->update('teams_leagues_per_season');
    }

    function get_rounds_by_pattern($idPattern, $numberOfPhases) {
        if ($numberOfPhases == 1) {
            $query = $this->db->query("select distinct idRound from league_patterns where idPattern=" . $idPattern);
            $r = $query->result();
            $h = count($r) / 2;
            echo $h;
        }

        $this->db->select('id, idRound, idLocal, idVisitor');
        $this->db->from('league_patterns');
        $this->db->where('idPattern', $idPattern);
        if ($h) {
            $this->db->where('idRound<=', $h);
        }
        $query = $this->db->get();
        return $query->result();
    }

    function clear_calendar($idLeague) {
        $query = $this->db->query("DELETE matches
FROM matches
INNER JOIN rounds ON rounds.id = matches.idRound
WHERE rounds.idleague = $idLeague");
        $query = $this->db->query("delete from rounds where idLeague=$idLeague");
    }

    function get_last_position($idLeague) {
        $this->db->select('position');
        $this->db->from('teams_leagues_per_season');
        $this->db->where('idLeague', $idLeague);
        $this->db->order_by('position', 'desc');
        $this->db->limit('1', '0');
        $query = $this->db->get();
        return $query->row_array();
    }

    function get_teams_with_no_position($idLeague) {
        $this->db->select('idTeam');
        $this->db->from('teams_leagues_per_season');
        $this->db->where('idLeague', $idLeague);
        $this->db->where('position', 0);
//$this->db->order_by('idTeam', 'asc');      
        $query = $this->db->get();
        return $query->result();
    }

    function update_team_positions($idLeague, $idTeam, $position) {
        $this->db->set('position', $position);
        $this->db->where('idLeague', $idLeague);
        $this->db->where('idTeam', $idTeam);
        $this->db->update('teams_leagues_per_season');
// echo $this->db->last_query();
    }

    function insert_round($idRound, $idLeague) {
        $query = $this->db->query("SELECT id FROM rounds
                           WHERE idLeague=" . $idLeague . " and name='$idRound' limit 1");
        $data = array('name' => $idRound, 'idLeague' => $idLeague, 'idSeason' => CURRENT_SEASON);
        $query->num_rows() == 0 ? $this->db->insert('rounds', $data) : $d = $query->row_array();
        return $this->db->insert_id();
    }

    function get_rounds_by_league($idLeague) {
        $this->db->select("id,name");
        $this->db->from("rounds");
        $this->db->where("idLeague", $idLeague);

        $query = $this->db->get();
        return $query->result();
    }

    function insert_matches($idRound, $idLeague, $idLocal, $idVisitor) {
        $query = $this->db->query("SELECT id FROM rounds
                           WHERE idLeague=" . $idLeague . " and name='$idRound' limit 1");
        $r = $query->row_array();
        $idRound = $r['id'];
        $query = $this->db->query("SELECT idTeam FROM teams_leagues_per_season
                           WHERE idLeague=" . $idLeague . " and position=$idLocal limit 1");
        $l = $query->row_array();
        $idLocal = $l['idTeam'];
        $query = $this->db->query("SELECT idTeam FROM teams_leagues_per_season
                           WHERE idLeague=" . $idLeague . " and position=$idVisitor limit 1");
        $l = $query->row_array();
        $idVisitor = $l['idTeam'];
        $data = array('idLocal' => $idLocal, 'idVisitor' => $idVisitor, 'idRound' => $idRound, 'statusId' => 1);
        $this->db->insert('matches', $data);
    }

    function insert_matches_without_assignation($idRound, $idLeague) {

        $data = array('idRound' => $idRound, 'statusId' => 1);
        $this->db->insert('matches', $data);
    }

    function clear_incomplete($idLeague) {
        $query = $this->db->query("DELETE matches
FROM matches
INNER JOIN rounds ON rounds.id = matches.idRound
WHERE (matches.idLocal is null or matches.idVisitor is null) and rounds.idleague = $idLeague");
    }

    function get_calendar($idLeague) {
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
            l.id as idLeague,
            (select count(*) from cmptMatch_Referee where idMatch=m.id) as rfr,
            t1.idClub as localClub,
                t2.idClub as visitorClub, 
                localResult,
                visitorResult
        from matches m
join rounds r on r.id=m.idRound
left join teams t1 on t1.id=m.idLocal
left join teams t2 on t2.id=m.idvisitor
left join clubs c1 on c1.id=t1.idclub
left join clubs c2 on c2.id=t2.idclub
left join complex cl on cl.id=m.place
join leagues l on l.id=r.idleague
join divisions d on d.id=l.iddivision
left join results re on re.idMatch=m.id

where   r.idLeague=$idLeague");
        return $query->result();
    }

    function get_all_status() {
        $this->db->select('id, status');
        $this->db->from('cmptStatus');
        $query = $this->db->get();
        return $query->result();
    }

    function update_league() {
        $this->db->set('name', $_POST['competitionName']);
        $this->db->set('idDivision', $_POST['idDivision']);
        $this->db->set('status', $_POST['statusSelect']);
        $this->db->where('id', $_POST['idLeague']);
        $this->db->update('leagues');
// echo $this->db->last_query();
    }

    function get_last_round_of_league($idLeague) {
        $this->db->select('id');
        $this->db->from('rounds');
        $this->db->where('idLeague', $idLeague);
        $this->db->order_by('id', 'desc');
        $this->db->limit(1);
        $query = $this->db->get();
        return $query->row_array();
    }

    function update_round_dates($idRound, $date) {
        $this->db->set('initialDate', invertdateformat($date));
        $_POST['initialDate'] = $date;
        $_POST['endDate'] = date("d-m-Y", strtotime($date) + 86400);
//echo $_POST['initialDate']." ".$tomorrow;
        $this->db->set('endDate', invertdateformat($_POST['endDate']));
        $this->db->where('id', $idRound);
        $this->db->update('rounds'); //echo "<hr>";
//echo $this->db->last_query();
    }

    function get_matches_by_idRound($idRound) {
        $this->db->select('id, idLocal');
        $this->db->from('matches');
        $this->db->where('idRound', $idRound);
        $query = $this->db->get();
        return $query->result();
    }

    function get_match_time_and_place_by_idTeam($idTeam) {
        $this->db->select('playingDay, playingHour, playingComplex');
        $this->db->from('teams');
        $this->db->where('id', $idTeam);
        $query = $this->db->get();
        return $query->row_array();
    }

    function update_matches_set_time_and_place($idTeam, $idRound, $playingDay, $playingHour, $playingComplex) {

        if ($playingDay == 7) {
            $playingDay = invertdateformat($_POST['endDate']);
        } else {
            $playingDay = invertdateformat($_POST['initialDate']);
        }
        if ($playingComplex) {
            $this->db->query("update matches set updateddatetime='" . $playingDay . " " . $playingHour . "', place=$playingComplex where idlocal=$idTeam and idRound=$idRound");
        }
//echo $this->db->last_query()."<br />";
        return $_POST['idLeague'];
    }

    function get_match_info($idMatch) {
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
//echo $this->db->last_query();
        return $query->row_array();
    }

    function get_referees_by_match($idMatch) {
        $this->db->select('idReferee,idRefereeType,isDriver');
        $this->db->from('cmptMatch_Referee');
        $this->db->where('idMatch', $idMatch);
        $this->db->order_by('idRefereeType', 'asc');
        $query = $this->db->get();
        return $query->result();
    }

    function get_all_complex() {
        $this->db->distinct('complexName');
        $this->db->select('id,complexName, complexAddress');

        $this->db->from('complex');
        $this->db->where('revisar IS NULL');
        $this->db->order_by('complexName');


        $query = $this->db->get();
//echo $this->db->last_query();
        return $query->result();
    }

    function update_match_info($idMatch) {

        $localName = "";
        $visitorName = "";
        $localAccountId = "";
        $visitorAccountId = "";
        $playingDay = invertdateformat($_POST['matchDate']);
        $query = $this->db->query("update matches set updateddatetime='" . $playingDay . " " . $_POST['matchHour'] . "', place=" . $_POST['matchComplex'] . " where id=$idMatch");
        $query = $this->db->query("select t1.name as localName, t2.name as visitorName, ua1.id as localAccountId, ua2.id as visitorAccountId, ua1.email as localEmail, ua2.email as visitorEmail from matches m 
join teams t1 on t1.id=m.idLocal
join teams t2 on t2.id=m.idVisitor
join usersAccounts ua1 on ua1.idClub=t1.idClub
join usersAccounts ua2 on ua2.idClub=t2.idClub where m.id=" . $idMatch);
        $data = $query->row_array();

        $localName = $data['localName'];

        $visitorName = $data['visitorName'];
        $localAccountId = $data['localAccountId'];
        $visitorAccountId = $data['visitorAccountId'];
        $aff = $this->db->affected_rows();
        if ($aff > 0) {

            $data1 = array('subject' => 'FCFS - Canvi d\' horari de partit ' . $localName . '- ' . $visitorName, 'senderName' => 'Federació Catalana de Futbol Sala', 'receiverName' => $localName, 'message' => 'S\' ha canviat la data del partit ' . $localName . ' - ' . $visitorName . "<br />Es celebrarà el " . invertdateformat($playingDay) . " a les " . $_POST['matchHour'], 'idSender' => 267, 'idReceiver' => $localAccountId);
            $this->db->set('insertedDate', 'NOW()', FALSE);
            $this->db->insert('mailControl', $data1);

            $data2 = array('subject' => 'FCFS - Canvi d\' horari de partit ' . $localName . '- ' . $visitorName, 'senderName' => 'Federació Catalana de Futbol Sala', 'receiverName' => $visitorName, 'message' => 'S\' ha canviat la data del partit ' . $localName . ' - ' . $visitorName . "<br />Es celebrarà el " . invertdateformat($playingDay) . " a les " . $_POST['matchHour'], 'idSender' => 267, 'idReceiver' => $visitorAccountId);
            $this->db->set('insertedDate', 'NOW()', FALSE);
            $this->db->insert('mailControl', $data2);
        }
        if ($_POST['matchReferee1']) {
            $query = $this->db->query("select idReferee from cmptMatch_Referee where idRefereeType=1 and idReferee=" . $_POST['matchReferee1'] . " and idMatch=" . $idMatch);
            $n = $query->num_rows();
            if ($n < 1 or $aff > 0) {
                $this->db->query("delete from cmptMatch_Referee where idRefereeType=1  and idMatch=" . $idMatch);
                $this->db->query("insert into cmptMatch_Referee (idMatch, idReferee, idRefereeType) values ($idMatch, " . $_POST['matchReferee1'] . ",1)");

                $query = $this->db->query("select id,name from usersAccounts where idReferee=" . $_POST['matchReferee1']);
                $dataR = $query->row_array();
                $idAccount = $dataR['id'];
                $accountName = $dataR['name'];
                $data1 = array('subject' => 'FCFS - Designació per al partit ' . $localName . '- ' . $visitorName, 'senderName' => 'Federació Catalana de Futbol Sala', 'receiverName' => $accountName, 'message' => 'S\' ha designat pel partit  ' . $localName . ' - ' . $visitorName . "<br />Es celebrarà el " . invertdateformat($playingDay) . " a les " . $_POST['matchHour'], 'idSender' => 267, 'idReceiver' => $dataR['id']);
                $this->db->set('insertedDate', 'NOW()', FALSE);
                $this->db->insert('mailControl', $data1);
            }
        }
        if ($_POST['matchReferee2']) {
            $query = $this->db->query("select idReferee from cmptMatch_Referee where idRefereeType=2 and idReferee=" . $_POST['matchReferee2'] . " and idMatch=" . $idMatch);
            $n = $query->num_rows();
            if ($n < 1) {
                $this->db->query("delete from cmptMatch_Referee where idRefereeType=2  and idMatch=" . $idMatch);
                $this->db->query("insert into cmptMatch_Referee (idMatch, idReferee, idRefereeType) values ($idMatch, " . $_POST['matchReferee2'] . ",2)");
                $query = $this->db->query("select id,name from usersAccounts where idReferee=" . $_POST['matchReferee2']);
                $dataR = $query->row_array();
                $idAccount = $dataR['id'];
                $accountName = $dataR['name'];
                $data1 = array('subject' => 'FCFS - Designació per al partit ' . $localName . '- ' . $visitorName, 'senderName' => 'Federació Catalana de Futbol Sala', 'receiverName' => $accountName, 'message' => 'S\' ha designat pel partit  ' . $localName . ' - ' . $visitorName . "<br />Es celebrarà el " . invertdateformat($playingDay) . " a les " . $_POST['matchHour'], 'idSender' => 267, 'idReceiver' => $dataR['id']);
                $this->db->set('insertedDate', 'NOW()', FALSE);
                $this->db->insert('mailControl', $data1);
            }
        }
        if ($_POST['matchReferee3']) {
            $query = $this->db->query("select idReferee from cmptMatch_Referee where idRefereeType=3 and idReferee=" . $_POST['matchReferee3'] . " and idMatch=" . $idMatch);
            $n = $query->num_rows();
            if ($n < 1) {
                $this->db->query("delete from cmptMatch_Referee where idRefereeType=3  and idMatch=" . $idMatch);
                $this->db->query("insert into cmptMatch_Referee (idMatch, idReferee, idRefereeType) values ($idMatch, " . $_POST['matchReferee3'] . ",3)");
                $query = $this->db->query("select id,name from usersAccounts where idReferee=" . $_POST['matchReferee3']);
                $dataR = $query->row_array();
                $idAccount = $dataR['id'];
                $accountName = $dataR['name'];
                $data1 = array('subject' => 'FCFS - Designació per al partit ' . $localName . '- ' . $visitorName, 'senderName' => 'Federació Catalana de Futbol Sala', 'receiverName' => $accountName, 'message' => 'S\' ha designat pel partit  ' . $localName . ' - ' . $visitorName . "<br />Es celebrarà el " . invertdateformat($playingDay) . " a les " . $_POST['matchHour'], 'idSender' => 267, 'idReceiver' => $dataR['id']);
                $this->db->set('insertedDate', 'NOW()', FALSE);
                $this->db->insert('mailControl', $data1);
            }
        }
    }

    function update_match_team() {

        $query = $this->db->query("update matches set " . $_POST['p'] . "=" . $_POST['idTeam'] . " where id=" . $_POST['idMatch']);
        //  echo $this->db->last_query();
    }

    function update_match_comment($idMatch) {
        if ($_POST['comment']) {
            $query = $this->db->query("update matches set comment='" . $_POST['comment'] . "' where id=$idMatch");
        }
    }

    function update_match_result($idMatch) {
        $query = $this->db->query("delete  FROM player_goals_match
                           WHERE idMatch = $idMatch  ");

        $query = $this->db->query("SELECT * FROM results
                           WHERE idMatch = $idMatch  limit 1");

        if ($query->num_rows() == 0) {
            $data = array('idMatch' => $idMatch, 'localResult' => $_POST['localResult'], 'visitorResult' => $_POST['visitorResult']);
            $this->db->insert('results', $data);
        } else {
            $this->db->set('localResult', $_POST['localResult']);
            $this->db->set('visitorResult', $_POST['visitorResult']);
            $this->db->where('idMatch', $idMatch);
            $this->db->update('results');
        }
//ACTUALITZO ELS GOLS
        for ($a = 1; $a <= $_POST['localResult']; $a++) {
            $data = array('idMatch' => $idMatch, 'idTeam' => $_POST['idLocal']);
            $this->db->insert('player_goals_match', $data);
        }
        for ($a = 1; $a <= $_POST['visitorResult']; $a++) {
            $data = array('idMatch' => $idMatch, 'idTeam' => $_POST['idVisitor']);
            $this->db->insert('player_goals_match', $data);
        }
    }

    function update_match_status($idMatch, $status) {
        $this->db->set('statusId', $status);
        $this->db->where('id', $idMatch);
        $this->db->update('matches');
// echo $this->db->last_query();
    }

    function get_goals_by_idMatch_and_idTeam($idMatch, $idTeam) {
        $this->db->select("p.id  ,name, player_goals_match.id as idGoal , idPlayer");
        $this->db->from("player_goals_match");
        $this->db->join("players p ", "player_goals_match.idPlayer=p.id", "left");
        $this->db->where('idMatch', $idMatch);
        $this->db->where('idTeam', $idTeam);
        $query = $this->db->get();
//echo $this->db->last_query();
        return $query->result();
    }

    function get_players_by_idTeam($idTeam, $idMatch) {
        $q = "SELECT `p`.`id`, 
       `p`.`name`, 
       `t`.`name` AS `teamName`, 
       `p`.`image`, 
       `dni` 
       ,(select number from matches_players where idMatch=$idMatch and idPlayer=p.id) as number
       ,(select idTeam from matches_players where idMatch=$idMatch and idPlayer=p.id) as idTeam
       ,(select isCaptain from matches_players where idMatch=$idMatch and idPlayer=p.id) as isCaptain
       ,(select yellowCards from player_card_match where idMatch=$idMatch and idPlayer=p.id) as yellowCards
       ,(select blueCards from player_card_match where idMatch=$idMatch and idPlayer=p.id) as blueCards
FROM   `player_team_season` 
       LEFT JOIN `players` `p` 
              ON `player_team_season`.`idplayer` = `p`.`id` 
       JOIN `teams` `t` 
         ON `t`.`id` = `player_team_season`.`idteam` 
WHERE  `idseason` = " . CURRENT_SEASON . "  and isPayed=1
       AND `idclub` IN (SELECT idclub 
                        FROM   teams 
                        WHERE  id = $idTeam) 
ORDER  BY `player_team_season`.`idteam` ASC ";
        $query = $this->db->query($q);

//echo $this->db->last_query();
        return $query->result();
    }

    function get_players_by_idTeam_and_idMatch($idTeam, $idMatch) {
        $q = "select p.id,mp.idplayer, p.name, p.image, number, isCaptain, yellowCards, blueCards, dni, nif from matches_players mp
join players p on p.id=mp.idPlayer
left join player_card_match pcm on pcm.idPlayer=p.id and pcm.idMatch=mp.idmatch
where mp.idMatch=" . $idMatch . " and idTeam=" . $idTeam;
        $query = $this->db->query($q);

        return $query->result();
    }

    function update_goals_byIdGoal() {
        $this->db->set('idPlayer', $_POST['idPlayer']);
        $this->db->where('id', $_POST['idGoal']);
        $this->db->update('player_goals_match');
echo $this->db->last_query();
    }

    function update_match_data_by_idMatch_and_idPlayer($item, $idPlayer, $idMatch, $idTeam, $value) {
        echo $item . " " . $idPlayer . " " . $idMatch . " " . $idTeam . " " . $value;
        $query = $this->db->query("SELECT idTeam FROM matches_players
                           WHERE idMatch = " . $idMatch . " and idPlayer=" . $idPlayer . " limit 1");

        $data = array('idMatch' => $idMatch, 'idPlayer' => $idPlayer, 'idTeam' => $idTeam);
        echo "\n" . $this->db->last_query();
        $query->num_rows() == 0 ? $this->db->insert('matches_players', $data) : false;
        echo "\n" . $this->db->last_query();
        if ($item != "idPlayer") {
            $this->db->set($item, $value);
            $this->db->set('idTeam', $idTeam);
            $this->db->where('idMatch', $idMatch);
            $this->db->where('idPlayer', $idPlayer);
            $this->db->update('matches_players');
            echo "\n" . $this->db->last_query();
        }
    }

    function update_match_cards_by_idMatch_and_idPlayer($item, $idPlayer, $idMatch, $idTeam, $value) {
        $query = $this->db->query("SELECT idPlayer FROM player_card_match
                           WHERE idMatch = " . $idMatch . " and idPlayer=" . $idPlayer . " limit 1");

        $data = array('idMatch' => $idMatch, 'idPlayer' => $idPlayer);

        $query->num_rows() == 0 ? $this->db->insert('player_card_match', $data) : false;

        $this->db->set($item, abs($value));
        $this->db->where('idMatch', $idMatch);
        $this->db->where('idPlayer', $idPlayer);
        $this->db->update('player_card_match');
// echo $this->db->last_query();
    }

    function delete_match_data_by_idMatch_and_idPlayer($idPlayer, $idMatch) {
        $query = $this->db->query("delete FROM player_card_match
                           WHERE idMatch = " . $idMatch . " and idPlayer=" . $idPlayer);
//echo $this->db->last_query();
        $query = $this->db->query("delete FROM matches_players
                           WHERE idMatch = " . $idMatch . " and idPlayer=" . $idPlayer);
//echo $this->db->last_query();
        $query = $this->db->query("update player_goals_match set idPlayer=-1
                           WHERE idMatch = " . $idMatch . " and idPlayer=" . $idPlayer . " limit 1");
//echo $this->db->last_query();
    }

    function get_results_by_idTeam_and_idLeague($idTeam, $idLeague, $idRound) {
        $where = "(idLocal=" . $idTeam . " or idVisitor=$idTeam) and idRound<=$idRound";
        $this->db->select('m.idLocal,m.idVisitor, re.localResult,re.visitorResult');
        $this->db->from('results re');
        $this->db->join('matches m', 'm.id=re.idMatch');
        $this->db->join('rounds r', 'r.id=m.idRound');
        $this->db->where('idLeague', $idLeague);
        $this->db->where($where);
        $query = $this->db->get();
// echo $this->db->last_query()."<br />";
        return $query->result();
    }

    function insert_classification($idTeam, $idLeague, $playedMatches, $wins, $draws, $loses, $goalsF, $goalsC, $idRound, $points) {
        $query = $this->db->query("delete from classification_v2 where idRound=" . $idRound . " and idTeam=" . $idTeam);
        $query = $this->db->query("insert into classification_v2 (idTeam, idLeague, playedMatches, wonMatches, drawMatches,lostMatches,goalsMade,goalsReceived,idRound,points) values ($idTeam,$idLeague,$playedMatches,$wins,$draws,$loses,$goalsF,$goalsC,$idRound,$points)");
// echo $this->db->last_query()."<br />";
    }

    function get_classification_by_idLeague_and_idRound($idLeague, $idRound) {
        $this->db->select('idTeam');
        $this->db->from('classification_v2');
        $this->db->where('idRound', $idRound);
        $this->db->where('idLeague', $idLeague);
        $this->db->order_by('points', 'desc');
        $this->db->order_by('wonMatches', 'desc');
        $query = $this->db->get();
        return $query->result();
    }

    function update_positions($idTeam, $n, $idRound, $idLeague) {
        $query = $this->db->query("update classification_v2 set position=$n where idTeam=$idTeam and idRound=$idRound and idLeague=$idLeague");
//echo $this->db->last_query() . "<br />";
    }

    function get_last_round_with_results($idLeague) {
        $this->db->select("idRound");
        $this->db->from("results res");
        $this->db->from("matches m", "m.id=res.idmatch");
        $this->db->join("rounds r", "r.id=m.idround");
        $this->db->where("idLeague", $idLeague);
        $this->db->order_by("idRound", "desc");
        $this->db->limit("1", "1");
        $query = $this->db->get();
//echo $this->db->last_query()."<br />";
        return $query->row_array();
    }

    function get_referees() {
        $this->db->select('id,name,delegationName');
        $this->db->from('rfrReferees');


        $this->db->join('delegations', 'delegations.idDelegation=rfrReferees.idDelegation');
        $this->db->where('isDeleted', '0');
        $this->db->order_by('delegationName');
        $this->db->order_by('name');
        $query = $this->db->get(); //echo $this->db->last_query()."<br />";
        return $query->result();
    }

    function get_matches_by_idClub($idClub) {
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
            l.id as idLeague,
            datediff(m.updateddatetime,now()) as days,
            (select count(*) from cmptMatchDateChange where idMatch=m.id and approved=0) as matchChange
        from matches m
join rounds r on r.id=m.idRound
join teams t1 on t1.id=m.idLocal
join teams t2 on t2.id=m.idvisitor
join clubs c1 on c1.id=t1.idclub
join clubs c2 on c2.id=t2.idclub
left join complex cl on cl.id=m.place
join leagues l on l.id=r.idleague
join divisions d on d.id=l.iddivision
where l.idSeason=" . CURRENT_SEASON . " and (t1.idClub=$idClub or t2.idClub=$idClub ) and status<>4 and updateddatetime!='0000-00-00 00:00:00' order by updateddatetime asc");
        return $query->result();
    }

    function insert_date_change($idMatch, $idTeam) {
        $data = array(
            'idTeam' => $idTeam,
            'idMatch' => $idMatch,
            'datetime' => invertdateformat($_POST['matchDate'])
        );
        $this->db->set('insertDateTime', 'NOW()', FALSE);
        $this->db->insert("cmptMatchDateChange", $data);
    }

    function get_last_date_change_by_idMatch($idMatch) {
        $this->db->select('mdc.id,idMatch,mdc.datetime, updateddatetime');
        $this->db->from('cmptMatchDateChange mdc');
        $this->db->join('matches m', 'm.id=mdc.idMatch');
        $this->db->where('idMatch', $idMatch);
        $this->db->order_by('mdc.datetime', 'desc');
        $this->db->limit("1", "0");
        $query = $this->db->get();
//echo $this->db->last_query()."<br />";
        return $query->row_array();
    }

    function get_all_finished_matches() {

        $this->db->select('m.id as idMatch,t1.name as local, t2.name as visitor, updateddatetime, comment, r.name as roundName');
        $this->db->from('matches m');
        $this->db->join('teams t1', 'm.idLocal=t1.id');
        $this->db->join('teams t2', 'm.idVisitor=t2.id');
        $this->db->join('rounds r', 'r.id=m.idRound');
        $this->db->join('leagues l', 'l.id=r.idLeague');
        $this->db->where('l.idSeason', CURRENT_SEASON);
        $this->db->where('statusId', 4);
        $this->db->order_by('updateddatetime', 'desc');

        $query = $this->db->get();
        return $query->result();
    }

    function get_next_week_matches() {

        $this->db->select('m.id as idMatch,t1.name as local, t2.name as visitor, updateddatetime, comment, r.name as roundName,l.name as league,c1.image as localImage, c2.image as visitorImage, complexName, localResult,visitorResult, refereeString');
        $this->db->from('matches m');
        $this->db->join('teams t1', 'm.idLocal=t1.id');
        $this->db->join('teams t2', 'm.idVisitor=t2.id');
        $this->db->join('clubs c1', 'c1.id=t1.idClub');
        $this->db->join('clubs c2', 'c2.id=t2.idClub');
        $this->db->join('rounds r', 'r.id=m.idRound');
        $this->db->join('leagues l', 'l.id=r.idLeague');
        $this->db->join('complex cl', 'cl.id=m.place');
        $this->db->join('results re', 're.idMatch=m.id', 'left');
        $this->db->where('l.idSeason', CURRENT_SEASON);

        if (!empty($_POST['initialDate'])) {
            $this->db->where('updateddatetime>"' . $_POST['initialDate'] . '"');
        } else {
            $this->db->where('updateddatetime>now()');
            $this->db->where('datediff(updateddatetime,now())<14');
            //$this->db->limit(3);
        }

        if (!empty($_POST['endDate'])) {
            $this->db->where('updateddatetime<"' . $_POST['endDate'] . '"');
        }

        if (!empty($_POST['team'])) {
            $this->db->where('(idLocal=' . $_POST['team'] . ' or idVisitor=' . $_POST['team'] . ')');
        }
        if (!empty($_POST['complex'])) {
            $this->db->where('place', $_POST['complex']);
        }
        if (!empty($_POST['league'])) {
            $this->db->where('l.id', $_POST['league']);
        }
        if (!empty($_POST['division'])) {
            $this->db->where('l.idDivision', $_POST['division']);
        }
        if (!empty($_POST['club'])) {
            $this->db->where('(t1.idClub=' . $_POST['club'] . ' or t2.idClub=' . $_POST['club'] . ')');
        }
        if (!empty($_POST['status'])) {
            $this->db->where('statusId', $_POST['status']);
        } else {
            $this->db->where('statusId', 1);
        }
        $this->db->order_by('updateddatetime', 'asc');
        // 
        $query = $this->db->get();
        //echo $this->db->last_query() . "<br />";
        return $query->result();
    }

    function match_queries() {
        $this->db->select('m.id as idMatch,t1.name as local, t2.name as visitor, updateddatetime, comment, r.name as roundName,l.name as league,c1.image as localImage, c2.image as visitorImage, complexName, localResult,visitorResult, refereeString');
        $this->db->from('matches m');
        $this->db->join('teams t1', 'm.idLocal=t1.id');
        $this->db->join('teams t2', 'm.idVisitor=t2.id');
        $this->db->join('clubs c1', 'c1.id=t1.idClub');
        $this->db->join('clubs c2', 'c2.id=t2.idClub');
        $this->db->join('rounds r', 'r.id=m.idRound');
        $this->db->join('leagues l', 'l.id=r.idLeague');
        $this->db->join('complex cl', 'cl.id=m.place');
        $this->db->join('results re', 're.idMatch=m.id', 'left');
        $this->db->where('l.idSeason', CURRENT_SEASON);

        if (!empty($_POST['initialDate'])) {
            $this->db->where('updateddatetime>"' . $_POST['initialDate'] . '"');
        }

        if (!empty($_POST['endDate'])) {
            $this->db->where('updateddatetime<"' . $_POST['endDate'] . '"');
        }

        if (!empty($_POST['team'])) {
            $this->db->where('(idLocal=' . $_POST['team'] . ' or idVisitor=' . $_POST['team'] . ')');
        }
        if (!empty($_POST['complex'])) {
            $this->db->where('place', $_POST['complex']);
        }
        if (!empty($_POST['league'])) {
            $this->db->where('l.id', $_POST['league']);
        }
        if (!empty($_POST['division'])) {
            $this->db->where('l.idDivision', $_POST['division']);
        }
        if (!empty($_POST['club'])) {
            $this->db->where('(t1.idClub=' . $_POST['club'] . ' or t2.idClub=' . $_POST['club'] . ')');
        }
        if (!empty($_POST['status'])) {
            $this->db->where('statusId', $_POST['status']);
        }
        $this->db->order_by('updateddatetime', 'asc');
        // 
        $query = $this->db->get();
        //echo $this->db->last_query() . "<br />";
        return $query->result();
    }

    function insert_referee_in_match($idMatch) {

        $dataM = $this->get_match_info($idMatch);

        $localName = $dataM['localName'];
        $visitorName = $dataM['visitorName'];
        $playingDay = $dataM['updateddatetime'];
        $m = explode(" ", $playingDay);

        if (!$_POST['matchHour']) {
            $_POST['matchHour'] = $m[1];
        }
        if ($_POST['isDriver1']) {
            $_POST['isDriver1'] = 1;
        } else {
            $_POST['isDriver1'] = 0;
        }
        if ($_POST['isDriver2']) {
            $_POST['isDriver2'] = 1;
        } else {
            $_POST['isDriver2'] = 0;
        }
        if ($_POST['isDriver3']) {
            $_POST['isDriver3'] = 1;
        } else {
            $_POST['isDriver3'] = 0;
        }
        $url = "admin/arbitre/partit/" . $idMatch;
        $url = str_replace("/", "-", $url);
        if ($_POST['matchReferee1']) {
            $this->db->query("delete from cmptMatch_Referee where idRefereeType=1  and idMatch=" . $idMatch);
            $this->db->query("insert into cmptMatch_Referee (idMatch, idReferee, idRefereeType,isDriver) values ($idMatch, " . $_POST['matchReferee1'] . ",1," . $_POST['isDriver1'] . ")");
            //  
            $query = $this->db->query("select a.id, r.name, email from rfrReferees r
left join usersAccounts a on a.idReferee=r.id
where r.id=" . $_POST['matchReferee1']);

            $dataR = $query->row_array();

            $idAccount = $dataR['id'];
            $accountName = $dataR['name'];
            $accountEmail = $dataR['email'];
            $buttonName = 'Acceptar';

            if ($_POST['enviar'] == 'Enviar') {
                $link = create_link($idAccount, $accountName, $accountEmail, $buttonName, $url);
                if ($idAccount) {
                    $data1 = array('subject' => 'FCFS - Designació per al partit ' . $localName . '- ' . $visitorName, 'senderName' => 'Federació Catalana de Futbol Sala', 'receiverName' => $accountName, 'message' => $accountName . '( ' . $accountEmail . ' ),  has estat designat pel partit  ' . $localName . ' - ' . $visitorName . "<br />Es celebrarà el " . invertdateformat($playingDay) . " a les " . $_POST['matchHour'] . ' a ' . $dataM['complexName'] . ' (' . $dataM['complexAddress'] . ')<br />' . $link, 'idSender' => 267, 'idReceiver' => $idAccount);
                    // print_r($data1);
                    $this->db->set('insertedDate', 'NOW()', FALSE);
                    $this->db->insert('mailControl', $data1);
                } else {
                    $data1 = array('subject' => 'FCFS - Usuari ' . $accountName . ' sense email', 'senderName' => 'Federació Catalana de Futbol Sala', 'receiverName' => 'Admin', 'message' => 'Usuari ' . $accountName . ' sense email', 'idSender' => 267, 'idReceiver' => 267);
                    $this->db->set('insertedDate', 'NOW()', FALSE);
                    $this->db->insert('mailControl', $data1);
                }
                //  echo $this->db->last_query();
            }
        }
        if ($_POST['matchReferee2']) {

            $query = $this->db->query("select idReferee from cmptMatch_Referee where idRefereeType=2 and idReferee=" . $_POST['matchReferee2'] . " and idMatch=" . $idMatch);
            $n = $query->num_rows();

            $this->db->query("delete from cmptMatch_Referee where idRefereeType=2  and idMatch=" . $idMatch);
            $this->db->query("insert into cmptMatch_Referee (idMatch, idReferee, idRefereeType,isDriver) values ($idMatch, " . $_POST['matchReferee2'] . ",2," . $_POST['isDriver2'] . ")");
            $query = $this->db->query("select a.id, r.name, email from rfrReferees r
left join usersAccounts a on a.idReferee=r.id
where r.id=" . $_POST['matchReferee2']);
            $dataR = $query->row_array();

            $idAccount = $dataR['id'];
            $accountName = $dataR['name'];
            $accountEmail = $dataR['email'];
            $buttonName = 'Acceptar';
            if ($_POST['enviar'] == 'Enviar') {
                $link = create_link($idAccount, $accountName, $accountEmail, $buttonName, $url);
                if ($idAccount) {
                    $data1 = array('subject' => 'FCFS - Designació per al partit ' . $localName . '- ' . $visitorName, 'senderName' => 'Federació Catalana de Futbol Sala', 'receiverName' => $accountName, 'message' => $accountName . '( ' . $accountEmail . ' ),  has estat designat pel partit  ' . $localName . ' - ' . $visitorName . "<br />Es celebrarà el " . invertdateformat($playingDay) . " a les " . $_POST['matchHour'] . ' a ' . $dataM['complexName'] . ' (' . $dataM['complexAddress'] . ')<br />' . $link, 'idSender' => 267, 'idReceiver' => $idAccount);
                    //   print_r($data1);
                    $this->db->set('insertedDate', 'NOW()', FALSE);
                    $this->db->insert('mailControl', $data1);
                } else {
                    $data1 = array('subject' => 'FCFS - Usuari ' . $accountName . ' sense email', 'senderName' => 'Federació Catalana de Futbol Sala', 'receiverName' => 'Admin', 'message' => 'Usuari ' . $accountName . ' sense email', 'idSender' => 267, 'idReceiver' => 267);
                    $this->db->set('insertedDate', 'NOW()', FALSE);
                    $this->db->insert('mailControl', $data1);
                }
            }
        }
        if ($_POST['matchReferee3']) {
            $query = $this->db->query("select idReferee from cmptMatch_Referee where idRefereeType=3 and idReferee=" . $_POST['matchReferee3'] . " and idMatch=" . $idMatch);
            $n = $query->num_rows();
            $this->db->query("delete from cmptMatch_Referee where idRefereeType=3  and idMatch=" . $idMatch);
            $this->db->query("insert into cmptMatch_Referee (idMatch, idReferee, idRefereeType,isDriver) values ($idMatch, " . $_POST['matchReferee3'] . ",3," . $_POST['isDriver3'] . ")");
            $query = $this->db->query("select a.id, r.name, email from rfrReferees r
left join usersAccounts a on a.idReferee=r.id
where r.id=" . $_POST['matchReferee3']);
            $dataR = $query->row_array();

            $idAccount = $dataR['id'];
            $accountName = $dataR['name'];
            $accountEmail = $dataR['email'];
            $buttonName = 'Acceptar';

            if ($_POST['enviar'] == 'Enviar') {
                $link = create_link($idAccount, $accountName, $accountEmail, $buttonName, $url);
                if ($idAccount) {
                    $data1 = array('subject' => 'FCFS - Designació per al partit ' . $localName . '- ' . $visitorName, 'senderName' => 'Federació Catalana de Futbol Sala', 'receiverName' => $accountName, 'message' => $accountName . '( ' . $accountEmail . ' ),  has estat designat pel partit  ' . $localName . ' - ' . $visitorName . "<br />Es celebrarà el " . invertdateformat($playingDay) . " a les " . $_POST['matchHour'] . ' a ' . $dataM['complexName'] . ' (' . $dataM['complexAddress'] . ')<br />' . $link, 'idSender' => 267, 'idReceiver' => $idAccount);
                    $this->db->set('insertedDate', 'NOW()', FALSE);
                    $this->db->insert('mailControl', $data1);
                } else {
                    $data1 = array('subject' => 'FCFS - Usuari ' . $accountName . ' sense email', 'senderName' => 'Federació Catalana de Futbol Sala', 'receiverName' => 'Admin', 'message' => 'Usuari ' . $accountName . ' sense email', 'idSender' => 267, 'idReceiver' => 267);
                    $this->db->set('insertedDate', 'NOW()', FALSE);
                    $this->db->insert('mailControl', $data1);
                }
            }
        }
        $query = $this->db->query(" select name from cmptMatch_Referee cmr
join rfrReferees r on r.id=cmr.idReferee
where idMatch=" . $idMatch);

        $r = $query->result();
        foreach ($r as $rfr) {
            $rfrString .= $rfr->name . ", ";
        }

        $rfrString = trim($rfrString, ",");
        $this->db->query(" update matches set refereeString='" . addslashes($rfrString) . "'
where id=" . $idMatch);
    }

}
