<?php

Class Clubs_model extends CI_Model {

    function get_all_clubs() {
        $this->db->select('c.id, c.name');
        $this->db->from('clubs c');
        $this->db->where('id in (select idclub from teams_leagues_per_season tls join teams t on t.id=tls.idTeam where idSeason=' . CURRENT_SEASON . ')');
        $query = $this->db->get();
        return $query->result();
    }

    function get_club_info($idClub) {
        $this->db->select('id, name, description, image,address,city, phone1, phone2, web,email, province, facebook,twitter, web, president, vicepresident1, vicepresident2,balance,nif as clubNif,cceCode');
        $this->db->from('clubs');
        $this->db->where('id', $idClub);
        $query = $this->db->get();
        return $query->row_array();
    }

    function update_clubs_info() {
        $data = array('name' => $_POST['clubName'], 'address' => $_POST['clubAddress'], 'city' => $_POST['clubCity'], 'phone1' => $_POST['clubPhone1'], 'phone2' => $_POST['clubPhone2'], 'email' => $_POST['clubEmail'], 'description' => $_POST['clubText'], 'facebook' => $_POST['clubFacebook'], 'twitter' => $_POST['clubTwitter'], 'web' => $_POST['clubWeb'], 'image' => str_replace("\"", "", $_POST['clubImage']), 'president' => $_POST['clubPresident'], 'vicepresident1' => $_POST['clubVicepresident1'], 'vicepresident2' => $_POST['clubVicepresident2'], 'nif' => $_POST['clubNif'], 'cceCode' => $_POST['cceCode']);
        $this->db->where('id', $_POST['clubCode']);
        $this->db->update('clubs', $data);
    }

    function update_club_image($idClub, $name) {
        $data = array('image' => $name);
        $this->db->where('id', $idClub);
        $this->db->update('clubs', $data);
        return $this->db->last_query();
    }

    function insert_club() {
        $data = array('name' => $_POST['clubName']);
        $this->db->insert('clubs', $data);
        $insert_id = $this->db->insert_id();
        //echo $this->db->last_query();
        return $insert_id;
    }

    function insert_team() {
        $data = array('name' => $_POST['teamName'], 'idClub' => $_POST['idClub']);
        $this->db->insert('teams', $data);
        $insert_id = $this->db->insert_id();
        //echo $this->db->last_query();
        return $insert_id;
    }

    function get_all_users_by_idClub($idClub) {
        $this->db->select('id,name, email');
        $this->db->from('usersAccounts');
        $this->db->where('idClub', $idClub);
        $query = $this->db->get();
        return $query->result();
    }

    function insert_user() {
        $pass = substr(md5(microtime()), 1, 8);
        $data = array('name' => $_POST['userName'], 'email' => $_POST['userEmail'], 'login' => $_POST['userEmail'], 'idClub' => $_POST['idClub'], 'password' => $pass);
        $this->db->insert('usersAccounts', $data);
        $insert_id = $this->db->insert_id();

        $this->db->set('permissionDate', 'NOW()', FALSE);
        $data = array('idSection' => 3, 'idUser' => $insert_id);
        $this->db->insert('cPanelSections_users', $data);

        $this->db->set('permissionDate', 'NOW()', FALSE);
        $data = array('idSection' => 25, 'idUser' => $insert_id);
        $this->db->insert('cPanelSections_users', $data);

        //echo $this->db->last_query();
        return $insert_id;
    }

    function delete_user($idUser) {
        $this->db->query('update usersAccounts set idClub=null, password=null where id=' . $idUser);
        $this->db->query('delete from cpanelSections_users where idUser=' . $idUser);
    }

    function get_user_info($idUser) {
        $this->db->select('id, name, login,email, password');
        $this->db->from('usersAccounts');
        $this->db->where('id', $idUser);
        $query = $this->db->get();
        return $query->row_array();
    }

}

?>