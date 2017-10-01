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
	 
	 public function compute_freight_amount($packetPieces, $setupData, $packetSourceAddress, $packetTargetAddress){
	   
	   $resultPieces=array();
	   $errorsList=array();
	   $packetAmount=0;
	   foreach($packetPieces as $pieceData){
	      $currentPieceVolumeValue=$pieceData->height*$pieceData->lenght*$pieceData->width;
		   $currentpiece=array();
		   $current_error=array();
		   $currentpiece["Lenght"]=$pieceData->lenght;
		   $currentpiece["Height"]=$pieceData->height;
		   $currentpiece["Width"]=$pieceData->width;
		   $currentpiece["Designation"]=$pieceData->Designation;
		   $currentpiece["Weight"]=$pieceData->Weight;
		   
		   $currentCollectionSetup=$this->getCollectionSetup($setupData["ServiceID"], 
															  $setupData["MeansID"],
															  $pieceData->ArticleID, 
															  $currentPieceVolumeValue, 
															  $pieceData->Weight, 
															  $packetSourceAddress["StateProvinceID"], 
															  $packetTargetAddress["StateProvinceID"]);
			if(isset($currentCollectionSetup->CollectionsetupID)){
			   $currentpiece["CollectionsetupID"]=$currentCollectionSetup->CollectionsetupID;
			   $currentpiece["Amount"]=$currentCollectionSetup->Amount;
            }else{
			  // Pas de ligne correspondate dans la table de paramétrage
			  if($pieceData->ArticleID>1){
			   $currentArticle=$this->getArticleByID($pieceData->ArticleID);
			   $currentMeans=$this->getMeansByID($setupData["MeansID"]);
			   $currentService=$this->getServiceByID($setupData["ServiceID"]);
			   
			   $current_error["error_msg"]='Nous ne traitons pas cette destination pour ce colis';
			   $current_error["article"]=$currentArticle->Designation;
			   $current_error["means"]=$currentMeans->Designation;
			   $current_error["service"]=$currentService->ServiceName;
			   
			   array_push($errorsList,$current_error);
			  }else{
			   $currentMeans=$this->getMeansByID($setupData["MeansID"]);
			   $currentService=$this->getServiceByID($setupData["ServiceID"]);
			   
			   $current_error["error_msg"]='Nous ne traitons pas cette destination pour ce colis';
			   $current_error["article"]=$pieceData->Designation;
			   $current_error["means"]=$currentMeans->Designation;
			   $current_error["service"]=$currentService->ServiceName;
			   array_push($errorsList,$current_error);
			  }
			}
			if($pieceData->ArticleID>1 && count($current_error)==0){
			$currentpiece["Designation"]=$currentCollectionSetup->Designation;
			$currentpiece["Weight"]=($currentCollectionSetup->MaxWeight-$currentCollectionSetup->MinWeight)/2;
		   }
		   if(count($current_error)==0){
		    array_push($resultPieces,$currentpiece);
		    $packetAmount=$packetAmount+$currentCollectionSetup->Amount;
		   }
	   }
	   if(count($errorsList)>0)
	    return $errorsList;
	   $total_amount=array("TotalAmount"=>$packetAmount);
	   //array_push($resultPieces,$total_amount);
	   return $resultPieces;
	   
	 }
	 
	 
	 
	 

	 /* Hier where is shipement setup is made */
	 public function add_new_shipment($setupData,$piecesData,$packetData, $consigneeData, $consignorData, $packetOriginAddresse, $packetdeliveryAddresse){
	   $currentConsigneeID=$this->add_new_customer($consigneeData);
	   $currentConsignorID=$this->add_new_customer($consignorData);
	   
	   $packetData["ConsignorID"]=$currentConsignorID;
	   $packetData["ConsigneeID"]=$currentConsigneeID;
	   $packetData["AmountCollection"]=0.0; 
	   $packetData["StatusID"]=1;
	   
	   $currentDate=date("YmdHis");
	   $trackcodeOrgine=strtoupper(substr($this->getStateNameById($packetOriginAddresse["StateProvinceID"]),0,2));
	   $trackcodeDestination=strtoupper(substr($this->getStateNameById($packetdeliveryAddresse["StateProvinceID"]),0,2));
	   $trackcodeConsigneePhone=substr(preg_replace('/\s+/', '', $consigneeData["Phone"]),0,2);
	   $trackcodeConsignorPhone=substr(preg_replace('/\s+/', '', $consignorData["Phone"]),0,2);
	   $packetData["TrackingCode"]=$trackcodeOrgine.$currentDate.$trackcodeDestination.$trackcodeConsigneePhone.$trackcodeConsignorPhone;
	   $packetData["PacketCategoryID"]=2;
	   $packetTrakingData["TrackingCode"]=$packetData["TrackingCode"];
	   $packetTrakingData["Comment"]="Waiting";
	   
	   $packetID=$this->add_new_packet($packetData);
	   $packetAmount=0;
	   //$this->debug_to_console($piecesData);
	   foreach($piecesData as $pieceData){
	       $currentpiece=array();
		   $currentPacketVolumeValue=$pieceData->height*$pieceData->lenght*$pieceData->width;
		   $currentpiece["Lenght"]=$pieceData->lenght;
		   $currentpiece["Height"]=$pieceData->height;
		   $currentpiece["Width"]=$pieceData->width;
		   $currentpiece["Designation"]=$pieceData->Designation;
		   $currentpiece["Weight"]=$pieceData->Weight;
		   $currentCollectionSetup=$this->getCollectionSetup($setupData["ServiceID"], 
															  $setupData["MeansID"],
															  $pieceData->ArticleID, 
															  $currentPacketVolumeValue, 
															  $pieceData->Weight, 
															  $packetOriginAddresse["StateProvinceID"], 
															  $packetdeliveryAddresse["StateProvinceID"]); 
			if(isset($currentCollectionSetup->CollectionsetupID)){
			   $currentpiece["CollectionsetupID"]=$currentCollectionSetup->CollectionsetupID;
			   $currentpiece["Amount"]=$currentCollectionSetup->Amount;
            }			
		   $currentpiece["PacketID"]=$packetID; 
		  
		   if($pieceData->ArticleID>1){
			$currentpiece["Designation"]=$currentCollectionSetup->Designation;
			$currentpiece["Weight"]=($currentCollectionSetup->MaxWeight-$currentCollectionSetup->MinWeight)/2;
		   }
		   if(isset($currentCollectionSetup->CollectionsetupID))
		   $packetAmount=$packetAmount+$currentCollectionSetup->Amount;
		   
	       $piecesID=$this->add_new_pieces($currentpiece);
	   }
	   /*$this->debug_to_console($packetAmount);*/
	   $this->upadatePacket($packetAmount,$packetID);
	   $packetAmount=0;
	   //$packetOriginAddresse["City"]=$this->getCityByID($packetOriginAddresse["City"]);
	   $packetOriginAddresseID=$this->add_new_address($packetOriginAddresse);
	   
	   //$packetdeliveryAddresse["City"]=$this->getCityByID($packetdeliveryAddresse["City"]);
	   $packetdestinationAddresseID=$this->add_new_address($packetdeliveryAddresse);
	   
	   $trackingID=$this->add_new_packet_tracking($packetTrakingData);
	   
	  $packetAddressesData=array('PacketID'=>$packetID, 'DestinationAdressID'=>$packetdestinationAddresseID, 'OriginAddressID'=>$packetOriginAddresseID);
	  $this->load->database('cexpress');
	  $ins=$this->db->insert_string('cexp_packetaddresses',$packetAddressesData);
	  $this->db->query($ins);  
	  return  $packetID;
	   
	 }
	public function request_packet_status($serviceID, $packetID){
	}
	 
  public function add_new_packet($packetData){
      $this->load->database('cexpress');
	  $ins=$this->db->insert_string('cexp_packet',$packetData);
	  $resp=$this->db->query($ins);
	  if(!$resp){
	      return array('dbError'=>"Une erreur s'est produite ");
	  }
	  return $this->db->insert_id();
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
  
  public function add_new_pieces($piecesData){
      $this->load->database('cexpress');
	  $ins=$this->db->insert_string('cexp_pieces',$piecesData);
	  $resp=$this->db->query($ins);
	  if(!$resp){
	     return array('dbError'=>"Une erreur s'est produite ");
	  }
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
  
  /* return the services list */
  public function getServicesList(){
    $this->load->database('cexpress');
	$query = $this->db->query("SELECT * FROM cexp_services");
    $services = $query->result();
	return $services;
  }
  
  /* return the means list */
   public function getMeansList(){
    $this->load->database('cexpress');
	$query = $this->db->query("SELECT * FROM cexp_means");
    $services = $query->result();
	return $services;
  }
  
  /* return an service, the Id of the service as parameter */
  
  public function getServiceByID($serviceID){
    $this->load->database('cexpress');
	$this->db->select('*');
	$this->db->where('ServiceID',$serviceID);
	$query=$this->db->get('cexp_services');
	$asked_service=$query->row();
	return $asked_service;
  }
  
  /* return an article, the Id of the article as parameter */
  
  public function getArticleByID($articleID){
    $this->load->database('cexpress');
	$this->db->select('*');
	$this->db->where('ArticleID',$articleID);
	$query=$this->db->get('cexp_articles');
	$asked_article=$query->row();
	return $asked_article;
  }
  
  /* return a means, the Id of the means as parameter */
  
  public function getMeansByID($meansID){
    $this->load->database('cexpress');
	$this->db->select('*');
	$this->db->where('MeansID',$meansID);
	$query=$this->db->get('cexp_means');
	$asked_means=$query->row();
	return $asked_means;
  }
  
  /* return the articles list */
   public function getArticlesList(){
    $this->load->database('cexpress');
	$query = $this->db->query("SELECT * FROM cexp_articles");
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
  
  public function getStateNameById($stateID){
    $this->load->database('cexpress');
	$queryState=$this->db->query("SELECT * FROM cexp_pays pays
	                             WHERE pays.id=".$stateID);
	$resp=$queryState->row();
	if(!$resp){
		 return array('dbError'=>"pas de pays correspondant");
	}else{
	  return $resp->nom_fr_fr;
	}
  }
  
  
   /* Get city by the postal code value */
   
  public function getCityByID($cityID){
    $this->load->database('cexpress');
	$query=$this->db->get('cexp_ville');
	$this->db->where('cp',$cityID);
	if($query->num_rows()>0){
	 $row=$query->row();
	 return $row->nom;
	}
  }
  
   /* Get Packet by it id value */
  
  public function getPacketByID($packetID){ 
    //mysql_query('SET CHARACTER SET utf8');
	$this->load->database('cexpress');
	$queryPacket = $this->db->query("SELECT * FROM cexp_packet pkt
	                                 INNER JOIN cexp_pieces pcs ON pcs.PacketID=pkt.PacketID
									 INNER JOIN cexp_packetstatus stu ON stu.StatusID=pkt.StatusID
                                     WHERE pkt.PacketID=".$packetID);
	$resp=$queryPacket->result();
	if(!$resp){
		 return array('dbError'=>"Indentifiant incorect; vous avez peut-être fait une erreur sur  l'identifiant de votre colis");
	}else{
	  return $resp;
	}
  }
  
  
  /* Get Packet by trackingCode  */
  
  public function getPacketUsingTrackingCode($packetTrackingCode){ 
    $trackingDatas=[];
	$this->load->database('cexpress');
	$queryTrackingHistoriQue = $this->db->query("SELECT Comment, DATE_FORMAT(Date, '%d %M %Y   %H:%i:%s') AS Date FROM cexp_packetshistorique pkthstor
                                     WHERE pkthstor.TrackingCode='".$packetTrackingCode."'");
	
	$resp=$queryTrackingHistoriQue->result();
	$trackingDatas["historiQue"]=$resp;
									 
	$queryPacketDetails = $this->db->query("SELECT * FROM cexp_packet pkt
	                                        INNER JOIN cexp_pieces pcs ON pcs.PacketID=pkt.PacketID
                                            WHERE pkt.TrackingCode='".$packetTrackingCode."'");
											
	$resp=$queryPacketDetails->result();
	$trackingDatas["trackingDetails"]=$resp;
	if(!$resp){
		 return array('dbError'=>"Indentifiant incorect; vous avez peut-être fait une erreur sur  votre code de suivie de colis");
	}else{
	  return $trackingDatas;
	}
  }
  
  /* Get weight range that correspond to the current Package weight */
  
  public function getWeightRangeIDByWeightValue($weightValue){
	$this->load->database('cexpress');
	$queryPacket = $this->db->query("SELECT * FROM cexp_weightRanges WHERE MinWeight<".$weightValue." OR MaxWeight>=".$weightValue);
	if($queryPacket->num_rows()>0){
	 $row=$queryPacket->row();
	 return $row->WeightRangesID;
	} 
  }
  
  /* Get volume range that correspond to the current Package volume */
  public function getVolumeRangeIDByVolumeValue($VolumeValue){
	$this->load->database('cexpress');
	$queryPacket = $this->db->query("SELECT * FROM cexp_volumeRanges WHERE MinVolume<=".$VolumeValue." OR MaxVolume>".$VolumeValue);
	if($queryPacket->num_rows()>0){
	 $row=$queryPacket->row();
	 return $row->VolumeRangeID;
	} 
  }
  
  /*  Update the packet with the compted amount value*/
  
  public function upadatePacket($dataValu, $packetId){
   $this->load->database('cexpress');
   $data = array('AmountCollection' => $dataValu,);
    $this->db->where('PacketID', $packetId);
    $this->db->update('cexp_packet', $data); 
  }
  
 public function debug_to_console($data) {
    if(is_array($data) || is_object($data))
	{
		echo("<script>console.log('PHP: ".json_encode($data)."');</script>");
	} else {
		echo("<script>console.log('PHP: ".$data."');</script>");
	}
 }
  
  /*  Return collection setup using join request*/
  
  public function getCollectionSetup($serviceID, $meansID,$articleID, $volumeRanges=null, $weightRanges=null, $stateOrigineID, $stateDestinationID){
     if($articleID==1){
		 $this->load->database('cexpress');
		 $this->db->select('*');
		 $this->db->from('cexp_collectionsetup colSetup');
		 $this->db->where('colSetup.ArticleID=1');	 
		 $this->db->join('cexp_services srvc', 'srvc.ServiceID=colSetup.ServiceID', 'inner');
		 $this->db->join('cexp_means mns', 'mns.MeansID=colSetup.MeansID', 'inner');
		 $this->db->where('colSetup.MeansID',$meansID);
		 $this->db->join('cexp_pays ste1', 'ste1.id=colSetup.StateOrigineID', 'inner');
		 $this->db->where('colSetup.StateOrigineID',$stateOrigineID);
		 $this->db->join('cexp_pays ste2', 'ste2.id=colSetup.StateDestinationID', 'inner');
		 $this->db->where('colSetup.StateDestinationID',$stateDestinationID);
		 $this->db->join('cexp_weightRanges wrg', 'wrg.WeightRangesID=colSetup.WeightRangesID', 'inner');
		 $this->db->where('wrg.MinWeight<',$weightRanges);
		 $this->db->where('wrg.MaxWeight>=',$weightRanges);
		 $this->db->join('cexp_volumeRanges vrg', 'vrg.VolumeRangeID=colSetup.VolumeRangesID', 'inner');
		 $this->db->where('vrg.MinVolume<',$volumeRanges);
		 $this->db->where('vrg.MaxVolume>=',$volumeRanges);  
		 $this->db->where('colSetup.ServiceID',$serviceID);  
		 $resp = $this->db->get();  
		 
	    if(!$resp){
		 return array('dbError'=>"Indentifiant incorect; vous avez peut-être fait une erreur sur  l'identifiant de votre colis");
		}else{
		  return $resp->row();
		}
		 
	 }else{
	    $this->load->database('cexpress');
	    $queryPacket = $this->db->query("SELECT * FROM cexp_collectionsetup colectSetup
		                                 INNER JOIN cexp_articles arti ON arti.ArticleID=colectSetup.ArticleID
										 INNER JOIN cexp_volumeRanges vrg ON vrg.VolumeRangeID=colectSetup.VolumeRangesID
										 INNER JOIN cexp_weightRanges wrg ON wrg.WeightRangesID=colectSetup.WeightRangesID
		                                 WHERE colectSetup.ArticleID=".$articleID.
										 " AND  colectSetup.ServiceID=".$serviceID.
										 " AND  colectSetup.MeansID=".$meansID.
										 " AND  colectSetup.StateOrigineID=".$stateOrigineID.
										 " AND  colectSetup.StateDestinationID=".$stateDestinationID);
		if($queryPacket->num_rows()>0){
		 $row=$queryPacket->row();
		 return $row;
		}else{
		  return array('dbError'=>"Indentifiant incorect; vous avez peut-être fait une erreur sur  l'identifiant de votre colis");
		}
	 }
  }

}