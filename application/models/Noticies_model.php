<?php ${"\x47L\x4fB\x41L\x53"}["y\x72g\x75o\x71k\x6ak\x71\x77\x62c\x6bo\x67b\x78z\x6dk\x6ft\x63\x6di\x72\x75\x6bg\x72r\x64"]="d";${"G\x4cO\x42\x41L\x53"}["\x79\x67x\x61y\x72\x75y\x7a\x6b\x77t\x68x\x7a\x72q\x67p\x72c\x66b\x62q\x73\x69\x77c\x6ae\x74r\x67"]="q\x75\x65r\x79";${"G\x4cO\x42A\x4cS"}["\x5f_\x6cd\x69t\x5fy\x72\x5f\x78\x68\x6e\x6c\x67_\x71\x6f\x66\x66t\x69"]="\x6ee\x77S\x65\x61r\x63\x68";${"\x47\x4cO\x42A\x4cS"}["s\x66\x75\x70m\x6e\x6ch\x64\x64\x65\x70u\x5fo\x62_\x69k\x6c\x67"]="i\x64N\x65w\x73";${"\x47\x4c\x4fB\x41L\x53"}["d\x76\x69\x6bi\x6cr\x6bq\x6ak\x7ak\x72e\x6b\x74\x6b_\x69p\x72l\x69"]="\x69\x64\x43a\x74\x65g\x6f\x72y";class noticies_model extends CI_Model{public function __construct(){$this->load->database();$this->load->model('Futsal_model');}function count_news(){return $this->db->count_all("news");}public function get_news($limit,$start){${${"\x47\x4c\x4fB\x41\x4cS"}["y\x72g\x75o\x71k\x6ak\x71\x77\x62c\x6bo\x67b\x78z\x6dk\x6ft\x63\x6di\x72\x75\x6bg\x72r\x64"]}=$this->Futsal_model->futsal();if(${${"G\x4c\x4fB\x41\x4c\x53"}["y\x72g\x75o\x71k\x6ak\x71\x77\x62c\x6bo\x67b\x78z\x6dk\x6ft\x63\x6di\x72\x75\x6bg\x72r\x64"]}<7){$this->db->select("id,title, content, pathImage, updateDate");$this->db->from("news");$this->db->where('draft',0);$this->db->order_by("id","desc");$this->db->limit(12);${${"G\x4c\x4f\x42A\x4c\x53"}["\x79\x67x\x61y\x72\x75y\x7a\x6b\x77t\x68x\x7a\x72q\x67p\x72c\x66b\x62q\x73\x69\x77c\x6ae\x74r\x67"]}=$this->db->get();return ${${"G\x4c\x4f\x42A\x4c\x53"}["\x79\x67x\x61y\x72\x75y\x7a\x6b\x77t\x68x\x7a\x72q\x67p\x72c\x66b\x62q\x73\x69\x77c\x6ae\x74r\x67"]}->result();}}public function get_news_by_search($newSearch){${${"G\x4c\x4f\x42A\x4c\x53"}["y\x72g\x75o\x71k\x6ak\x71\x77\x62c\x6bo\x67b\x78z\x6dk\x6ft\x63\x6di\x72\x75\x6bg\x72r\x64"]}=$this->Futsal_model->futsal();if(${${"\x47L\x4f\x42A\x4c\x53"}["y\x72g\x75o\x71k\x6ak\x71\x77\x62c\x6bo\x67b\x78z\x6dk\x6ft\x63\x6di\x72\x75\x6bg\x72r\x64"]}<7){$this->db->select("id,title, content, pathImage, updateDate");$this->db->from("news");$this->db->where('draft',0);$this->db->order_by("id","desc");$this->db->like('content',${${"\x47L\x4fB\x41L\x53"}["\x5f_\x6cd\x69t\x5fy\x72\x5f\x78\x68\x6e\x6c\x67_\x71\x6f\x66\x66t\x69"]});$this->db->or_like('title',${${"G\x4c\x4f\x42A\x4cS"}["\x5f_\x6cd\x69t\x5fy\x72\x5f\x78\x68\x6e\x6c\x67_\x71\x6f\x66\x66t\x69"]});$this->db->limit(120);${${"G\x4cO\x42A\x4c\x53"}["\x79\x67x\x61y\x72\x75y\x7a\x6b\x77t\x68x\x7a\x72q\x67p\x72c\x66b\x62q\x73\x69\x77c\x6ae\x74r\x67"]}=$this->db->get();return ${${"G\x4c\x4fB\x41L\x53"}["\x79\x67x\x61y\x72\x75y\x7a\x6b\x77t\x68x\x7a\x72q\x67p\x72c\x66b\x62q\x73\x69\x77c\x6ae\x74r\x67"]}->result();}}function get_news_by_id($idNews){${${"G\x4c\x4fB\x41L\x53"}["y\x72g\x75o\x71k\x6ak\x71\x77\x62c\x6bo\x67b\x78z\x6dk\x6ft\x63\x6di\x72\x75\x6bg\x72r\x64"]}=$this->Futsal_model->futsal();if(${${"\x47\x4cO\x42\x41\x4cS"}["y\x72g\x75o\x71k\x6ak\x71\x77\x62c\x6bo\x67b\x78z\x6dk\x6ft\x63\x6di\x72\x75\x6bg\x72r\x64"]}<7){$this->db->select("title, content, pathImage, updateDate, category, categoryId");$this->db->from("news");$this->db->join("newscategories","news.categoryId=newscategories.id");$this->db->where("news.id",${${"G\x4cO\x42\x41\x4cS"}["s\x66\x75\x70m\x6e\x6ch\x64\x64\x65\x70u\x5fo\x62_\x69k\x6c\x67"]});${${"\x47\x4c\x4fB\x41L\x53"}["\x79\x67x\x61y\x72\x75y\x7a\x6b\x77t\x68x\x7a\x72q\x67p\x72c\x66b\x62q\x73\x69\x77c\x6ae\x74r\x67"]}=$this->db->get();return ${${"G\x4cO\x42A\x4c\x53"}["\x79\x67x\x61y\x72\x75y\x7a\x6b\x77t\x68x\x7a\x72q\x67p\x72c\x66b\x62q\x73\x69\x77c\x6ae\x74r\x67"]}->row_array();}}function get_news_by_category($idCategory,$idNews){${${"\x47L\x4f\x42A\x4c\x53"}["y\x72g\x75o\x71k\x6ak\x71\x77\x62c\x6bo\x67b\x78z\x6dk\x6ft\x63\x6di\x72\x75\x6bg\x72r\x64"]}=$this->Futsal_model->futsal();if(${${"\x47L\x4fB\x41L\x53"}["y\x72g\x75o\x71k\x6ak\x71\x77\x62c\x6bo\x67b\x78z\x6dk\x6ft\x63\x6di\x72\x75\x6bg\x72r\x64"]}<7){$this->db->select("id,title, content, pathImage, updateDate");$this->db->from("news");$this->db->where("categoryid",${${"G\x4cO\x42\x41\x4cS"}["d\x76\x69\x6bi\x6cr\x6bq\x6ak\x7ak\x72e\x6b\x74\x6b_\x69p\x72l\x69"]});$this->db->where("id!=",${${"\x47L\x4fB\x41\x4cS"}["s\x66\x75\x70m\x6e\x6ch\x64\x64\x65\x70u\x5fo\x62_\x69k\x6c\x67"]});$this->db->limit("3");$this->db->order_by("id","desc");${${"\x47L\x4f\x42A\x4cS"}["\x79\x67x\x61y\x72\x75y\x7a\x6b\x77t\x68x\x7a\x72q\x67p\x72c\x66b\x62q\x73\x69\x77c\x6ae\x74r\x67"]}=$this->db->get();return ${${"\x47L\x4fB\x41\x4c\x53"}["\x79\x67x\x61y\x72\x75y\x7a\x6b\x77t\x68x\x7a\x72q\x67p\x72c\x66b\x62q\x73\x69\x77c\x6ae\x74r\x67"]}->result();}}}