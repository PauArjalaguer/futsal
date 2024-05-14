<?php

Class Equips_model extends CI_Model {

    function get_all_teams($idClub) {
        $this->db->select('id, name, playingDay, playingHour');
        $this->db->from('teams');
        $this->db->where('idClub', $idClub);

        $query = $this->db->get();
        return $query->result();
    }

    function get_team_info($idTeam, $idClub) {
        $this->db->select('id as idTeam,name as teamName,playingDay, playingHour,playingComplex');
        $this->db->from('teams');
        $this->db->where('idClub', $idClub);
        $this->db->where('id', $idTeam);
        $query = $this->db->get();
        return $query->row_array();
    }

    function get_players_by_idTeam_and_idClub($idTeam, $idClub, $idSeason) {
        $query = $this->db->query("select 
distinct p.id, p.name as playerName,t.name as teamName, rds.rate, adse.rate, isDeleted, statusPercent, isPayed
from players p
join player_team_season pts on pts.idplayer=p.id
join teams t on t.id=pts.idteam
 left join teams_divisions_per_season tds on tds.idteam=t.id and tds.idseason=pts.idseason
 left join rate_division_season rds on rds.iddivision=tds.iddivision and rds.idseason=pts.idseason
 left join admrate_division_season_exceptions adse on adse.idplayer=pts.idplayer and adse.idseason=pts.idseason
where t.idclub=$idClub and t.id=$idTeam and pts.idseason=$idSeason  and isDeleted<>1
order by pts.idteam, p.name");
        return $query->result();
    }

    function get_players_from_previousSeason_by_idTeam_and_idClub($idTeam, $idClub, $playerString) {
        $query = $this->db->query("select id,name from players where id in (select 
distinct p.id
from players p
join player_team_season pts on pts.idplayer=p.id
join teams t on t.id=pts.idteam
 left join teams_divisions_per_season tds on tds.idteam=t.id and tds.idseason=pts.idseason

where t.idclub=$idClub  and isDeleted<>1 and p.id not in ($playerString))
order by  name");
        return $query->result();
    }

    function get_cards_by_idTeam($idTeam, $idClub, $idSeason) {
        $query = $this->db->query("select p.id,sum(pcm.yellowcards) as yellow, sum(pcm.blueCards) as blue, p.name, t.name as team, (select cards from player_card_cicles where idplayer=pcm.idplayer order by id desc limit 0,1)  as lastCicle from player_card_match pcm
join matches m on m.id=pcm.idmatch
join rounds r on r.id=m.idround
join players p on p.id=pcm.idplayer
join player_team_season pts on pts.idplayer=pcm.idplayer
join teams t on t.id=pts.idteam
where r.idseason=$idSeason
and pts.idseason=$idSeason
and pts.idTeam=$idTeam
and t.idClub=$idClub
group by pcm.idplayer
order by t.id asc, blue desc, yellow desc");
        return $query->result();
    }

    function get_scorers_by_idTeam($idTeam, $idClub, $idSeason) {
        $query = $this->db->query("select  sum(pgm.number) as goals,p.name, p.id from player_goals_match pgm
join players p on p.id=pgm.idplayer
join matches_players mp on mp.idplayer=pgm.idplayer and mp.idmatch=pgm.idmatch
join teams t on t.id=mp.idteam
join matches m on m.id=pgm.idmatch
join rounds r on r.id=m.idround
where idseason=$idSeason and mp.idteam=$idTeam and idClub=$idClub
 group by p.id
order by goals desc");
        return $query->result();
    }

    function update_team_info($idTeam) {
        $data = array('playingDay' => $_POST['playingDay'], 'playingHour' => $_POST['playingHour'], 'playingComplex' => $_POST['playingComplex']);
        $this->db->where('id', $idTeam);
        $this->db->update('teams', $data);
        //echo $this->db->last_query();
    }

}

?>