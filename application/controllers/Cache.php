<?php

class Cache extends CI_Controller {

    public function __construct() {
        parent::__construct();
      
        }

    public function index() {
        $this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
           echo  $this->cache->clean();
    }

    public function neteja() {
      $this->output->clear_all_cache();
    }

}

?>