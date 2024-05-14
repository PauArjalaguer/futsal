<?php

Class Cache_model extends CI_Model {

    function delete_cache_entries($idItem, $itemType) {
        $this->db->where('idItem', $idItem);
        $this->db->where('itemType', $itemType);
        $this->db->delete('cacheControl');
    }

    function insert_cache_entries($idItem, $itemType,$urlString) {
        $data = array(
            'idItem' => $idItem,
            'itemType' => $itemType,
            'urlString' => $urlString     
          );
        $this->db->set('lastChange', 'NOW()', FALSE);
        $this->db->insert('cacheControl', $data);
    }
    
    function select_cache_entries($idItem, $itemType){
       
        $this->db->select('urlString');
        $this->db->from('cacheControl');
        $this->db->where('idItem',$idItem);
        $this->db->where('itemType',$itemType);
        $query = $this->db->get();
        return $query->row_array();
   
    }

}
