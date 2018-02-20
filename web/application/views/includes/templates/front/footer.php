<script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.2.16/angular.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.2.16/angular-resource.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.2.16/angular-route.min.js"></script>
<script src="<?php echo base_url(); ?>scripts/cexpress/ngCart.js"></script>
<?php if(base_url()!="http://cexpress.site.docker/"){ ?>
	<script src="<?php echo base_url(); ?>scripts/main-cexpress.js"></script>
<?php } else{ ?>
	<script src="<?php echo base_url(); ?>scripts/cexpress/main-cexpress-local.js"></script>
	<script src="<?php echo base_url(); ?>scripts/cexpress/cexpress-clients.js"></script>
<?php } ?>
</body>
</html>