var myApp=angular.module('myApp', ['ngRoute']);

myApp.factory('freights', function($http) {
	var states=[];
    var myFreightService = {};
	
	myFreightService.selectedFreight={};
	
/***********************************************************************************/

/*********************      VARIABLES GLOBALES          ****************************/
	
/***********************************************************************************/
	myFreightService.tabRowCount=[];
/*************************************************************************************/	

 /****  REQUETTE ASYNCHRONE POUR RECUPER LE NOMBRE DE LIGNES DANS LA TABLE PAYS **/
 
 /***********************************************************************************/
	myFreightService.getTabRowCount=function(tabname){
			 
			var fnSuccess=function(results){
			 myFreightService.tabRowCount=angular.fromJson(results.data);			 
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
	
	myFreightService.getServices=function(){
	
			var fnSuccess=function(results){
			 myFreightService.services=angular.fromJson(results.data);		 
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
	
	myFreightService.getCities=function(){
	
			var fnSuccess=function(results){
			 myFreightService.cities=angular.fromJson(results.data);			 
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
	
    myFreightService.getStates=function(){
	
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
	
	/*********************************************************************************/
	
	/*****    AJOUT D'UNE ADDRESSE DANS LA TABLE DES ADDRESSES EN ASYNCHRONE  *********/
	
	
	/*********************************************************************************/
	
	
    myFreightService.makeQuotation = function(packetsforquote) {
	     
		myFreightService.packetsforquote=packetsforquote;
    };
	
	
	/*********************************************************************************/
	
	/************************ AJOUT DE LA LISTE DES PAYS AU FACTORY  ************************/
	
	/***********************************************************************************/
	
    myFreightService.states = function() {
        return states;
    };
    return myFreightService;
});


/*********************************************************************************/
	
/**********  REPRESENTE LE CONTROLLEUR QUI GERE LE FORMULAIRE DES FREIGHT  ***********/
	
/***********************************************************************************/

	myApp.controller('freightCtrl', function($scope, freights){
	   freights.getServices();
	   freights.getTabRowCount("customers");
	   freights.getStates();
	   $scope.freights=freights;
	});