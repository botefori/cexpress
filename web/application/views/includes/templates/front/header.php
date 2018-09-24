<!DOCTYPE html>
<html lang="en" ng-app="myApp">
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css">
	<?php if(base_url()!="http://cexpress.docker/"){ ?>
	    <link rel="stylesheet" href="<?php echo base_url(); ?>css/initialize.css" media="screen" title="ni-title" charset="utf-8">
	    <link rel="stylesheet" href="<?php echo base_url(); ?>css/cexpress-main.css" media="screen" title="ni-title" charset="utf-8">
	    <link rel="stylesheet" href="<?php echo base_url(); ?>css/main-menu.css" media="screen" title="ni-title" charset="utf-8">
	<?php } else{ ?>
	    <link rel="stylesheet" href="<?php echo base_url(); ?>css/cexpress/initialize.css" media="screen" title="ni-title" charset="utf-8">
	    <link rel="stylesheet" href="<?php echo base_url(); ?>css/cexpress/cexpress-main-local.css" media="screen" title="ni-title" charset="utf-8">
	    <link rel="stylesheet" href="<?php echo base_url(); ?>css/cexpress/main-menu-local.css" media="screen" title="ni-title" charset="utf-8">
	<?php } ?>
	 <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <script>
      var BASE_URL = "<?php echo base_url(); ?>";
    </script>
	<title>Express</title>
</head>
<body>
<div id="container">
<div class="row">
      <div class="col-md-2">
	  </div>
	  <header class="col-md-8">
	    <article>
		  <div id="hd-top">
		    <h1>
			 <?php if(base_url()!="http://cexpress.docker/"){ ?>
				<img src="<?php echo base_url(); ?>images/index.png"/>
			<?php } else{ ?>
			   <img src="<?php echo base_url(); ?>images/cexpress/index.png"/>
			<?php } ?>
			 
			</h1>
			<div id="header-left-menu">
			  <ul class="ul-1">
				<li>
					<a href="<?php echo base_url(); ?>">
						Login
					</a>
				</li>
				<li>
					<a href=""></a>
					<a href="<?php echo base_url(); ?>">
						 Register
					</a>
				</li>
				<li>
					<a href="<?php echo base_url(); ?>"> Agent Login </a>
				</li>
			</ul>
			</div>
			 <div class="clear"></div>
		 </div>
		 <nav id="">
				<ul id="main-menu">
					<li class="active">
						<a href="<?php echo base_url(); ?>">Home </a>
					</li>
					<li>
						<a href="<?php echo base_url(); ?>index.php/front/about">About Us </a>
					</li>
					<li class="parent">
						<a href="<?php echo base_url(); ?>index.php/front#/services">Services</a>
						<ul class="sub-menu">
						</ul>
					</li>
					<li>
						<a href="<?php echo base_url(); ?>index.php/front#/request_quote">Request For Quote</a>
					</li>
					<li>
						<a href="<?php echo base_url(); ?>"></a>
					</li>
					<li>
						<a href="<?php echo base_url(); ?>index.php/front#/quote_pickup">Schedule Pickup</a>
					</li>
					<li class="parent">
						<a href="<?php echo base_url(); ?>index.php/front#/price_ranges"> Pricing </a>
						<ul class="sub-menu">
						</ul>
					</li>
					<li class="parent">
						<a href="<?php echo base_url(); ?>index.php/front#/follow_urpacket">Track shipment </a>
						<ul class="sub-menu">
						</ul>
					</li>
				</ul>
		</nav>
		<div class="clear"></div>
		</article>
	  </header>
	  <div class="col-md-2">
	  </div>
   </div>