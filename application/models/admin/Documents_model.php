<?php

Class Documents_model extends CI_Model {

    function get_all_documents() {
        $this->db->select("id,fileName, inserted");
        $this->db->from("documents");
        $this->db->order_by("inserted", "desc");
        $query = $this->db->get();// echo $this->db->last_query();
        return $query->result();
    }
    function get_document_by_id($id) {
        $this->db->select("id,fileName, inserted");
        $this->db->from("documents");
       $this->db->where('id', $id);
        $query = $this->db->get();// echo $this->db->last_query();
         return $query->row_array();
    }
    function insert_document($name) {
        $data = array('filename' => $name,'filepath' => $name,'category'=>4);
        $this->db->set('Inserted', 'NOW()', FALSE);
        $this->db->insert('documents', $data);
        return $insert_id = $this->db->insert_id();
    }

    function update_document($id) {
        $data = array('fileName' => $_POST['fileName'],'category'=>$_POST['category']);
        $this->db->where('id', $id);
        $this->db->update('documents', $data);
    }
      function delete_document($id) {
        $this->db->delete('documents', array('id' => $id));
    }
    function get_all_categories(){
         $this->db->select("id,title");
        $this->db->from("downloadcategories");
        $this->db->order_by("title", "asc");
        $query = $this->db->get();// echo $this->db->last_query();
        return $query->result();
    }
}