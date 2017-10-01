var myApp=angular.module('myApp', ['ngRoute']);

myApp.factory('cexpress', function($http) {
    var myCexpressFactory = {};
	var states=[];
	var pieces=[];
	var recapDatas=[];
	pieces.push({Designation:"",ArticleID:1,Weight:0.00,lenght:0.00,width:0.00, height:0.00, bntadd:"true",displayed:""});
	
	
	myCexpressFactory.selectestate={};
	myCexpressFactory.collectionAmount=0;
	myCexpressFactory.master={};
	myCexpressFactory.displayDetails="fieldset_displaynone";
/***********************************************************************************/

/*********************      VARIABLES GLOBALES          ****************************/
	
/***********************************************************************************/

	myCexpressFactory.currentSelectedPage=0;
	myCexpressFactory.tabRowCount=[];
	
/*************************************************************************************/	

 /****  REQUETTE ASYNCHRONE PERMETTANT DE CONFIGURER LES DONNEES D'UN ENLEVMENT **/
 
 /***********************************************************************************/
	myCexpressFactory.SetupShipmentPickup=function(shipmentData){
			shipmentData.pieces=pieces;
			var fnSuccess=function(results){
				data=angular.fromJson(results.data);
				recapDatas=data;
				myCexpressFactory.collectionAmount=data[1].AmountCollection;
				angular.copy(myCexpressFactory.master,myCexpressFactory.packetsPickupData);
				pieces=[];
				pieces.push({Designation:"",ArticleID:1,Weight:0.00,lenght:0.00,width:0.00, height:0.00, bntadd:"true"});
			};

			var fnfailure=function(results){
				
			};
			
			var promise=$http({ method:"GET",
								url:"http://www.courrierexpress.hol.es/front/addAsynchronousShipment",
								params:{shipmentData:shipmentData}
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
								url:"http://www.courrierexpress.hol.es/front/meansList",
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
								url:"http://www.courrierexpress.hol.es/front/articlesList",
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
								url:"http://www.courrierexpress.hol.es/front/counttablerow",
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
								url:"http://www.courrierexpress.hol.es/front/servicesList",
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
								url:"http://www.courrierexpress.hol.es/front/cities",
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
								url:"http://www.courrierexpress.hol.es/front/states",
							  });
			promise.then(fnSuccess, fnfailure);
	}
	
	
	/***********************************************************************************************/
	
	/*****    VALIDATION DU FORMULAIRE DE QUOTATION PAR L'UTILISATEUR AFIN QUE SON FREIGHT SOIT EVALUE  *********/
	
	
	/**********************************************************************************************/
	
	
    myCexpressFactory.makeQuotation = function(packetsforquote) {
		myCexpressFactory.packetsforquote=packetsforquote;
    };
	
	/************************************************************************************************/
	
	/*****             VALIDATION DU FORMULAIRE DE PREPARATION D'UN ENLEVEMENT              *********/
	/*****             PAR L'UTILISATEUR AFIN QUE SON FREIGHT SOIT EVALUE                   *********/
	
	
	/*************************************************************************************************/
	
	
    myCexpressFactory.planePickup = function(packetsPickupData) {
		myCexpressFactory.packetsPickupData=packetsPickupData;
		myCexpressFactory.SetupShipmentPickup(packetsPickupData);
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
	
	
	/*********************************************************************************/
	
	/************************ AJOUT D'UNE PIECE VIDE  *********************************/
	
	/***********************************************************************************/
	myCexpressFactory.addAPiece=function(){
	   pieces.push({Designation:"",ArticleID:1,Weight:0.0,lenght:0.0,width:0.0, height:0.0, bntadd:"false"});
	};
	
	myCexpressFactory.removeAPiece=function(piece){
	     var index = pieces.indexOf(piece);
         pieces.splice(index, 1);
	};
	
	/*********************************************************************************/
	
	/************************ AJOUT DE LA LISTE DES AU FACTORY  ************************/
	
	/***********************************************************************************/
	
    myCexpressFactory.states = function() {
        return states;
    };
	
	myCexpressFactory.pieces = function() {
        return pieces;
    };
	
	myCexpressFactory.recapDataList = function() {
        return recapDatas;
    };
	
    return myCexpressFactory;
});


/*********************************************************************************µ**********/
	
/**********  REPRESENTE LE CONTROLLEUR QUI GERE LA MISE EN PLACE D'UN ENLEVEMENT  ***********/
	
/*******************************************************************************************/

	myApp.controller('packetController', function($scope, cexpress){
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

	myApp.controller('freightCtrl', function($scope, cexpress){
	   cexpress.getServices();
	   cexpress.getTabRowCount("customers");
	   cexpress.getStates();
	   $scope.freights=cexpress;
	});