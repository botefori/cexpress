<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Office extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
	    $this->load->model('Home_model');
		$data['reposit_data']=$this->Home_model->connect();
		$data['ctrl_name']='The Office';
		$data['membersHeader']='includes/templates/header';
	    $data['main_content']='back-office/office';
	    $data['membersFooter']='includes/templates/footer';
		$this->load->view('includes/template',$data);
	}
}
