<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Courrier extends CI_Controller {

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
	 
	/*===========================Loading pages    ==================================================*/
	
	public function index()
	{
	    $this->load->model('Home_model');
		$data['reposit_data']=$this->Home_model->connect();
		$data['ctrl_name']='The front';
		
		$data['membersHeader']='includes/templates/front/header';
	    $data['main_content']='front-office/front/front';
	    $data['membersFooter']='includes/templates/front/footer';
		$this->load->view('includes/templates/front/template',$data);
	}
	
	public function helloworld(){
	  $this->load->view('hello/world');
	}
	
	public function about(){
	    $this->load->model('Home_model');
		$data['reposit_data']=$this->Home_model->connect();
		$data['ctrl_name']='about page';
		
		$data['membersHeader']='includes/templates/front/header';
	    $data['main_content']='front-office/about/about';
	    $data['membersFooter']='includes/templates/front/footer';
		$this->load->view('includes/templates/front/template',$data);
	}
	
	public function services(){
	    $this->load->model('Front_model');
		$data['reposit_data']=json_encode($this->Front_model->getCityList());
		$data['ctrl_name']='about page';
		
		$data['membersHeader']='includes/templates/front/header';
	    $data['main_content']='front-office/services/services';
	    $data['membersFooter']='includes/templates/front/footer';
		$this->load->view('includes/templates/front/template',$data);
	}
	
	public function order(){
	    $this->load->model('Home_model');
		$data['reposit_data']=$this->Home_model->connect();
		$data['ctrl_name']='about page';
		
		$data['membersHeader']='includes/templates/front/header';
	    $data['main_content']='front-office/order/order';
	    $data['membersFooter']='includes/templates/front/footer';
		$this->load->view('includes/templates/front/template',$data);
	}
	
	public function pickup(){
		$this->load->model('Home_model');
		$data['reposit_data']=$this->Home_model->connect();
		$data['ctrl_name']='The front';
		
		$data['membersHeader']='includes/templates/front/header';
	    $data['main_content']='front-office/front/front';
	    $data['membersFooter']='includes/templates/front/footer';
		$this->load->view('includes/templates/front/template',$data);
	}
	
	public function quote_pickup(){
	  $this->load->view('front-office/pickup/quote-pickup');
	}
	
	public function pickup_details(){
	  $this->load->view('front-office/pickup/pickup-details');
	}
	
	public function request_quotation(){
	  $this->load->view('front-office/order/request-quote');
	}
	
	public function dest_pickup(){
	  $this->load->view('front-office/pickup/dest-pickup');
	}
	
	public function prov_pickup(){
	  $this->load->view('front-office/pickup/prov-pickup');
	}
	
	public function pickup_resume(){
	  $this->load->view('front-office/pickup/pickup-resume');
	}
	
	public function quote_resume(){
	  $this->load->view('front-office/order/quote-resume');
	}
	
	public function pricing(){
	   $this->load->model('Home_model');
		$data['reposit_data']=$this->Home_model->connect();
		$data['ctrl_name']='about page';
		
		$data['membersHeader']='includes/templates/front/header';
	    $data['main_content']='front-office/pricing/pricing';
	    $data['membersFooter']='includes/templates/front/footer';
		$this->load->view('includes/templates/front/template',$data);
	}
	
	public function contactus(){
	 $this->load->model('Home_model');
		$data['reposit_data']=$this->Home_model->connect();
		$data['ctrl_name']='about page';
		
		$data['membersHeader']='includes/templates/front/header';
	    $data['main_content']='front-office/contactus/contactus';
	    $data['membersFooter']='includes/templates/front/footer';
		$this->load->view('includes/templates/front/template',$data);
	}
	
	/*==========================================================================================================*/
	
	/*===========================Database CRUD    ======================================================*/
	
	
	
	public function add_shipment(){
	  $this->load->model('Front_model');
	  // Data about the current packet 
	  
	  $weight=$this->input->post('weight');
	  $contentMdl=$this->input->post('contentMdl');
	  $volumeWeight=$this->input->post('volumeWeight');
	  $nbrPiece=$this->input->post('nbrPiece');
	  $service=$this->input->post('service');
	  $dataPacket=array('Weight'=>$weight, 'Content'=>$contentMdl, 'Pieces'=>$nbrPiece, 'ServiceID'=>$service);
	  
	  //Data about the current consignee
	  
	  $consignee=$this->input->post('consignee');
	  $consigneeContact=$this->input->post('consignee-contact');
	  $consigneePhone=$this->input->post('consignee-phone');
	  $consigneeEmail=$this->input->post('consignee-email');
	  $consigneeState=$this->input->post('consignee-state');
	  $consigneePostalcode=$this->input->post('consignee-postalcode');
	  $consigneeCity=$this->input->post('consignee-city');
	  $consigneeAddline1=$this->input->post('consignee-addline1');
	  $consigneeAddline2=$this->input->post('consignee-addline2');
	  $consigneeData=array('FirstName'=>$consignee, 'LastName'=>$consignee, 'Phone'=>$consigneePhone, 'Email'=>$consigneeEmail, 'Contact'=>$consigneeContact);
	 
	 //Data about the current consignor
	  
	  $consignor=$this->input->post('consignor');
	  $consignorContact=$this->input->post('consignor-contact');
	  $consignorPhone=$this->input->post('consignor-phone');
	  $consignorEmail=$this->input->post('consignor-email');
	  $consignorState=$this->input->post('consignor-state');
	  $consignorPostalcode=$this->input->post('consignor-postalcode');
	  $consignorCity=$this->input->post('consignor-city');
	  $consignorAddline1=$this->input->post('consignor-addline1');
	  $consignorAddline2=$this->input->post('consignor-addline2');
	  $consignorData=array('FirstName'=>$consignor, 'LastName'=>$consignor, 'Phone'=>$consignorPhone, 'Email'=>$consignorEmail, 'Contact'=>$consignorContact);
	  
	  $this->Front_model->add_new_shipment($dataPacket, $consigneeData, $consignorData);
	   $data['reposit_data']=$weight.'  '.$contentMdl.' '.$nbrPiece.' '.$service;
		
		$data['membersHeader']='includes/templates/front/header';
	    $data['main_content']='front-office/pickupsuccess/pickupsuccess';
	    $data['membersFooter']='includes/templates/front/footer';
		$this->load->view('includes/templates/front/template',$data);
	}
	
	public function computePacketAmount(){
	   $quotationDatas=json_decode($this->input->get('quotationDatas'));
	   $packetPieces=$quotationDatas->pieces;
	   
	   $setupData=array('ServiceID'=>$quotationDatas->ServiceID,
	                    'MeansID'=>$quotationDatas->MeansID);
		$packetSourceAddress=array('StateProvinceID'=>$quotationDatas->consignorState);
	    $packetTargetAddress=array('StateProvinceID'=>$quotationDatas->consigneeState);
		$this->load->model('Front_model');
		$quotationsResult=$this->Front_model->compute_freight_amount($packetPieces, $setupData, $packetSourceAddress, $packetTargetAddress);
	   $this->output->set_header('Content-Type: application/json; charset=utf-8');
	   $this->output->set_output(json_encode($quotationsResult));
	}
	
	public function addAsynchronousShipment(){
	  $shipmentShudle=json_decode($this->input->get('shipmentData'));
	  
	  $packetQuotationData=$shipmentShudle->packetQuotationData;
	  $packetOrigin=$shipmentShudle->packetOrigin;
	  $packetDestination=$shipmentShudle->packetDestination;
	  $packetPieces=$packetQuotationData->pieces;
	  
	   // Data about the current packet 
	  
	  $dataPacket=array('ServiceID'=>$packetQuotationData->ServiceID);
	  		
						
	  $setupData=array('ServiceID'=>$packetQuotationData->ServiceID,
	                   'MeansID'=>$packetQuotationData->MeansID,
					   'ArticleID'=>"");
	  
	  //Data about about the delevry address of the packet
	  
	  $packetdeliveryAddresse=array('AddressLine1'=>$packetDestination->consigneeAddline1,'AddressLine2'=>$packetDestination->consigneeAddline2,
							        'StateProvinceID'=>$packetQuotationData->consigneeState, 'PostalCode'=>$packetDestination->consigneePostalcode,
									);

	  $packetOriginAddresse=array('AddressLine1'=>$packetOrigin->consignorAddline1, 'AddressLine2'=>$packetOrigin->consignorAddline2,
							      'StateProvinceID'=>$packetQuotationData->consignorState, 'PostalCode'=>$packetOrigin->consignorPostalCode
								 );
	  
	  //Data about the current consignee
	  
	  $consigneeData=array('FirstName'=>$packetDestination->consignee, 'LastName'=>$packetDestination->consignee, 
						   'Phone'=>$packetDestination->consigneePhone, 'Email'=>$packetDestination->consigneeEmail 
						  );
	  
	   //Data about the current consignor
	   
	  $consignorData=array('FirstName'=>$packetOrigin->consignor, 'LastName'=>$packetOrigin->consignor, 
						   'Phone'=>$packetOrigin->consignorPhone, 'Email'=>$packetOrigin->consignorEmail
						  );
	  
	  $this->load->model('Front_model');
	  $insertedPacketID=$this->Front_model->add_new_shipment($setupData,$packetPieces ,$dataPacket, $consigneeData, $consignorData,$packetOriginAddresse, $packetdeliveryAddresse);
	  $insertedPacket=$this->Front_model->getPacketByID($insertedPacketID);
	  $this->output->set_header('Content-Type: application/json; charset=utf-8');
	  $this->output->set_output(json_encode($insertedPacket));
	}
	
	public function getPacketStatus(){	 
	  $packetTracked=json_decode($this->input->get('packetTracked'));
	  $packetID=$packetTracked->PacketID;
	  $this->load->model('Front_model');
	  $requestedPacket=$this->Front_model->getPacketUsingTrackingCode($packetID);
	  $this->output->set_header('Content-Type: application/json; charset=utf-8');
	  $this->output->set_output(json_encode($requestedPacket));
	}
	
	 public function add_customer(){
	 }
	 
	 public function states(){
	   $this->load->model('Front_model');
	   $datas=$this->Front_model->getStatesList();
	   $this->output->set_header('Content-Type: application/json; charset=utf-8');
	   $this->output->set_output(json_encode($datas));
	 }
	 
	 public function cities(){
	   $this->load->model('Front_model');
	   $datas=$this->Front_model->getCityList();
	   $this->output->set_header('Content-Type: application/json; charset=utf-8');
	   $this->output->set_output(json_encode($datas));
	 }
	 
	 public function counttablerow(){
	   $tabname=$this->input->get('tabname');
	   $this->load->model('Front_model');
	   $tab_name='cexp_'.$tabname;
	   $data['rowCount']=$this->Front_model->getTabrowcount($tab_name);
	   $this->output->set_content_type('application/json')->set_output(json_encode($data));
	 }
	 
	 /* Return the services list  */
	 
	 public function servicesList(){
	   $this->load->model('Front_model');
	   $datas=$this->Front_model->getServicesList();
	   $this->output->set_header('Content-Type: application/json; charset=utf-8');
	   $this->output->set_output(json_encode($datas));
	 }
    
	  /* Return the means list  */
	  
	  public function meansList(){
	   $this->load->model('Front_model');
	   $datas=$this->Front_model->getMeansList();
	   $this->output->set_header('Content-Type: application/json; charset=utf-8');
	   $this->output->set_output(json_encode($datas));
	 }
	 
	   /* Return the articles list  */
	  
	  public function articlesList(){
	   $this->load->model('Front_model');
	   $datas=$this->Front_model->getArticlesList();
	   $this->output->set_header('Content-Type: application/json; charset=utf-8');
	   $this->output->set_output(json_encode($datas));
	 }
	
	/*===========================================================================================================*/
	
	
	
}
