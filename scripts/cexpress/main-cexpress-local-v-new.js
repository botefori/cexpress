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


myApp.factory('Cexpress', function($http,$location) {
	var tabRowCount=[];	
	
	
	
	var getMeans=function(getmeansCallbackFn){
	        var currentmeans;
			var fnSuccess=function(results){
			  currentmeans=angular.fromJson(results.data);			 
			};

			fnfailure=function(results){
				
			};
			
			var promise=$http({ method:"GET",
								url:BASE_URL+"front/meansList",
							  });
			promise.then(fnSuccess, fnfailure);
			return currentmeans;
	};
	
	var getStates=function(){
	
			var fnSuccess=function(results){
			   states=angular.fromJson(results.data);			 
			};

			var fnfailure=function(results){
				
			};
			
			var promise=$http({ method:"GET",
								url:BASE_URL+"front/states",
							  });
			promise.then(fnSuccess, fnfailure);
	};
	
	var getArticles=function(){
	
			var fnSuccess=function(results){
			  articles=angular.fromJson(results.data);			 
			};

			var fnfailure=function(results){
				
			};
			
			var promise=$http({ method:"GET",
								url:BASE_URL+"front/articlesList",
							  });
			promise.then(fnSuccess, fnfailure);
	};
	
	var getServices=function(){
	
			var fnSuccess=function(results){
			  services=angular.fromJson(results.data);			 
			};

			var fnfailure=function(results){
				
			};
			
			var promise=$http({ method:"GET",
								url:BASE_URL+"front/servicesList",
							  });
			promise.then(fnSuccess, fnfailure);
	};
	
	var getCities=function(){
	
			var fnSuccess=function(results){
			 cities=angular.fromJson(results.data);			 
			};

			var fnfailure=function(results){
				
			};
			
			var promise=$http({ method:"GET",
								url:BASE_URL+"front/cities",
							  });
			promise.then(fnSuccess, fnfailure);
	};
	
	
	
/***********************************************************************************/

/*********************      CONSTRUCTOR        ************************************/
	
/***********************************************************************************/

function Cexpress(){
 this.pieces= [] || this.pieces;
 this.recapDatas=this.recapDatas || [];
 this.quotationResult=[] || this.quotationResult;
 this.quotationErrors=[] || this.quotationErrors;
 this.trackedData=[] || this.trackedData;
 this.trackerrormessage="";
 this.hasErrorsComputed=false;
 this.stapeValue=2;
 this.collectionAmount=0;
 this.packetStatus="";
 this.dispTotalAmount="none";
 this.dispFormsTag="block";
 this.master={};
 this.packetOrigin=this.packetOrigin || {};
 this.packetDestination={} || this.packetDestination;
 this.packetQuotationData={} || this.packetQuotationData;
 this.selectedService={ServiceID:"", ServiceName:""};
 this.selectedMeans={MeansID:"", Designation:""};
 this.selectedStateOrigin={id:"", nom_fr_fr:""};
 this.selectedStateDesination={id:"", nom_fr_fr:""};
 this.shipmentData={packetQuotationData:"",packetOrigin:"", packetDestination:"",pieces:""};
 this.pieces.push({Designation:"",ArticleID:1,Weight:0.00,lenght:0.00,width:0.00, height:0.00, bntadd:"true",displayed:""});
 this.means=getMeans();
 this.services=getServices();
 this.articles=getArticles();
 this.states=getStates();
}

/****************************************************************************************/

/*********************      STATIC PROPERTIES        ************************************/
	
/*****************************************************************************************/

Cexpress.settings={paypal:undefined};
Cexpress.settings.paypal={business:"berngue-facilitator@hotmail.fr",currency_code:"EUR"};
Cexpress.displayDetails="fieldset_displaynone";


/***********************************************************************************/

/*********************      PROTOTYPE        ***************************************/
	
/***********************************************************************************/

Cexpress.prototype={
	services: {} || services,
	states: {}  || states,
    planePickup : function(packetsPickupData) {
		this.packetsPickupData=packetsPickupData;
		this.SetupShipmentPickup(packetsPickupData);
		this.stapeValue=4;
		$location.path('/pickup_resume')
    },
	
	makeQuotation : function() {
	    var quotationDatas={};
	    quotationDatas.pieces=this.pieces;
	    quotationDatas.ServiceID=this.selectedService.ServiceID;
		quotationDatas.MeansID=this.selectedMeans.MeansID;
		quotationDatas.consignorState=this.selectedStateOrigin.id;
		quotationDatas.consigneeState=this.selectedStateDesination.id;
		this.freightQuoteData=quotationDatas;
		this.ComputePacketAmount(quotationDatas);
    },
	
	serviceChanged : function(selectedService){
		for(i=0; i<services.length;i++)
		{
				if(services[i].ServiceID==selectedService.ServiceID){
				   this.selectedService.ServiceID=services[i].ServiceID;
				   this.selectedService.ServiceName=services[i].ServiceName;
		        }
		}
	},
	
	meansChanged : function(selectedMeans){
		for(i=0; i<means.length;i++)
		{
				if(means[i].MeansID==this.selectedMeans.MeansID){
				   this.selectedMeans.MeansID=means[i].MeansID;
				   this.selectedMeans.Designation=means[i].Designation;
		        }
		}
	},
	
	originChanged : function(selectedStateOrigin){
	  for(i=0; i<states.length;i++){
				if(states[i].id==this.selectedStateOrigin.id){
				   this.selectedStateOrigin.id=states[i].id;
				   this.selectedStateOrigin.nom_fr_fr=states[i].nom_fr_fr;
		        }
	  }
	},
	
	desinationChanged : function(selectedStateDesination){
	  for(i=0; i<states.length;i++){
				if(states[i].id==this.selectedStateDesination.id){
				   this.selectedStateDesination.id=states[i].id;
				   this.selectedStateDesination.nom_fr_fr=states[i].nom_fr_fr;
		        }
	  }
	 },
	  
	setupShipmentPickup : function(packetDestination){
			this.shipmentData.packetOrigin=this.packetOrigin;
			this.shipmentData.packetDestination=packetDestination;
			this.shipmentData.packetQuotationData=this.packetQuotationData;
			
			
			var fnSuccess=function(results){
				data=angular.fromJson(results.data);
				recapDatas=data;
				this.collectionAmount=data[0].AmountCollection;
				if(data.length>0)
			    {
				 $location.path('/pickup_resume');
				 this.stapeValue=4;
			    }
				this.pieces=[];
				this.pieces.push({Designation:"",ArticleID:1,Weight:0.00,lenght:0.00,width:0.00, height:0.00, bntadd:"true"});
			};

			var fnfailure=function(results){
				
			};
			
			var promise=$http({ method:"GET",
								url:BASE_URL+"front/addAsynchronousShipment",
								params:{shipmentData:shipmentData}
							  });
			promise.then(fnSuccess, fnfailure);
	},
	 
	ComputePacketAmount : function(quotationDatas){
		var fnSuccess=function(results){
		  data=angular.fromJson(results.data);
		  recapDatas=data;
		  var has_error=data[0].hasOwnProperty('error_msg');
		  this.hasErrorsComputed=has_error;
		  if(data.length>0 && !has_error)
		  {
			$location.path('/pickup_resume');
			this.collectionAmount=data[data.length-1].TotalAmount;
			angular.copy(this.master,this.freightQuoteData);
			this.pieces=[];
			this.pieces.push({Designation:"",ArticleID:1,Weight:0.00,lenght:0.00,width:0.00, height:0.00, bntadd:"true"});
		  }else{
			this.quotationErrors=recapDatas;
		  }
		  
		};

		var fnfailure=function(results){
					
		};
				
		var promise=$http({ method:"GET",
							url:BASE_URL+"front/computePacketAmount",
							params:{quotationDatas:quotationDatas}
						 });
		promise.then(fnSuccess, fnfailure);
 
    },
	
	
	
	
	isPiecesValid : function(){
	   var isPiecesValid =true;
		angular.forEach(this.pieces, function(value, key) {
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
	},
	
	isErrorsExists : function(){
	  return this.hasErrorsComputed;
	},
	
	updateDetailsDisplay : function(piece) {
		if(piece.ArticleID>1)
		{
		  piece.displayed="none";
		}else{
		  piece.displayed="inline-block";
		}
    },
	
	addAPiece : function(){
	   this.pieces.push({Designation:"",ArticleID:1,Weight:0.0,lenght:0.0,width:0.0, height:0.0, bntadd:"false"});
	},
	
	removeAPiece : function(piece){
	     var index = this.pieces.indexOf(piece);
         this.pieces.splice(index, 1);
	},
	
	setOrigin : function(packetOrigin){
	   this.packetOrigin=packetOrigin;
	   $location.path('/dest_pickup');
	   this.stapeValue=3;
	},
	
	setDestination : function(packetDestination){
	  this.packetDestination=packetDestination;
	},
	
   setQuotationData : function(){
		 var quotationDatas={};
			 quotationDatas.pieces=this.pieces;
			 quotationDatas.ServiceID=this.selectedService.ServiceID;
			 quotationDatas.MeansID=this.selectedMeans.MeansID;
			 quotationDatas.consignorState=this.selectedStateOrigin.id;
			 quotationDatas.consigneeState=this.selectedStateDesination.id;
		var fnSuccess=function(results){
		  data=angular.fromJson(results.data);
		  var has_error=data[0].hasOwnProperty('error_msg');
		   this.hasErrorsComputed=has_error;
		  if(data.length>0 && !has_error)
		  {
			this.packetQuotationData=quotationDatas;
			$location.path('/prov_pickup');
			this.stapeValue=3;
		  }else{
			this.quotationErrors=data;
		  }
		  
		};

		var fnfailure=function(results){
					
		};
				
		var promise=$http({ method:"GET",
							url:BASE_URL+"front/computePacketAmount",
							params:{quotationDatas:quotationDatas}
						 });
		promise.then(fnSuccess, fnfailure);
	  
	},
	
	requestTrack : function(packetTracked){
	   var fnSuccess=function(results){
										data=angular.fromJson(results.data);
										trackedData=data;	
										if(data.length>0 && !trackedData[0].hasOwnProperty('dbError')){
											this.collectionAmount=trackedData[0].AmountCollection;
											this.packetStatus=trackedData[0].DesignationStatus;
											this.dispTotalAmount="block";
											this.trackerrormessage=undefined;
										}else{
										  this.dispTotalAmount="block";
										  this.collectionAmount=undefined;
										  this.packetStatus=undefined;
										  this.trackerrormessage=trackedData.dbError;
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
	},
	
	getTabRowCount : function(tabname){
			 
			var fnSuccess=function(results){
			  tabRowCount=angular.fromJson(results.data);			 
			};

			var fnfailure=function(results){
				
			};
			
			var promise=$http({ method:"GET",
								url:BASE_URL+"front/counttablerow",
								params:{tabname:tabname}
							  });
			promise.then(fnSuccess, fnfailure);
	},
	
	trackPacket : function(packet){
	  this.packet=packet;
	  requestTrack(packet);
	},
	
	recapDataList : function() {
        return recapDatas;
    },
	
	states : function() {
        return states ;
    },
	
	
	trackedDataList : function() {
        return trackedData;
    },
	
	quotationResulttaList : function() {
        return quotationResult;
    },
	
	quotationErrorsList : function() {
        return this.quotationErrors;
    },
	
	pieces : function() {
        return this.pieces;
    },
}

    return (Cexpress);
});


/*******************************************************************************************/
	
/**********  REPRESENTE LE CONTROLLEUR QUI GERE LA MISE EN PLACE D'UN ENLEVEMENT  ***********/
	
/*******************************************************************************************/

	
	myApp.controller('packetController', function($scope, ngCart, Cexpress){						
	   ngCart.setTaxRate(7.5);
       ngCart.setShipping(2.99); 
	   ngCart.empty();
	   var express=new Cexpress();
	   /*express.getServices();
	   express.getArticles();
	   express.getTabRowCount("customers");
	   express.getStates();
	   express.getCities(); */ 
	   $scope.packets=express;
	});
	
/*****************************************************************************************/
	
/**********  REPRESENTE LE CONTROLLEUR QUI GERE L'ESTIMATION DU COUP D'UN FREIGHT  ***********/
	
/*********************************************************************************************/

	myApp.controller('freightCtrl', function($scope){
	   
	});
	
/*********************************************************************************************/
	
/**********  REPRESENTE LE CONTROLLEUR QUI GERE LE SUIVI D'UN COLIS  *************************/
	
/*********************************************************************************************/

	myApp.controller('trackingPacketCtrl', function($scope, cexpress){
	   //cexpress.getServices();
	   //$scope.packetStatusData=cexpress;
	});