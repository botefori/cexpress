<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

  public function index()
 {
    $this->load->model('Admin_model');
	$data['reposit_data']=$this->Admin_model->connect();
	$data['ctrl_name']='The home';
	$data['membersHeader']='includes/templates/log/header';
	$data['main_content']='back-office/log/login';
	$data['membersFooter']='includes/templates/log/footer';
	$this->load->view('includes/template',$data);
 }

}