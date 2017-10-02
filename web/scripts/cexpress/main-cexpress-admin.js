var myadminApp=angular.module('myadminApp', ['ngRoute', 'ui.bootstrap']);

myadminApp.config(function($routeProvider){
   $routeProvider.when('/tracking', {controller:ListCtrl,templateUrl:BASE_URL+'admin/tracking'});
   $routeProvider.when('/pricing', {controller:ListCtrl,templateUrl:BASE_URL+'admin/pricing'});
   $routeProvider.when('/ourservices', {controller:ListCtrl,templateUrl:BASE_URL+'admin/ourservices'});
   $routeProvider.when('/quoting', {controller:ListCtrl,templateUrl:BASE_URL+'admin/quoting'});
   $routeProvider.otherwise({redirectTo:'/'})
});

function ListCtrl(){
}

myadminApp.factory('ourservices', function($http, $location, $route){
 var myOurservices={};
 var services=[];
});

myadminApp.factory('adminservice', function($http, $location, $route){
 var myCexpressService = {};
 var services=[];

 
 /***********************************************************************************/

/*********************      VARIABLES GLOBALES          ****************************/
	
/***********************************************************************************/

 myCexpressService.selectedPacket=null;
 myCexpressService.precPage=1;
 myCexpressService.nextPage=2;
 myCexpressService.pageNumber=1;
 myCexpressService.currentSelectedPage=0;
 myCexpressService.beginPage=1;
 myCexpressService.endPage=10;
 myCexpressService.numPerPage=8;
 myCexpressService.maxSize=5;
 myCexpressService.interLineRepere=5;
 myCexpressService.selectedService={ServiceID:"", ServiceName:""};
 myCexpressService.tabRowCount=[];
 myCexpressService.packetList=[];
 myCexpressService.packetListTest=[];
 myCexpressService.numberOfpages=1;
 
 /***********************************************************************************/
 
 /*********************     END VARIABLES GLOBALES          *************************/
 
 /***********************************************************************************/
 
 statusList=[];
 
 myCexpressService.pagesNumber=function(){
	 return getPaginationItems(myCexpressService.beginPage,myCexpressService.endPage);
 };
 
 getPaginationItems=function(startItem, endItem){
	  var items=[];
	  //numberOfpages=(Math.round(myCexpressService.tabRowCount.rowCount/myCexpressService.numPerPage))-1;
	  for(i=startItem; i<=endItem; i++){
	   if(i<myCexpressService.numberOfpages)
	    items.push(i);
	  }
	  return items;
 };
 
 myCexpressService.getPacketList=function(){
 
    var fnSuccess=function(results){
        myCexpressService.packetListTest=results.data;		
	};

    var fnfailure=function(results){
	};
			
	var promise=$http({ method:"GET",
						url:BASE_URL+"admin/packetList",
					 });
	promise.then(fnSuccess, fnfailure);
 }
 
 myCexpressService.getStatusList=function(){
 
    var fnSuccess=function(results){
        statusList=angular.fromJson(results.data);					 
	};

    var fnfailure=function(results){
	};
			
	var promise=$http({ method:"GET",
						url:BASE_URL+"admin/statusList",
					 });
	promise.then(fnSuccess, fnfailure);
 }
 
 /*********************************************************************************/
	
	/*************   REINITIALISE LES DIFFERENTES POSITION DE LA PAGINNATION **********/
	
	/**********************************************************************************/
	
	getCurrentSelectedItemPosition=function(beginItem, endItem, selectedItem){
	  myPosition=1;
      if(selectedItem<myCexpressService.interLineRepere){
	      for(i=beginItem; i<=selectedItem; i++)
		  {
			if(i===selectedItem){
			  myPosition=myPosition;
			}
			myPosition++;
		  }
	     positionIsOk=false;
	     for(i=myPosition; i>=1; i--)
		 {
		   if((myCexpressService.beginPage-i)>0 && !positionIsOk){
		     myCexpressService.beginPage=myCexpressService.beginPage-i;
			 myCexpressService.endPage=myCexpressService.endPage-i;
			 positionIsOk=true;
		   }
		 }
	  }else if(selectedItem>myCexpressService.interLineRepere){
	     for(i=myCexpressService.interLineRepere; i<=selectedItem; i++)
		  {
			if(i===selectedItem){
			  myPosition=myPosition;
			}
			myPosition++;
		  }
	     //numberOfpages=Math.round(myCexpressService.tabRowCount.rowCount/myCexpressService.numPerPage)-1;
	     positionIsOk=false;
	     for(i=myPosition; i>=1; i--)
		 {
		   if(myCexpressService.endPage<myCexpressService.numberOfpages && !positionIsOk){
		     myCexpressService.beginPage=myCexpressService.beginPage+i;
			 myCexpressService.endPage=myCexpressService.endPage+i;
			 positionIsOk=true;
		   }
		 }
	  }	  
	};
 
 /*********************************************************************************/
	
 /********* EXTRACTION DES ADDRESSES EN FONCTION DU NUMERO DE LA PAGE **************/
	
 /**********************************************************************************/
	
	getBeginAndEndPages=function(numpage){
	  getCurrentSelectedItemPosition(myCexpressService.beginPage, myCexpressService.endPage, numpage);
	  myCexpressService.interLineRepere=Math.floor((myCexpressService.endPage+myCexpressService.beginPage)/2);
	  myCexpressService.currentSelectedPage=numpage;
	}
	
    myCexpressService.getPackets=function(numpage){
			
			if(numpage==1){
              myCexpressService.precPage=1;
			  myCexpressService.nextPage=2;
            }else{
			 myCexpressService.precPage=numpage-1;
			 myCexpressService.nextPage=numpage+1;
			}
			
			if(myCexpressService.currentSelectedPage>=1){
			   getBeginAndEndPages(numpage);
			}
			else{
			 
			}
			 
			var fnSuccess=function(results){	
             myCexpressService.packetList=results.data;			 
			};

			var fnfailure=function(results){
				
			};
			
			var promise=$http({ method:"GET",
								url:"admin/requestPacketsUsingPageId",
								params:{numpage:numpage}
							  });
			promise.then(fnSuccess, fnfailure);
	}
	
/*************************************************************************************/	

 /****  REQUETTE ASYNCHRONE POUR RECUPER LE NOMBRE DE LIGNES DANS UNE TABLE        **/
 
 /***********************************************************************************/
	myCexpressService.getTabRowCount=function(tabname){
			 
			var fnSuccess=function(results){
			 myCexpressService.tabRowCount=angular.fromJson(results.data);	
             myCexpressService.numberOfpages=Math.round(myCexpressService.tabRowCount.rowCount/myCexpressService.numPerPage)-1;			 
			};

			var fnfailure=function(results){
				
			};
			
			var promise=$http({ method:"GET",
								url:BASE_URL+"admin/counttablerow",
								params:{tabname:tabname}
							  });
			promise.then(fnSuccess, fnfailure);
	}
	
	myCexpressService.computePageNumber=function(tabname){
			 
			var fnSuccess=function(results){
			 myCexpressService.pageNumber=angular.fromJson(results.data);			 
			};

			var fnfailure=function(results){
				
			};
			
			var promise=$http({ method:"GET",
								url:BASE_URL+"admin/computePagesNumber",
								params:{tabname:tabname}
							  });
			promise.then(fnSuccess, fnfailure);
	}

/*********************************************************************************/
	
/********* RECUPERATION DE L'ADDRESSE SELECTIONNEE DANS LE TABLEAU   *************/
	
/*********************************************************************************/
	
	myCexpressService.selectPacket=function(packet){
	  myCexpressService.selectedPacket={PacketID:packet.PacketID,
	                                    ConsignorID:packet.ConsignorID,
										ConsigneeID:packet.ConsigneeID,
										ServiceID:packet.ServiceID,
										PacketCategoryID:packet.PacketCategoryID,
										AmountCollection:packet.AmountCollection,
										StatusID:packet.StatusID,
										TrackingCode:packet.TrackingCode,
										DesignationStatus:packet.DesignationStatus
	                                   };
	}
	
	/*********************************************************************************/
	
	/************* MISE A JOUR  DE ADDRESSE SELECTIONNEE          ********************/
	
	/*********************************************************************************/
	
	myCexpressService.updatePackets=function(packet){
	    var indice;
		for(var i=0; i<myCexpressService.packetList.length; i++)
		{
		  if(myCexpressService.packetList[i].PacketID==myCexpressService.selectedPacket.PacketID){
		   indice=i;
		  }
		}
		if(indice!=undefined){
		  myCexpressService.packetList[indice]={PacketID:packet.PacketID, 
		                      ConsignorID:packet.ConsignorID, 
							  ConsigneeID:packet.ConsigneeID,
							  ServiceID:packet.ServiceID,
							  PacketCategoryID:packet.PacketCategoryID,
							  AmountCollection:packet.AmountCollection,
							  StatusID:packet.StatusID,
							  TrackingCode:packet.TrackingCode,
							  DesignationStatus:packet.DesignationStatus
							 };
	
			fnUpdateSuccess=function(results){
			  myCexpressService.getPackets(myCexpressService.currentSelectedPage);
			};

			fnUpdatefailure=function(results){
				
			};
			
			updatePromise=$http({ method:"POST",
								url:BASE_URL+"admin/updateSelectedPacket",
								params:{packet:packet}
							  });
			updatePromise.then(fnUpdateSuccess, fnUpdatefailure);  
		}
	}
	
myCexpressService.serviceChanged=function(selectedService){
		for(i=0; i<services.length;i++)
		{
		      
      		if(services[i].ServiceID==selectedService.ServiceID){
			   myCexpressService.selectedPacket.ServiceID=services[i].ServiceID;
			   myCexpressService.selectedPacket.ServiceName=services[i].ServiceName;
			}		  
		}
}

/*********************************************************************************/
	
	/********* RECUPERATION DE LA LISTE DES SERVICES **************/
	
	/**********************************************************************************/
	
	myCexpressService.getServices=function(){
	
			var fnSuccess=function(results){
             services=angular.fromJson(results.data);					 
			};

			var fnfailure=function(results){
				
			};
			
			var promise=$http({ method:"GET",
								url:BASE_URL+"admin/servicesList",
							  });
			promise.then(fnSuccess, fnfailure);
	}
	
	myCexpressService.services=function(){
	  return services;
	};
	
    myCexpressService.numPages = function () {
     return myCexpressService.pageNumber;
    };
 
 myCexpressService.status=function(){
    return statusList;
 }

   return myCexpressService;
});


myadminApp.controller('trackingCtrl', function($scope, adminservice){
    adminservice.currentSelectedPage=1;
	adminservice.computePageNumber();
	adminservice.getTabRowCount('packet');
	adminservice.getPackets(1);						
    adminservice.getStatusList();		
	$scope.adminservice=adminservice;
});

myadminApp.controller('secondtrackingCtrl', function($scope, adminservice){
    adminservice.currentSelectedPage=1;
	adminservice.computePageNumber();
	adminservice.getPacketList();						
	$scope.adminpkpaginServ=adminservice;
	
	$scope.$watch('adminpkpaginServ.currentSelectedPage + adminpkpaginServ.numPerPage', function() {
    var begin = (($scope.adminpkpaginServ.currentSelectedPage - 1) * $scope.adminpkpaginServ.numPerPage)
    , end = begin + $scope.adminpkpaginServ.numPerPage;
    
    $scope.adminpkpaginServ.packetListTest = $scope.adminpkpaginServ.packetListTest.slice(begin, end);
  });
});



/*********************************************************************************/
	
/***     REPRESENTE LE CONTROLLEUR QUI GERE LA MISE A JOUR D'UN COLIS ********/
	
/***********************************************************************************/

myadminApp.controller('packetUpdateCtrl', function($scope, adminservice){
	adminservice.getServices();
	$scope.adminservice=adminservice;
});


	
