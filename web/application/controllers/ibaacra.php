<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ibaacra extends CI_Controller {

  public function index()
 {
    //$this->load->model('Admin_model');
	//$data['reposit_data']=$this->Admin_model->connect();
	//$data['ctrl_name']='The home';
	$data['membersHeader']='includes/templates/ibaacra/header';
	$data['main_content']='ibaacra/ibaacra';
	$data['membersFooter']='includes/templates/ibaacra/footer';
	$this->load->view('includes/template',$data);
 }

}