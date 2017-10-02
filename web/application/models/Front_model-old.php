<?php

class Front_model extends CI_Model{
 
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
 
	 public function add_new_shipment_old($weight, $content, $pieces, $service){
	   $this->load->database('cexpress');
	   $this->db->set('Weight',$weight);
	   $this->db->set('Content', $content);
	   $this->db->set('Pieces', $pieces);
	   $this->db->set('ServiceID', $service);
	   
	   $query=$this->db->insert("cexp_packet");
	 
	 }
	 
	 public function add_new_shipment($packetData, $consigneeData, $consignorData, $packetOriginAddresse, $packetdeliveryAddresse){
	   $currentConsigneeID=$this->add_new_customer($consigneeData);
	   $currentConsignorID=$this->add_new_customer($consignorData);
	   
	   $packetData["ConsigneeID"]=$currentConsigneeID;
	   $packetData["ConsignorID"]=$currentConsignorID;
	   $packetID=$this->add_new_packet($packetData);
	   
	   $packetOriginAddresse["City"]=$this->getCityByID($packetOriginAddresse["City"]);
	   $packetOriginAddresseID=$this->add_new_address($packetOriginAddresse);
	   
	   $packetdeliveryAddresse["City"]=$this->getCityByID($packetdeliveryAddresse["City"]);
	   $packetdestinationAddresseID=$this->add_new_address($packetdeliveryAddresse);
	  
	  
	  $packetAddressesData=array('PacketID'=>$packetID, 'DestinationAdressID'=>$packetdestinationAddresseID, 'OriginAddressID'=>$packetOriginAddresseID);
	  $this->load->database('cexpress');
	  $ins=$this->db->insert_string('cexp_packetaddresses',$packetAddressesData);
	  $this->db->query($ins);  
	  return  $packetID;
	   
	 }

  public function add_new_packet($packetData){
      $this->load->database('cexpress');
	  $ins=$this->db->insert_string('cexp_packet',$packetData);
	  $this->db->query($ins);
	  return $this->db->insert_id();
  }
  
  
  public function add_new_customer($data){
	  $this->load->database('cexpress');
	  $ins=$this->db->insert_string('cexp_customers',$data);
	  $this->db->query($ins);
	  return $this->db->insert_id();
  }
  
  public function add_new_address($new_address){
      $this->load->database('cexpress');
	  $ins=$this->db->insert_string('cexp_address',$new_address);
	  $this->db->query($ins);
	  return $this->db->insert_id();
  }
  
  public function getStatesList(){
    $this->load->database('cexpress');
	$query = $this->db->query("SELECT * FROM cexp_pays");
    $value = $query->result();
    return $value;
  }
  
  public function getTabrowcount($tabname){
    $this->load->database('cexpress');
    $query = $this->db->count_all($tabname);
	return $query;
  }
  
  public function getServicesList(){
    $this->load->database('cexpress');
	$query = $this->db->query("SELECT * FROM cexp_services");
    $services = $query->result();
	return $services;
  }
  
  public function getCityList(){
    $this->load->helper('string');
    $this->load->database('cexpress');
	$query = $this->db->query("SELECT * FROM cexp_ville");
    $services =$query->result();
	return $services;
  }
  
  public function getStateById($stateID){
    $this->load->database('cexpress');
	$this->db->select('id', 'nom_fr_fr');
	$this->db->where('id',$stateID);
	$query=$this->db->get('cexp_pays');
	$asked_state=$query->result();
	return $asked_state;
  }
  
  public function getCityByID($cityID){
    $this->load->database('cexpress');
	$query=$this->db->get('cexp_ville');
	$this->db->where('cp',$cityID);
	if($query->num_rows()>0){
	 $row=$query->row();
	 return $row->nom;
	}
  }
  
  public function getPacketByID($packetID){
    $this->load->database('cexpress');
	$queryPacket = $this->db->query("SELECT * FROM cexp_packet WHERE PacketID=".$packetID);
	if($queryPacket->num_rows()>0){
	 $row=$queryPacket->row();
	 return $row;
	}
  }
  

}