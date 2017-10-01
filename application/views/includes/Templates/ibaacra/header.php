<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Wisdom Pet Medicine</title>
  <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css"> -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>css/ibaacra/bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>css/ibaacra/style.css">
  <script type="text/javascript" src="<?php echo base_url(); ?>scripts/ibaacra/prefixfree.min.js"></script>
  <meta name="viewport" content="width=device-width, initial-scale=1"/>
</head>

<body>


<header>
  <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
    <div class="container">
	      <div class="navbar-header">
		    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#collapse" aria-expanded="false">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		    </button>
		   <a class="navbar-brand" href="#featured"><h1>Wisdom <span class="subhead">Pet Medicine</span></h1></a>
		</div> <!--navbar-header -->
		<div class="collapse navbar-collapse" id="collapse">
		  <ul class="nav navbar-nav navbar-right">
			  <li class="active"><a href="#featured">Home</a></li>
			  <li><a href="#mission">Mission</a></li>
			  <li><a href="#services">Services</a></li>
			  <li><a href="#staff">Staff</a></li>
			  <li><a href="#testimonials">Testimonials</a></li>
		  </ul> <!--nav navbar-nav -->
		</div> <!-- collapse -->
	</div> <!--container -->
  </nav>
 

  <div class="carousel fade" data-ride="carousel" id="featured">
    
    <ol class="carousel-indicators">
    </ol> <!-- Indicators -->
	
    <div class="carousel-inner fullheight">
	    <div class="item active"><img src="<?php echo base_url(); ?>images/ibaacra/WP_000905.jpg" alt="Lifestyle Photo"/></div>
		<div class="item"><img src="<?php echo base_url(); ?>images/ibaacra/WP_000888.jpg" alt="Mission"/></div>
		<div class="item"><img src="<?php echo base_url(); ?>images/ibaacra/WP_000941.jpg" alt="Vaccinations"/></div>
		<div class="item"><img src="<?php echo base_url(); ?>images/ibaacra/WP_001005.jpg" alt="Fish"/></div>
		<div class="item"><img src="<?php echo base_url(); ?>images/ibaacra/WP_000035.jpg" alt="Exotic Animals"/></div>
	</div> <!-- carousel-inner -->
	
	<a class="left carousel-control" href="#featured" role="button" data-slide="prev">
	  <span class="glyphicon glyphicon-chevron-left"></span>
	</a>
	<a class="right carousel-control" href="#featured" role="button" data-slide="next">
	  <span class="glyphicon glyphicon-chevron-right"></span>
	</a>
  </div> <!--carousel slide featured -->
</header>