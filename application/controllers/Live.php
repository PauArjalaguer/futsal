<?php

class Live extends CI_Controller {

    public function __construct() {
        parent::__construct();
       
    }

    public function index() {
        echo "<iframe src=\"https://www.wim.tv/embed/?cast=54daf720-d4d0-47cc-be9b-6928710ea14f&autostart=true\" style=\"border:none; position:absolute; top:0; left:0; width:100%; height:100%;\"></iframe>";
    }
}