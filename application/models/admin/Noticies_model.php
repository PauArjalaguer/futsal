<?php

Class Noticies_model extends CI_Model {

    function get_news() {
        $this->db->select("news.id,title, content, pathImage, insertDate,updateDate, category, categoryId,pinned, draft");
        $this->db->from("news");
        $this->db->join("newscategories", "news.categoryId=newscategories.id", "left");
        $this->db->order_by("insertDate", "desc");
		   $this->db->order_by("news.id", "desc");
		$this->db->limit(50); 
        $query = $this->db->get();
// echo $this->db->last_query();
        return $query->result();
    }

    function get_news_by_id($idNews) {
        $this->db->select("news.id,title, content, pathImage, insertDate,updateDate, category, categoryId,pinned, draft");
        $this->db->from("news");
        $this->db->join("newscategories", "news.categoryId=newscategories.id", "left");
        $this->db->where("news.id", $idNews);
        $query = $this->db->get();
// echo $this->db->last_query();
        return $query->row_array();
    }

    function get_news_categories() {
        $this->db->select("id, category");
        $this->db->from("newscategories");

        $query = $this->db->get();
        return $query->result();
    }

    function insert_news() {
        $this->db->set('InsertDate', 'NOW()', FALSE);
        $this->db->insert('news', $data);
        return $insert_id = $this->db->insert_id();
    }

    function update_news($id) {
        $data = array('title' => $_POST['newsTitle'], 'pathImage' => str_replace("\"", "", $_POST['newsImage']), 'content' => $_POST['newsText'], 'categoryId' => $_POST['newsCategory']);
        $this->db->set('UpdateDate', 'NOW()', FALSE);
        $this->db->where('id', $id);
        $this->db->update('news', $data);
    }

    function update_news_image($id, $image) {
        $this->db->set('UpdateDate', 'NOW()', FALSE);
        $data = array('pathImage' => $image);
        $this->db->where('id', $id);
        $this->db->update('news', $data);
    }

    function delete_news_image($id) {

        $image = $id . '.jpg';
        $data = array('pathimage' => NULL);
        $this->db->set('UpdateDate', 'NOW()', FALSE);
        $this->db->where('id', $id);
        $this->db->update('news', $data);
    }
     function publish_new($id) {
        $data = array('draft' => 0);
        $this->db->set('UpdateDate', 'NOW()', FALSE);
        $this->db->where('id', $id);
        $this->db->update('news', $data);
    }
    function draft_new($id) {
        $data = array('draft' => 1);
        $this->db->set('UpdateDate', 'NOW()', FALSE);
        $this->db->where('id', $id);
        $this->db->update('news', $data);
    }
     function delete_new($id) {
        $this->db->delete('news', array('id' => $id));
    }

}
?>