<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

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
	 
	private $filtres ;
	private $itemsByPage=8;
	
	public function index()
	{
	    $this->load->model('Admin_model');
		$data['reposit_data']=$this->Admin_model->connect();
		$data['ctrl_name']='The home';
		
		$data['membersHeader']='includes/templates/admin/header';
	    $data['main_content']='admin/admin';
	    $data['membersFooter']='includes/templates/admin/footer';
		$this->load->view('includes/template',$data);
	}
	
	public function login(){
	  $this->load->model('Admin_model');
		$data['reposit_data']=$this->Admin_model->connect();
		$data['ctrl_name']='The home';
		
		$data['membersHeader']='includes/templates/log/header';
	    $data['main_content']='back-office/log/login';
	    $data['membersFooter']='includes/templates/log/footer';
		$this->load->view('includes/template',$data);
	}
	
	public function tracking(){
		$this->load->view('back-office/tracking/tracking');
	}
	
	public function ourservices(){
		$this->load->view('back-office/ourservices/ourservices');
	}
	
	public function pricing(){
		$this->load->view('back-office/pricing/pricing');
	}
	
	public function quoting(){
		$this->load->view('back-office/quoting/quoting');
	}
	
	public function packet_tracking(){
	  $this->load->view('back-office/tracking/packet-tracking');
	}
	
	public function packetList(){
	   $this->load->model('Admin_model');
	   $datas=$this->Admin_model->requestPacketList();
	   $this->output->set_header('Content-Type: application/json; charset=utf-8');
	   $this->output->set_output(json_encode($datas));
	}
	
	public function statusList(){
	   $this->load->model('Admin_model');
	   $datas=$this->Admin_model->reguestPacketStatusList();
	   $this->output->set_header('Content-Type: application/json; charset=utf-8');
	   $this->output->set_output(json_encode($datas));
	}
	
	public function requestPacketsUsingPageId(){
	   $this->load->model('Admin_model');
	   $numpage =json_decode($this->input->get('numpage'));
	   $params=$this->calculBornes($numpage);
	   $datas=$this->Admin_model->requestPacketsUsingPageId($params["born_inf"], $this->itemsByPage);
	   $this->output->set_header('Content-Type: application/json; charset=utf-8');
	   $this->output->set_output(json_encode($datas));
	}
	
	public function computePagesNumber(){
	   $this->load->model('Admin_model');
	   $numpage =json_decode($this->input->get('numpage'));
	   $params=$this->calculBornes($numpage);
	   $datas=$this->Admin_model->requestPacketRowsCount();
	   $data["pageNumber"]=ceil($datas/$this->itemsByPage);
	   $this->output->set_header('Content-Type: application/json; charset=utf-8');
	   $this->output->set_output(json_encode($data));
	}
	
	private function calculBornes($numpage){
	 $born_inf=(($this->itemsByPage)*($numpage-1))+($numpage);
     $born_sup=(($this->itemsByPage)*($numpage))+($numpage);		 
	 $params=array(
	  'born_inf'=>$born_inf,
      'born_sup'=>$born_sup
	 );
     return $params;	 
	}
	
	 public function counttablerow(){
	   $tabname=$this->input->get('tabname');
	   $this->load->model('Admin_model');
	   $tab_name='cexp_'.$tabname;
	   //$data['rowCount']=$this->Admin_model->getTabrowcount($tab_name);
	   $data['rowCount']=$this->Admin_model->requestPacketRowsCount();
	   $this->output->set_content_type('application/json')->set_output(json_encode($data));
	 }
	 
	 /* Return the services list  */
	 
	 public function servicesList(){
	   $this->load->model('Admin_model');
	   $datas=$this->Admin_model->getServicesList();
	   $this->output->set_header('Content-Type: application/json; charset=utf-8');
	   $this->output->set_output(json_encode($datas));
	 }
	 
	 public function updateSelectedPacket(){
	   $selectedPacket=json_decode($this->input->get('packet'));
	   $this->load->model('Admin_model');
	   $data['updatedID']=$this->Admin_model->updateSelectedPacket($selectedPacket);
	   $this->output->set_content_type('application/json')->set_output(json_encode($data));
	 }
}
