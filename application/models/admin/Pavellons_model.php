<?php

Class pavellons_model extends CI_Model {

    function get_all_complex() {
        $this->db->select("id, complexName, complexAddress,revisar");
        $this->db->from("complex");
        // $this->db->where("revisar",null);
        $this->db->order_by("complexname");
        $query = $this->db->get();
        return $query->result();
    }

    function get_complex_info($idComplex) {
        $this->db->select("id, complexName, complexAddress,revisar,complexPhone");
        $this->db->from("complex");
        $this->db->where("id", $idComplex);
        $query = $this->db->get();
        return $query->row_array();
    }

    function update_complex_info() {
        $data = array('complexName' => $_POST['complexName'], 'complexAddress' => $_POST['complexAddress'], 'complexPhone' => $_POST['complexPhone'], 'revisar' => null);
        $this->db->where('id', $_POST['complexId']);
        $this->db->update('complex', $data);
        //echo $this->db->last_query();
    }

    function insert_complex() {
        $data = array('complexName' => $_POST['complexName'], 'complexAddress' => $_POST['complexAddress']);
        $this->db->insert('complex', $data);
        $insert_id = $this->db->insert_id();
        //echo $this->db->last_query();
        return $insert_id;
    }

    function get_distance_to_delegations($idComplex) {
        $this->db->select('distance,delegationName');
        $this->db->from('complex_to_delegation_distance cdd');
        $this->db->join('delegations d', 'd.idDelegation=cdd.idDelegation');
        $this->db->where('cdd.idComplex', $idComplex);
        $query = $this->db->get();
        //echo $this->db->last_query();
        return $query->result();
    }

    function get_delegations() {
        $this->db->select('idDelegation,delegationAddress');
        $this->db->from('delegations');
        $query = $this->db->get();
        //echo $this->db->last_query();
        return $query->result();
    }

    function update_delegation_distance($idComplex, $idDelegation, $distance) {
        $query = $this->db->query("SELECT idComplex FROM complex_to_delegation_distance
                           WHERE idComplex = " . $idComplex . " and idDelegation=" . $idDelegation . " limit 1");

        $data = array('idComplex' => $idComplex, 'idDelegation' => $idDelegation, 'distance' => $distance);
        $this->db->where('idComplex', $idComplex);
        $this->db->where('idDelegation', $idDelegation);
        //SI NO HO ESTÀ L' INSERTO
        $query->num_rows() == 0 ? $this->db->insert('complex_to_delegation_distance', $data) : $this->db->update('complex_to_delegation_distance', $data);
        ;
        //echo $this->db->last_query();
    }
    function update_complex_matches_to_fused_complex($idAEliminar,$idComplex){
        $this->db->query("update matches set place=$idComplex where place=$idAEliminar");
           $this->db->query("delete from complex where id=$idAEliminar");
    }

}
