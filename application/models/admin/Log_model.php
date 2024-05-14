<?php

Class Log_model extends CI_Model {

    function insert_log($idUser, $idItem,$activity) {

        $data = array('idUser' => $idUser, 'idItem' => $idItem, 'activity' => $activity);
        $this->db->set('datetime', 'NOW()', FALSE);
        $this->db->insert('cPanelActivityLog', $data);
       
    }
}
?>