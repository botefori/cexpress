jQuery(document).ready(function($){
   var myClickedItemTextValue="";
        
	    /*$("#tab-packets tbody").on("click", "tr",function(){
		  alert("row clicked");
		 $("tbody > tr.active").each(function(){
		      if($(this).hasClass("active"))
				$(this).removeClass("active");
			});
			if($(this).hasClass("select"))
			$(this).addClass("active");
		});*/
		
		$("#updateaddress").on("click", function(){
		   $("tbody > tr").each(function(){
		     $(this).on("click", function(){
			     $("tbody > tr.active").each(function(){
					$(this).removeClass("active");
				  });
				$(this).addClass("active");
			 });
		   });
		});
})