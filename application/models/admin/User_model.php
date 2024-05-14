<?php

Class User_model extends CI_Model {

    function get_user_permissions($idUser) {
        $this->db->select('idSection, section, cssClass, script,topSection');
        $this->db->from('cPanelSections_users');
        $this->db->join('cPanelSections', 'cPanelSections.id=cPanelSections_users.idSection');
        $this->db->where('idUser', $idUser);
        $this->db->where('rejectionDate is NULL');
        $this->db->order_by('topSection');
        $this->db->order_by('section');
        $query = $this->db->get();
       // echo $this->db->last_query();
        return $query->result();
    }
}

?>