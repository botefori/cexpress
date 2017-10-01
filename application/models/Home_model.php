<?php

class Home_model extends CI_Model{
 
 function __construct() {
   parent::__construct();
}
 
 function connect()
 {
      $this->load->database('cexpress');
	  $query = $this->db->query("SELECT * FROM cexp_users WHERE ID = 1");
      $value = $query->row();
      return $value;
 }
 
}