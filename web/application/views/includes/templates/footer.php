<script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.2.16/angular.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.2.16/angular-resource.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.2.16/angular-route.min.js"></script>
<?php if(base_url()!="http://localhost/"){ ?>
	<script src="<?php echo base_url(); ?>scripts/main-cexpress.js"></script>
<?php } else{ ?>
	<script src="<?php echo base_url(); ?>scripts/cexpress/main-cexpress-local.js"></script>
<?php } ?>
</body>
</html>