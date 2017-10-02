var myApp=angular.module('myApp', ['ngRoute','ngCart','ngCart.fulfilment']);

myApp.config(function($routeProvider){
   $routeProvider.when('/', {controller:ListCtrl,templateUrl:BASE_URL+'front/helloworld'});
   $routeProvider.when('/prov_pickup', {controller:ListCtrl,templateUrl:BASE_URL+'front/prov_pickup'});
   $routeProvider.when('/pickup_resume', {controller:ListCtrl,templateUrl:BASE_URL+'front/pickup_resume'});
   $routeProvider.when('/dest_pickup', {controller:ListCtrl,templateUrl:BASE_URL+'front/dest_pickup'});
   $routeProvider.when('/quote_pickup', {controller:ListCtrl,templateUrl:BASE_URL+'front/quote_pickup'});
   $routeProvider.when('/request_quote', {controller:ListCtrl,templateUrl:BASE_URL+'front/request_quotation'});
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
	var pieces=[];
	var recapDatas=[];
	var quotationResult=[];
	var quotationErrors=[];
	var trackedData=[];
	var shipmentData={packetQuotationData:"",packetOrigin:"", packetDestination:"",pieces:""};
	pieces.push({Designation:"",ArticleID:1,Weight:0.00,lenght:0.00,width:0.00, height:0.00, bntadd:"true",displayed:""});
	
	
	
	myCexpressFactory.packetOrigin;
	myCexpressFactory.packetDestination;
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
	
	myCexpressFactory.displayDetails="fieldset_displaynone";
/***********************************************************************************/

/*********************      VARIABLES GLOBALES          ****************************/
	
/***********************************************************************************/

	myCexpressFactory.currentSelectedPage=0;
	myCexpressFactory.tabRowCount=[];
	
/*************************************************************************************/	

 /****  REQUETTE ASYNCHRONE PERMETTANT DE CONFIGURER LES DONNEES D'UN ENLEVMENT ******/
 
 /***********************************************************************************/
    myCexpressFactory.setOrigin=function(packetOrigin){
	   myCexpressFactory.packetOrigin=packetOrigin;
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
						url:BASE_URL+"front/computePacketAmount",
					    params:{quotationDatas:quotationDatas}
					 });
    promise.then(fnSuccess, fnfailure);
	  
	}
	
	
	myCexpressFactory.SetupShipmentPickup=function(packetDestination){
			shipmentData.packetOrigin=myCexpressFactory.packetOrigin;
			shipmentData.packetDestination=packetDestination;
			shipmentData.packetQuotationData=myCexpressFactory.packetQuotationData;
			
			
			var fnSuccess=function(results){
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
				
			};
			
			var promise=$http({ method:"GET",
								url:BASE_URL+"front/addAsynchronousShipment",
								params:{shipmentData:shipmentData}
							  });
			promise.then(fnSuccess, fnfailure);
	}
	
	myCexpressFactory.RequestTrack=function(packetTracked){
	   var fnSuccess=function(results){
										data=angular.fromJson(results.data);
										trackedData=data;	
										if(data.length>0 && !trackedData[0].hasOwnProperty('dbError')){
											myCexpressFactory.collectionAmount=trackedData[0].AmountCollection;
											myCexpressFactory.packetStatus=trackedData[0].DesignationStatus;
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
							 url:BASE_URL+"front/getPacketStatus",
							 params:{packetTracked:packetTracked}
						  });
	    
		promise.then(fnSuccess, fnfailure);
	}
	
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
		$location.path('/pickup_resume');
		myCexpressFactory.collectionAmount=data[data.length-1].TotalAmount;
	    angular.copy(myCexpressFactory.master,myCexpressFactory.freightQuoteData);
	    pieces=[];
	    pieces.push({Designation:"",ArticleID:1,Weight:0.00,lenght:0.00,width:0.00, height:0.00, bntadd:"true"});
	  }else{
	    quotationErrors=recapDatas;
	  }
	  
	};

	var fnfailure=function(results){
				
	};
			
	var promise=$http({ method:"GET",
						url:BASE_URL+"front/computePacketAmount",
					    params:{quotationDatas:quotationDatas}
					 });
    promise.then(fnSuccess, fnfailure);
 
 }
 
/*************************************************************************************/	

 /****  REQUETTE RECUPERE LA LISTE DES MOYENS DE TRANSPORT            **/
 
 /***********************************************************************************/
    myCexpressFactory.getMeans=function(){
	
			var fnSuccess=function(results){
			 myCexpressFactory.means=angular.fromJson(results.data);			 
			};

			var fnfailure=function(results){
				
			};
			
			var promise=$http({ method:"GET",
								url:BASE_URL+"front/meansList",
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
								url:BASE_URL+"front/articlesList",
							  });
			promise.then(fnSuccess, fnfailure);
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
								url:BASE_URL+"front/counttablerow",
								params:{tabname:tabname}
							  });
			promise.then(fnSuccess, fnfailure);
	}
	
	
	/*********************************************************************************/
	
	/********* RECUPERATION DE LA LISTE DES SERVICES **************/
	
	/**********************************************************************************/
	
	myCexpressFactory.getServices=function(){
	
			var fnSuccess=function(results){
			 myCexpressFactory.services=angular.fromJson(results.data);			 
			};

			var fnfailure=function(results){
				
			};
			
			var promise=$http({ method:"GET",
								url:BASE_URL+"front/servicesList",
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
								url:BASE_URL+"front/cities",
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
								url:BASE_URL+"front/states",
							  });
			promise.then(fnSuccess, fnfailure);
	}
	
	
	/***********************************************************************************************/
	
	/*****    VALIDATION DU FORMULAIRE DE QUOTATION PAR L'UTILISATEUR AFIN QUE SON FREIGHT SOIT EVALUE  *********/
	
	
	/**********************************************************************************************/
	
	
    myCexpressFactory.makeQuotation = function() {
	    var quotationDatas={};
	    quotationDatas.pieces=pieces;
	    quotationDatas.ServiceID=myCexpressFactory.selectedService.ServiceID;
		quotationDatas.MeansID=myCexpressFactory.selectedMeans.MeansID;
		quotationDatas.consignorState=myCexpressFactory.selectedStateOrigin.id;
		quotationDatas.consigneeState=myCexpressFactory.selectedStateDesination.id;
		myCexpressFactory.freightQuoteData=quotationDatas;
		myCexpressFactory.ComputePacketAmount(quotationDatas);
    };
	
	/************************************************************************************************/
	
	/*****             VALIDATION DU FORMULAIRE DE PREPARATION D'UN ENLEVEMENT              *********/
	/*****             PAR L'UTILISATEUR AFIN QUE SON FREIGHT SOIT EVALUE                   *********/
	
	
	/*************************************************************************************************/
	
	
    myCexpressFactory.planePickup = function(packetsPickupData) {
		myCexpressFactory.packetsPickupData=packetsPickupData;
		myCexpressFactory.SetupShipmentPickup(packetsPickupData);
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
	
	myCexpressFactory.isErrorsExists=function(){
	  return myCexpressFactory.hasErrorsComputed;
	}
	
	myCexpressFactory.removeAPiece=function(piece){
	     var index = pieces.indexOf(piece);
         pieces.splice(index, 1);
	};
	
	
	/*********************************************************************************/
	
	/************************ AJOUT DE LA LISTE DES AU FACTORY  ************************/
	
	/***********************************************************************************/
	
    myCexpressFactory.states = function() {
        return states ;
    };
	
	myCexpressFactory.recapDataList = function() {
        return recapDatas;
    };
	
	myCexpressFactory.trackedDataList = function() {
        return trackedData;
    };
	
	
	
	myCexpressFactory.quotationResulttaList = function() {
        return quotationResult;
    };
	
	myCexpressFactory.quotationErrorsList = function() {
        return quotationErrors;
    };
	
	
	myCexpressFactory.serviceChanged=function(selectedService){
		for(i=0; i<myCexpressFactory.services.length;i++)
			 {
				if(myCexpressFactory.services[i].ServiceID==selectedService.ServiceID){
				   myCexpressFactory.selectedService.ServiceID=myCexpressFactory.services[i].ServiceID;
				   myCexpressFactory.selectedService.ServiceName=myCexpressFactory.services[i].ServiceName;
		    }
		}
	}
	
	myCexpressFactory.meansChanged=function(selectedMeans){
		for(i=0; i<myCexpressFactory.means.length;i++)
			 {
				if(myCexpressFactory.means[i].MeansID==selectedMeans.MeansID){
				   myCexpressFactory.selectedMeans.MeansID=myCexpressFactory.means[i].MeansID;
				   myCexpressFactory.selectedMeans.Designation=myCexpressFactory.means[i].Designation;
		    }
		}
	}
	
	myCexpressFactory.originChanged=function(selectedStateOrigin){
	  for(i=0; i<myCexpressFactory.states.length;i++){
				if(myCexpressFactory.states[i].id==selectedStateOrigin.id){
				   myCexpressFactory.selectedStateOrigin.id=myCexpressFactory.states[i].id;
				   myCexpressFactory.selectedStateOrigin.nom_fr_fr=myCexpressFactory.states[i].nom_fr_fr;
		        }
	  }
	};
	
	myCexpressFactory.desinationChanged=function(selectedStateDesination){
	  for(i=0; i<myCexpressFactory.states.length;i++){
				if(myCexpressFactory.states[i].id==selectedStateDesination.id){
				   myCexpressFactory.selectedStateDesination.id=myCexpressFactory.states[i].id;
				   myCexpressFactory.selectedStateDesination.nom_fr_fr=myCexpressFactory.states[i].nom_fr_fr;
		        }
	  }
	};
	
	
	myCexpressFactory.pieces = function() {
        return pieces;
    };
	
    return myCexpressFactory;
});


myApp.factory('quotationService', function($http,$location) {
/***********************************************************************************/

/*********************      VARIABLES GLOBALES          ****************************/
	
/***********************************************************************************/
    var myCexpressFactory = {};
	var states=[];
	var pieces=[];
	var recapDatas=[];
	var quotationResult=[];
	var quotationErrors=[];
	var trackedData=[];
	pieces.push({Designation:"",ArticleID:1,Weight:0.00,lenght:0.00,width:0.00, height:0.00, bntadd:"true",displayed:""});
	
	
	
	myCexpressFactory.packetOrigin;
	myCexpressFactory.packetDestination;
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
	
	myCexpressFactory.displayDetails="fieldset_displaynone";
	
	
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
		$location.path('/pickup_resume');
		myCexpressFactory.collectionAmount=data[data.length-1].TotalAmount;
	    angular.copy(myCexpressFactory.master,myCexpressFactory.freightQuoteData);
	    pieces=[];
	    pieces.push({Designation:"",ArticleID:1,Weight:0.00,lenght:0.00,width:0.00, height:0.00, bntadd:"true"});
	  }else{
	    quotationErrors=recapDatas;
	  }
	  
	};

	var fnfailure=function(results){
				
	};
			
	var promise=$http({ method:"GET",
						url:BASE_URL+"front/computePacketAmount",
					    params:{quotationDatas:quotationDatas}
					 });
    promise.then(fnSuccess, fnfailure);
 
 }
 
/*************************************************************************************/	

 /****  REQUETTE RECUPERE LA LISTE DES MOYENS DE TRANSPORT            **/
 
 /***********************************************************************************/
    myCexpressFactory.getMeans=function(){
	
			var fnSuccess=function(results){
			 myCexpressFactory.means=angular.fromJson(results.data);			 
			};

			var fnfailure=function(results){
				
			};
			
			var promise=$http({ method:"GET",
								url:BASE_URL+"front/meansList",
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
								url:BASE_URL+"front/articlesList",
							  });
			promise.then(fnSuccess, fnfailure);
	}
	

	
	
	/*********************************************************************************/
	
	/********* RECUPERATION DE LA LISTE DES SERVICES **************/
	
	/**********************************************************************************/
	
	myCexpressFactory.getServices=function(){
	
			var fnSuccess=function(results){
			 myCexpressFactory.services=angular.fromJson(results.data);			 
			};

			var fnfailure=function(results){
				
			};
			
			var promise=$http({ method:"GET",
								url:BASE_URL+"front/servicesList",
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
								url:BASE_URL+"front/cities",
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
								url:BASE_URL+"front/states",
							  });
			promise.then(fnSuccess, fnfailure);
	}
	
	
	/***********************************************************************************************/
	
	/*****    VALIDATION DU FORMULAIRE DE QUOTATION PAR L'UTILISATEUR AFIN QUE SON FREIGHT SOIT EVALUE  *********/
	
	
	/**********************************************************************************************/
	
	
    myCexpressFactory.makeQuotation = function() {
	    var quotationDatas={};
	    quotationDatas.pieces=pieces;
	    quotationDatas.ServiceID=myCexpressFactory.selectedService.ServiceID;
		quotationDatas.MeansID=myCexpressFactory.selectedMeans.MeansID;
		quotationDatas.consignorState=myCexpressFactory.selectedStateOrigin.id;
		quotationDatas.consigneeState=myCexpressFactory.selectedStateDesination.id;
		myCexpressFactory.freightQuoteData=quotationDatas;
		myCexpressFactory.ComputePacketAmount(quotationDatas);
    };
	
	/************************************************************************************************/
	
	/*****             VALIDATION DU FORMULAIRE DE PREPARATION D'UN ENLEVEMENT              *********/
	/*****             PAR L'UTILISATEUR AFIN QUE SON FREIGHT SOIT EVALUE                   *********/
	
	
	/*************************************************************************************************/
	
	
    
	
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
	
	
	/*********************************************************************************/
	
	/************************ AJOUT D'UNE PIECE VIDE  *********************************/
	
	/***********************************************************************************/
	myCexpressFactory.addAPiece=function(){
	   pieces.push({Designation:"",ArticleID:1,Weight:0.0,lenght:0.0,width:0.0, height:0.0, bntadd:"false"});
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
	
	myCexpressFactory.isErrorsExists=function(){
	  return myCexpressFactory.hasErrorsComputed;
	}
	
	myCexpressFactory.removeAPiece=function(piece){
	     var index = pieces.indexOf(piece);
         pieces.splice(index, 1);
	};
	
	
	/*********************************************************************************/
	
	/************************ AJOUT DE LA LISTE DES AU FACTORY  ************************/
	
	/***********************************************************************************/
	
    myCexpressFactory.states = function() {
        return states ;
    };
	
	myCexpressFactory.recapDataList = function() {
        return recapDatas;
    };
	
	myCexpressFactory.trackedDataList = function() {
        return trackedData;
    };
	
	
	
	myCexpressFactory.quotationResulttaList = function() {
        return quotationResult;
    };
	
	myCexpressFactory.quotationErrorsList = function() {
        return quotationErrors;
    };
	
	
	myCexpressFactory.serviceChanged=function(selectedService){
		for(i=0; i<myCexpressFactory.services.length;i++)
			 {
				if(myCexpressFactory.services[i].ServiceID==selectedService.ServiceID){
				   myCexpressFactory.selectedService.ServiceID=myCexpressFactory.services[i].ServiceID;
				   myCexpressFactory.selectedService.ServiceName=myCexpressFactory.services[i].ServiceName;
		    }
		}
	}
	
	myCexpressFactory.meansChanged=function(selectedMeans){
		for(i=0; i<myCexpressFactory.means.length;i++)
			 {
				if(myCexpressFactory.means[i].MeansID==selectedMeans.MeansID){
				   myCexpressFactory.selectedMeans.MeansID=myCexpressFactory.means[i].MeansID;
				   myCexpressFactory.selectedMeans.Designation=myCexpressFactory.means[i].Designation;
		    }
		}
	}
	
	myCexpressFactory.originChanged=function(selectedStateOrigin){
	  for(i=0; i<myCexpressFactory.states.length;i++){
				if(myCexpressFactory.states[i].id==selectedStateOrigin.id){
				   myCexpressFactory.selectedStateOrigin.id=myCexpressFactory.states[i].id;
				   myCexpressFactory.selectedStateOrigin.nom_fr_fr=myCexpressFactory.states[i].nom_fr_fr;
		        }
	  }
	};
	
	myCexpressFactory.desinationChanged=function(selectedStateDesination){
	  for(i=0; i<myCexpressFactory.states.length;i++){
				if(myCexpressFactory.states[i].id==selectedStateDesination.id){
				   myCexpressFactory.selectedStateDesination.id=myCexpressFactory.states[i].id;
				   myCexpressFactory.selectedStateDesination.nom_fr_fr=myCexpressFactory.states[i].nom_fr_fr;
		        }
	  }
	};
	
	
	myCexpressFactory.pieces = function() {
        return pieces;
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
	
/*****************************************************************************************/
	
/**********  REPRESENTE LE CONTROLLEUR QUI GERE L'ESTIMATION DU COUP D'UN FREIGHT  ***********/
	
/*********************************************************************************************/

	myApp.controller('freightCtrl', function($scope, quotationService){
	   quotationService.getServices();
	   quotationService.getArticles();
	   quotationService.getMeans();
	   quotationService.getStates();
	   $scope.freights=quotationService;
	});
	
/*********************************************************************************************/
	
/**********  REPRESENTE LE CONTROLLEUR QUI GERE LE SUIVI D'UN COLIS  *************************/
	
/*********************************************************************************************/

	myApp.controller('trackingPacketCtrl', function($scope, cexpress){
	   cexpress.getServices();
	   $scope.packetStatusData=cexpress;
	});