var myApp=angular.module('myApp', ['ngRoute','ngCart','ngCart.fulfilment']);

myApp.config(function($routeProvider){
   $routeProvider.when('/', {controller:ListCtrl,templateUrl:BASE_URL+'index.php/courrier/helloworld'});
   $routeProvider.when('/prov_pickup', {controller:ListCtrl,templateUrl:BASE_URL+'index.php/front/prov_pickup'});
   $routeProvider.when('/pickup_resume', {controller:ListCtrl,templateUrl:BASE_URL+'index.php/front/pickup_resume'});
   $routeProvider.when('/dest_pickup', {controller:ListCtrl,templateUrl:BASE_URL+'index.php/front/dest_pickup'});
   $routeProvider.when('/quote_pickup', {controller:ListCtrl,templateUrl:BASE_URL+'index.php/front/quote_pickup'});
   $routeProvider.when('/request_quote', {controller:ListCtrl,templateUrl:BASE_URL+'index.php/front/request_quotation'});
   $routeProvider.when('/quote_resume', {controller:ListCtrl,templateUrl:BASE_URL+'index.php/front/quote_resume'});
   $routeProvider.when('/follow_urpacket', {controller:ListCtrl,templateUrl:BASE_URL+'index.php/front/follow_urpacket'});
   $routeProvider.when('/price_ranges', {controller:ListCtrl,templateUrl:BASE_URL+'index.php/front/price_ranges'});
   $routeProvider.when('/services', {controller:ListCtrl,templateUrl:BASE_URL+'index.php/front/our_services'});
   $routeProvider.otherwise({redirectTo:'/'})
});

function ListCtrl(){
}
myApp.directive('pkStapes', function(){
  var lnkFn=function(scope, elem, attrs){
    scope.$on('$locationChangeSuccess', function(){
	   if(scope.packets.stapeValue==attrs.title){
	      elem.css('color','#cb5731');
	   }else{
			elem.css('color','#060606');
	    }
	});
    
  };
  
  ddo={
   scope:false,
   link:lnkFn
  };
  return ddo;
});


myApp.factory('cexpress', function($http,$location) {
    var myCexpressFactory = {};
	var states=[];
	var means=[];
	var services=[];
	var pieces=[];
	var quotationPieces=[];
	var recapDatas=[];
	var quotationResult=[];
	var quotationErrors=[];
	var trackedData=[];
	var historiQue=[];
	var trackingDetails=[];
	var shipmentData={packetQuotationData:"",packetOrigin:"", packetDestination:"",pieces:""};
	pieces.push({Designation:"",ArticleID:1,Weight:0.00,lenght:0.00,width:0.00, height:0.00, bntadd:"true",displayed:""});
	quotationPieces.push({Designation:"",ArticleID:1,Weight:0.00,lenght:0.00,width:0.00, height:0.00, bntadd:"true",displayed:""});
	
	
	
	
/****************************************************************************************************/

/*********************    PICKUP VARIABLES VIEWS BINDING DATA          ****************************/
	
/****************************************************************************************************/
	
	myCexpressFactory.currentUserAction=false;
	myCexpressFactory.packetQuotationData;
	myCexpressFactory.selectestate={};
	myCexpressFactory.collectionAmount=0;
	myCexpressFactory.packetStatus="";
	myCexpressFactory.dispTotalAmount="none";
	myCexpressFactory.trackerrormessage="";
	myCexpressFactory.dispFormsTag="block";
	myCexpressFactory.stapeValue=2;
	myCexpressFactory.settings={paypal:undefined};
	myCexpressFactory.settings.paypal={business:"berngue-facilitator@hotmail.fr",currency_code:"EUR"};
	myCexpressFactory.master={};
	myCexpressFactory.hasErrorsComputed=false;
	myCexpressFactory.selectedService={ServiceID:"", ServiceName:""};
	myCexpressFactory.selectedMeans={MeansID:"", Designation:""};
	myCexpressFactory.selectedStateOrigin={id:"", nom_fr_fr:""};
	myCexpressFactory.selectedStateDesination={id:"", nom_fr_fr:""};
	myCexpressFactory.packetOrigin={consignor:"", consignorAddline1:"", consignorAddline2:"", consignorPostalCode:"", consignorPhone:"",consignorEmail:""};
	myCexpressFactory.packetDestination={consignee:"", consigneeAddline1:"", consigneeAddline2:"", consigneePostalcode:"", consigneePhone:"",consigneeEmail:""};
	myCexpressFactory.displayDetails="fieldset_displaynone";
	
/****************************************************************************************************/

/*********************  QUOTATION  VARIABLES VIEWS BINDING DATA          ****************************/
	
/*****************************************************************************************************/

    myCexpressFactory.quotationSelectedService={ServiceID:"", ServiceName:""};
	myCexpressFactory.quotationSelectedMeans={MeansID:"", Designation:""};
	myCexpressFactory.quotationSelectedStateOrigin={id:"", nom_fr_fr:""};
	myCexpressFactory.quotationSelectedStateDesination={id:"", nom_fr_fr:""};

/***********************************************************************************/

/*********************      VARIABLES GLOBALES          ****************************/
	
/***********************************************************************************/

	myCexpressFactory.currentSelectedPage=0;
	myCexpressFactory.tabRowCount=[];
	
/*************************************************************************************/	

 /****  REQUETTE ASYNCHRONE PERMETTANT DE CONFIGURER LES DONNEES D'UN ENLEVMENT ******/
 
 /***********************************************************************************/
    myCexpressFactory.setOrigin=function(){
	   $location.path('/dest_pickup');
	   myCexpressFactory.stapeValue=3;
	}
	

	
	myCexpressFactory.setDestination=function(packetDestination){
	  myCexpressFactory.packetDestination=packetDestination;
	}
	
	myCexpressFactory.setQuotationData=function(){
	 var quotationDatas={};
	     quotationDatas.pieces=pieces;
	     quotationDatas.ServiceID=myCexpressFactory.selectedService.ServiceID;
		 quotationDatas.MeansID=myCexpressFactory.selectedMeans.MeansID;
		 quotationDatas.consignorState=myCexpressFactory.selectedStateOrigin.id;
		 quotationDatas.consigneeState=myCexpressFactory.selectedStateDesination.id;
    var fnSuccess=function(results){
	  data=angular.fromJson(results.data);
	  var has_error=data[0].hasOwnProperty('error_msg');
	   myCexpressFactory.hasErrorsComputed=has_error;
	  if(data.length>0 && !has_error)
	  {
	    myCexpressFactory.packetQuotationData=quotationDatas;
		$location.path('/prov_pickup');
		myCexpressFactory.stapeValue=3;
	  }else{
	    quotationErrors=data;
	  }
	  
	};

	var fnfailure=function(results){
				
	};
			
	var promise=$http({ method:"GET",
						url:BASE_URL+"index.php/front/computePacketAmount",
					    params:{quotationDatas:quotationDatas}
					 });
    promise.then(fnSuccess, fnfailure);
	  
	}
	
	
	myCexpressFactory.SetupShipmentPickup=function($scope, $log){
			shipmentData.packetOrigin=myCexpressFactory.packetOrigin;
			shipmentData.packetDestination=myCexpressFactory.packetDestination;
			shipmentData.packetQuotationData=myCexpressFactory.packetQuotationData;
			
			
			var fnSuccess=function(results){
			    var json=JSON.stringify(results.data);
				json=JSON.parse(json);
				data=angular.fromJson(results.data);
				recapDatas=data;
				myCexpressFactory.collectionAmount=data[0].AmountCollection;
				if(data.length>0)
			    {
				 $location.path('/pickup_resume');
				 myCexpressFactory.stapeValue=4;
			    }
				pieces=[];
				pieces.push({Designation:"",ArticleID:1,Weight:0.00,lenght:0.00,width:0.00, height:0.00, bntadd:"true"});
			};

			var fnfailure=function(results){
				$scope.$log=results.error;
			};
			
			var promise=$http({ method:"GET",
								url:BASE_URL+"index.php/front/addAsynchronousShipment",
								params:{shipmentData:shipmentData}
							  });
			promise.then(fnSuccess, fnfailure);
	}
	
	myCexpressFactory.RequestTrack=function(packetTracked){
	   var fnSuccess=function(results){
										data=angular.fromJson(results.data);
										trackedData=data;	
										if(angular.isObject(data) && data.hasOwnProperty("historiQue") && data.hasOwnProperty("trackingDetails")){
											myCexpressFactory.collectionAmount=trackedData.trackingDetails[0].AmountCollection;
											myCexpressFactory.packetStatus=trackedData.trackingDetails[0].DesignationStatus;
											historiQue=trackedData.historiQue;
											trackingDetails=trackedData.trackingDetails;
											myCexpressFactory.dispTotalAmount="block";
											myCexpressFactory.trackerrormessage=undefined;
										}else{
										  myCexpressFactory.dispTotalAmount="block";
										  myCexpressFactory.collectionAmount=undefined;
										  myCexpressFactory.packetStatus=undefined;
										  myCexpressFactory.trackerrormessage=trackedData.dbError;
										}
		};
	
	   var fnfailure=function(results){
				                       data=results.data;
			                          };
	
	   var promise=$http({ method:"GET",
							 url:BASE_URL+"index.php/front/getPacketStatus",
							 params:{packetTracked:packetTracked}
						  });
	    
		promise.then(fnSuccess, fnfailure);
	}
	
	
/***********************************************************************************************/
	
	/*****    VALIDATION DU FORMULAIRE DE QUOTATION PAR L'UTILISATEUR AFIN QUE SON FREIGHT SOIT EVALUE  *********/
	
	
	/**********************************************************************************************/
	
	
    myCexpressFactory.makeQuotation = function() {
	    var quotationDatas={};
	    quotationDatas.pieces=quotationPieces;
	    quotationDatas.ServiceID=myCexpressFactory.quotationSelectedService.ServiceID;
		quotationDatas.MeansID=myCexpressFactory.quotationSelectedMeans.MeansID;
		quotationDatas.consignorState=myCexpressFactory.quotationSelectedStateOrigin.id;
		quotationDatas.consigneeState=myCexpressFactory.quotationSelectedStateDesination.id;
		myCexpressFactory.ComputePacketAmount(quotationDatas);
    };
	
/******************************************************************************************/	

 /****  REQUETTE ASYNCHRONE PERMETTANT DE DETERMINER LE MONTANT CORRESPONDANT A UN COLIS **/
 
 /*****************************************************************************************/
 
 myCexpressFactory.ComputePacketAmount=function(quotationDatas){
    var fnSuccess=function(results){
	  data=angular.fromJson(results.data);
	  recapDatas=data;
	  var has_error=data[0].hasOwnProperty('error_msg');
	  myCexpressFactory.hasErrorsComputed=has_error;
	  if(data.length>0 && !has_error)
	  {
		$location.path('/quote_resume');
		myCexpressFactory.collectionAmount=data[data.length-1].TotalAmount;
		myCexpressFactory.freightQuoteData=quotationDatas;
	  }else{
	    quotationErrors=recapDatas;
	  }
	  
	};

	var fnfailure=function(results){
				
	};
			
	var promise=$http({ method:"GET",
						url:BASE_URL+"index.php/front/computePacketAmount",
					    params:{quotationDatas:quotationDatas}
					 });
    promise.then(fnSuccess, fnfailure);
 
 }
 
 myCexpressFactory.validateQuotation=function(){
    myCexpressFactory.packetQuotationData=myCexpressFactory.freightQuoteData;
	$location.path('/prov_pickup');
 }
 
 
/*************************************************************************************/	

 /****  REQUETTE RECUPERE LA LISTE DES MOYENS DE TRANSPORT            **/
 
 /***********************************************************************************/
    myCexpressFactory.getMeans=function(){
	
			var fnSuccess=function(results){
             means=angular.fromJson(results.data);					 
			};

			var fnfailure=function(results){
				
			};
			
			var promise=$http({ method:"GET",
								url:BASE_URL+"index.php/front/meansList",
							  });
			promise.then(fnSuccess, fnfailure);
	}
	
	
/*************************************************************************************/	

 /****  REQUETTE RECUPERE LA LISTE DES MOYENS DES ARTICLES CONNUS            **/
 
 /***********************************************************************************/
    myCexpressFactory.getArticles=function(){
	
			var fnSuccess=function(results){
			 myCexpressFactory.articles=angular.fromJson(results.data);			 
			};

			var fnfailure=function(results){
				
			};
			
			var promise=$http({ method:"GET",
								url:BASE_URL+"index.php/front/articlesList",
							  });
			promise.then(fnSuccess, fnfailure);
	}
	
/*********************************************************************************/
	
	/********* RECUPERATION DE L'ADDRESSE SELECTIONNEE DANS LE TABLEAU   *************/
	
	/*********************************************************************************/
	
	myCexpressFactory.selectPacket=function(address){
	  //myCexpressFactory.selectedPacket={Id:address.Id, CodePostal:address.CodePostal,AddressLine1:address.AddressLine1, Ville:address.Ville};
	}
	
/*************************************************************************************/	

 /****  REQUETTE ASYNCHRONE POUR RECUPER LE NOMBRE DE LIGNES DANS LA TABLE PAYS **/
 
 /***********************************************************************************/
	myCexpressFactory.getTabRowCount=function(tabname){
			 
			var fnSuccess=function(results){
			 myCexpressFactory.tabRowCount=angular.fromJson(results.data);			 
			};

			var fnfailure=function(results){
				
			};
			
			var promise=$http({ method:"GET",
								url:BASE_URL+"index.php/front/counttablerow",
								params:{tabname:tabname}
							  });
			promise.then(fnSuccess, fnfailure);
	}
	
	
	/*********************************************************************************/
	
	/********* RECUPERATION DE LA LISTE DES SERVICES **************/
	
	/**********************************************************************************/
	
	myCexpressFactory.getServices=function(){
	
			var fnSuccess=function(results){
             services=angular.fromJson(results.data);					 
			};

			var fnfailure=function(results){
				console.log('Une erreur produite');
			};
			
			var promise=$http({
                     			 headers: {'Content-Type': 'application/x-www-form-urlencoded'},
								method:"GET",
								url:BASE_URL+"index.php/front/servicesList",
							  });
			promise.then(fnSuccess, fnfailure);
	}
	
	/*********************************************************************************/
	
	/********* RECUPERATION DE LA LISTE DES VILLES **************/
	
	/**********************************************************************************/
	
	myCexpressFactory.getCities=function(){
	
			var fnSuccess=function(results){
			 myCexpressFactory.cities=angular.fromJson(results.data);			 
			};

			var fnfailure=function(results){
				
			};
			
			var promise=$http({ method:"GET",
								url:BASE_URL+"index.php/front/cities",
							  });
			promise.then(fnSuccess, fnfailure);
	}
	
	
	/*********************************************************************************/
	
	/********* RECUPERATION DE LA LISTE DES PAYS **************/
	
	/**********************************************************************************/
	
    myCexpressFactory.getStates=function(){
	
			var fnSuccess=function(results){
			 states=angular.fromJson(results.data);			 
			};

			var fnfailure=function(results){
				
			};
			
			var promise=$http({ method:"GET",
								url:BASE_URL+"index.php/front/states",
							  });
			promise.then(fnSuccess, fnfailure);
	}
	
	
	

	
	/************************************************************************************************/
	
	/*****             VALIDATION DU FORMULAIRE DE PREPARATION D'UN ENLEVEMENT              *********/
	/*****             PAR L'UTILISATEUR AFIN QUE SON FREIGHT SOIT EVALUE                   *********/
	
	
	/*************************************************************************************************/
	
	
    myCexpressFactory.planePickup = function() {
		myCexpressFactory.SetupShipmentPickup();
		myCexpressFactory.stapeValue=4;
		$location.path('/pickup_resume')
    };
	
	/************************************************************************************************/
	
	/*****             MET AJOUT L'AFFICHAGE DU FIELDSET DES DETAILS COLIS                  *********/
	
	
	/*************************************************************************************************/
	
	
    myCexpressFactory.updateDetailsDisplay = function(piece) {
		if(piece.ArticleID>1)
		{
		  piece.displayed="none";
		}else{
		  piece.displayed="inline-block";
		}
    };
	
	
	myCexpressFactory.trackPacket=function(packet){
	  myCexpressFactory.packet=packet;
	  myCexpressFactory.RequestTrack(packet);
	};
	
	
	/*********************************************************************************/
	
	/************************ AJOUT D'UNE PIECE VIDE  *********************************/
	
	/***********************************************************************************/
	myCexpressFactory.addAPiece=function(){
	   pieces.push({Designation:"",ArticleID:1,Weight:0.0,lenght:0.0,width:0.0, height:0.0, bntadd:"false"});
	};
	
	myCexpressFactory.addAquotationPieces=function(){
	   quotationPieces.push({Designation:"",ArticleID:1,Weight:0.0,lenght:0.0,width:0.0, height:0.0, bntadd:"false"});
	};
	
	
	myCexpressFactory.removeAPiece=function(piece){
	     var index = pieces.indexOf(piece);
         pieces.splice(index, 1);
	};
	
	myCexpressFactory.removeAquotationPieces=function(piece){
	     var index = quotationPieces.indexOf(piece);
         quotationPieces.splice(index, 1);
	};
	
	
	/***********************************************************************************************************/
	
	/************************ VALIDATION COTE CLIENT DES PIECES QUI COMPOSENT LE COLIS  ************************/
	
	/***********************************************************************************************************/
	
	myCexpressFactory.isPiecesValid=function(){
	   var isPiecesValid =true;
		angular.forEach(pieces, function(value, key) {
		  var isCurrentValue=false;
		  if(value.ArticleID==1){
			var isCurrentValue=false;
			if(value.Weight>0 && value.lenght>0 && value.width>0 && value.height>0)
			 isCurrentValue=true;
		  }else if(value.ArticleID>1){
			  isCurrentValue=true;
		  }
		  isPiecesValid=isPiecesValid && isCurrentValue; 
		});
		return isPiecesValid; 
	}
	
	myCexpressFactory.isquotationPiecesValid=function(){
	   var isPiecesValid =true;
		angular.forEach(quotationPieces, function(value, key) {
		  var isCurrentValue=false;
		  if(value.ArticleID==1){
			var isCurrentValue=false;
			if(value.Weight>0 && value.lenght>0 && value.width>0 && value.height>0)
			 isCurrentValue=true;
		  }else if(value.ArticleID>1){
			  isCurrentValue=true;
		  }
		  isPiecesValid=isPiecesValid && isCurrentValue; 
		});
		return isPiecesValid; 
	}
	
	myCexpressFactory.isErrorsExists=function(){
	  return myCexpressFactory.hasErrorsComputed;
	}
	
	
	
	
	/*********************************************************************************/
	
	/************************ AJOUT DE LA LISTE DES AU FACTORY  ************************/
	
	/***********************************************************************************/
	
    myCexpressFactory.states = function() {
        return states ;
    };
	
	myCexpressFactory.means=function(){
	  return means;
	};
	
	myCexpressFactory.services=function(){
	  return services;
	};
	
	
	myCexpressFactory.recapDataList = function() {
        return recapDatas;
    };
	
	myCexpressFactory.trackedDataList = function() {
        return trackingDetails;
    };
	
	myCexpressFactory.tranckingHistoriQ = function() {
        return historiQue;
    };
	
	
	
	myCexpressFactory.quotationResulttaList = function() {
        return quotationResult;
    };
	
	myCexpressFactory.quotationErrorsList = function() {
        return quotationErrors;
    };
	
	
	myCexpressFactory.serviceChanged=function(selectedService, page){
		for(i=0; i<myCexpressFactory.services.length;i++)
		{
		      if(page==2){
				if(myCexpressFactory.services[i].ServiceID==selectedService.ServiceID){
				   myCexpressFactory.selectedService.ServiceID=myCexpressFactory.services[i].ServiceID;
				   myCexpressFactory.selectedService.ServiceName=myCexpressFactory.services[i].ServiceName;
		        }
			  }else{
      			  if(myCexpressFactory.services[i].ServiceID==quotationSelectedService.ServiceID){
			       myCexpressFactory.quotationSelectedService.ServiceID=myCexpressFactory.services[i].ServiceID;
				   myCexpressFactory.quotationSelectedService.ServiceName=myCexpressFactory.services[i].ServiceName;
				  }
			  }
		}
	}
	
	myCexpressFactory.meansChanged=function(selectedMeans, page){
		for(i=0; i<myCexpressFactory.means.length;i++)
	   {
	           if(page==2){
				if(myCexpressFactory.means[i].MeansID==selectedMeans.MeansID){
				   myCexpressFactory.selectedMeans.MeansID=myCexpressFactory.means[i].MeansID;
				   myCexpressFactory.selectedMeans.Designation=myCexpressFactory.means[i].Designation;
		        }
			  }else{
				  if(myCexpressFactory.means[i].MeansID==quotationSelectedMeans.MeansID){
				    myCexpressFactory.quotationSelectedMeans.MeansID=myCexpressFactory.means[i].MeansID;
				    myCexpressFactory.quotationSelectedMeans.Designation=myCexpressFactory.means[i].Designation;
				  }
			  }
		}
	}
	
	myCexpressFactory.originChanged=function(selectedStateOrigin, page){
	  for(i=0; i<myCexpressFactory.states.length;i++){
	         if(page==2){
				if(myCexpressFactory.states[i].id==selectedStateOrigin.id){
				   myCexpressFactory.selectedStateOrigin.id=myCexpressFactory.states[i].id;
				   myCexpressFactory.selectedStateOrigin.nom_fr_fr=myCexpressFactory.states[i].nom_fr_fr;
		        }
			  }else{
			     if(myCexpressFactory.states[i].id==quotationSelectedStateOrigin.id){
				   myCexpressFactory.quotationSelectedStateOrigin.id=myCexpressFactory.states[i].id;
				   myCexpressFactory.quotationSelectedStateOrigin.nom_fr_fr=myCexpressFactory.states[i].nom_fr_fr;
		        }
			  }
	  }
	};
	
	myCexpressFactory.desinationChanged=function(selectedStateDesination, page){
	  for(i=0; i<myCexpressFactory.states.length;i++){
	           if(page==2){
				if(myCexpressFactory.states[i].id==selectedStateDesination.id){
				   myCexpressFactory.selectedStateDesination.id=myCexpressFactory.states[i].id;
				   myCexpressFactory.selectedStateDesination.nom_fr_fr=myCexpressFactory.states[i].nom_fr_fr;
		        }
			  }else{
			     if(myCexpressFactory.states[i].id==quotationSelectedStateDesination.id){
				   myCexpressFactory.quotationSelectedStateDesination.id=myCexpressFactory.states[i].id;
				   myCexpressFactory.quotationSelectedStateDesination.nom_fr_fr=myCexpressFactory.states[i].nom_fr_fr;
		        }
			  }
	  }
	};
	
	
	myCexpressFactory.pieces = function() {
        return pieces;
    };
	
	myCexpressFactory.quotationPieces = function() {
        return quotationPieces;
    };
	
	
	
    return myCexpressFactory;
});


/*********************************************************************************µ**********/
	
/**********  REPRESENTE LE CONTROLLEUR QUI GERE LA MISE EN PLACE D'UN ENLEVEMENT  ***********/
	
/*******************************************************************************************/

	
	myApp.controller('packetController', function($scope, ngCart, cexpress){						
	   ngCart.setTaxRate(7.5);
       ngCart.setShipping(2.99); 
	   ngCart.empty();
	   cexpress.currentSelectedPage=1;
	   cexpress.getServices();
	   cexpress.getMeans();
	   cexpress.getArticles();
	   cexpress.getTabRowCount("customers");
	   cexpress.getStates();
	   cexpress.getCities(); 	   
	   $scope.packets=cexpress;
	});
	
	
/*********************************************************************************************/
	
/**********  REPRESENTE LE CONTROLLEUR QUI GERE LE SUIVI D'UN COLIS  *************************/
	
/*********************************************************************************************/

	myApp.controller('trackingPacketCtrl', function($scope, cexpress){
	   cexpress.getServices();
	   $scope.packetStatusData=cexpress;
	});