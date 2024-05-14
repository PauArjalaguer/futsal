<?php

class Noticies extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('noticies_model');
        $this->load->library('table');
        $this->load->helper('functions_helper');
        $this->load->library("pagination");
    }

    public function index() {
        $n = 60 ;

        $data['get_news'] = $this->noticies_model->get_news(0, 10);

        $config["base_url"] = base_url() . "noticies/1";
        $config["total_rows"] = $this->noticies_model->count_news();
        $config["per_page"] = 20;
        $config["uri_segment"] = 2;

        $data["links"] = $this->pagination->create_links();
        $this->load->view('templates/header');
        $this->load->view('noticies', $data);
        $this->load->view('templates/footer');
        $this->output->cache($n);
    }
 public function newsSearch() {
        $newsSearch = $this->input->post('newsSearch');

        $data['get_news'] = $this->noticies_model->get_news_by_search($newsSearch);

        $this->load->view('noticiesSearch', $data);
    }

    public function detall($idNews) {
        $n = 60;

        $data = $this->noticies_model->get_news_by_id($idNews);
        $data['get_news_by_category'] = $this->noticies_model->get_news_by_category($data['categoryId'], $idNews);
        $this->load->view('templates/header');
        $this->load->view('noticia', $data);
        $this->load->view('templates/footer');
        $this->output->cache($n);
    }

}
