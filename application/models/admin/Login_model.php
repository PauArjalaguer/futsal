<?php

Class Login_model extends CI_Model {

    function login($username, $password) {
        $this->db->select('id, name, password, idReferee, idClub');
        $this->db->from('usersAccounts');
        $this->db->where('login', $username);
        $this->db->where('password', $password);
        $this->db->limit(1);

        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            return $query->result();
        } else {
            return false;
        }
    }

    function login_with_token($idAccount, $token) {
        $this->db->select('id, name, password,email, idReferee, idClub');
        $this->db->from('usersAccounts');
        $this->db->where('id', $idAccount);
        $this->db->limit(1);
        $query = $this->db->get();
        $r = $query->row_array();

        $newToken = md5($idAccount . $r['email'] . SECRET_WORD);

        if ($token == $newToken) {
            return $query->row_array();
        }else{
            redirect("admin/login");
        }
    }

}

?>