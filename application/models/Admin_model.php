<?php

class Admin_model extends CI_Model{
 
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
 
 public function requestPacketList(){ 
	$this->load->database('cexpress');
	$queryPacket = $this->db->query("SELECT * FROM cexp_packet pkt
									 INNER JOIN cexp_packetstatus stu ON stu.StatusID=pkt.StatusID");
	$resp=$queryPacket->result();
	if(!$resp){
		 return array('dbError'=>"Indentifiant incorect; vous avez peut-être fait une erreur sur  l'identifiant de votre colis");
	}else{
	  return $resp;
	}
  }
  
  /* return the services list */
  public function getServicesList(){
    $this->load->database('cexpress');
	$query = $this->db->query("SELECT * FROM cexp_services");
    $services = $query->result();
	return $services;
 }
  
  public function reguestPacketStatusList(){
    $this->load->database('cexpress');
	$query = $this->db->query("SELECT * FROM cexp_packetstatus");
    $packetstatusList = $query->result();
	return $packetstatusList;
  }
  
  public function getTabrowcount($tabname){
    $this->load->database('cexpress');
    $query = $this->db->count_all($tabname);
	return $query;
  }
  
  public function requestPacketsUsingPageId($limit, $itemsOffset){
    $this->load->database('cexpress');
	
	$queryPacket = $this->db->query("SELECT * FROM cexp_packet pkt
									 INNER JOIN cexp_packetstatus stu ON pkt.StatusID=stu.StatusID 
									 ORDER BY PacketID
									  LIMIT ".$itemsOffset.
									 " OFFSET ".$limit);
									 //WHERE pkt.TrackingCode IS NOT NULL
	$resp=$queryPacket->result();
	if(!$resp){
		 return array('dbError'=>"Indentifiant incorect; vous avez peut-être fait une erreur sur  l'identifiant de votre colis");
	}else{
	  return $resp;
	}
  }
  
  public function requestPacketRowsCount(){
    $this->load->database('cexpress');
	
	$queryPacket = $this->db->query("SELECT COUNT(*) AS rowCount FROM cexp_packet pkt
									 INNER JOIN cexp_packetstatus stu ON pkt.StatusID=stu.StatusID 
									 ORDER BY PacketID"
			                        );
	if($queryPacket->num_rows()>0){
	   $row=$queryPacket->row();
	   return $row->rowCount;
	}else{
	  return array('dbError'=>"Indentifiant incorect; vous avez peut-être fait une erreur sur  l'identifiant de votre colis");
	}
  }
  
  public function updateSelectedPacket($selectedPacket){
    $this->load->database('cexpress');
	$data = array('PacketID' => $selectedPacket->PacketID,
	              'ServiceID' => $selectedPacket->ServiceID,
				  'StatusID' => $selectedPacket->StatusID
				 );
    $this->db->where('PacketID', $selectedPacket->PacketID);
    $this->db->update('cexp_packet', $data);
	
	$packetTrakingData["TrackingCode"]=$selectedPacket->TrackingCode;
	$packetTrakingData["Comment"]=$this->getPacketStatusDesignation($selectedPacket->StatusID);
	$this->add_new_packet_tracking($packetTrakingData);
  }
  
  public function getPacketStatusDesignation($statusID){
    $this->load->database('cexpress');
	$queryStatus=$this->db->query("SELECT * FROM cexp_packetstatus 
	                             WHERE StatusID=".$statusID);
	$resp=$queryStatus->row();
	if(!$resp){
		 return "Waiting";
	}else{
	  return $resp->DesignationStatus;
	}
  }
  
  public function add_new_packet_tracking($packettrackingData){
      $this->load->database('cexpress');
	  $ins=$this->db->insert_string('cexp_packetshistorique',$packettrackingData);
	  $resp=$this->db->query($ins);
	  if(!$resp){
	      return array('dbError'=>"Une erreur s'est insertion donnees tracking");
	  }
	  return $this->db->insert_id();
  }
 
}