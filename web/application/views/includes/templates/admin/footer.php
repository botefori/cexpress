<script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.2.16/angular.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.2.16/angular-resource.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.2.16/angular-route.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/angular.bootstrap/0.13.3/ui-bootstrap-tpls.min.js"></script>
<?php if(base_url()!="http://localhost/"){ ?>
	<script src="<?php echo base_url(); ?>scripts/main-cexpress.js"></script>
<?php } else{ ?>
	<script src="<?php echo base_url(); ?>scripts/cexpress/main-cexpress-admin.js"></script>
<?php } ?>

<script type="text/javascript">
 $(document).ready(function(){
    /* alert("jquery loaded");
    $("#tab-packets tbody").on("click", "tr",function(){
		 $("tbody > tr.active").each(function(){
		      if($(this).hasClass("active"))
				$(this).removeClass("active");
			});
			if($(this).hasClass("select"))
			$(this).addClass("active");
	});*/
		
});
</script>
</body>
</html>