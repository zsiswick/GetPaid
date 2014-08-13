<!DOCTYPE html>
<!--[if IE 9]><html class="lt-ie10" lang="en" > <![endif]-->
<html class="no-js" lang="en" >
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
		<meta charset="utf-8">
		<title>Ruby Invoice</title>
		<link href='http://fonts.googleapis.com/css?family=Fenix' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/normalize.css" />
		<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/foundation.css" />
		<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/foundation-icons.css" />
		<!--<link rel="stylesheet" href="<?php $autoload['helper'] = array('url','utility'); ?>assets/css/company.css" />-->
		<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/style.css" />
		<script src="<?php echo base_url(); ?>assets/js/vendor/modernizr.js"></script>
	</head>
	<body>
	<div class="main-nav">
		<div class="row">
			<div class="small-12 columns">
			  	<div id="nav-container" class="text-center hide-for-small-only">
			  		<a class="branding" href="<?php echo base_url(); ?>">
			  		
			  			<svg width="50" height="50" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
			  				 viewBox="0 0 35.6 35.1" enable-background="new 0 0 35.6 35.1" xml:space="preserve">
			  			<g>
			  				<path fill="#F15959" d="M17.8,8.7L0,17.7l17.4,17.4l18.2-17.4L17.8,8.7z M18.4,19.5l-1.5,11.2l-6.5-11.2H18.4z M11.3,17.5l5.9-5.3
			  					l1.1,5.3H11.3z M20.4,19.5h4.8l-6.1,9.7L20.4,19.5z M20.3,17.5l-0.9-4.5l5,4.5H20.3z M8.3,17.5H5.6l6-3L8.3,17.5z M8.1,19.5
			  					l5.3,9.1l-9.1-9.1H8.1z M27.5,19.5h3.7L22,28.5L27.5,19.5z M27.4,17.5l-3.3-3l5.9,3H27.4z"/>
			  				<path fill="#F15959" d="M5.9,12.8C6,13,6.3,13.1,6.5,13.1c0.3,0,0.6-0.1,0.8-0.3c0.4-0.4,0.3-1-0.1-1.4L3.8,8.4
			  					C3.4,8.1,2.8,8.1,2.4,8.5c-0.4,0.4-0.3,1,0.1,1.4L5.9,12.8z"/>
			  				<path fill="#F15959" d="M29.9,13.1c0.2,0,0.5-0.1,0.7-0.2l3.3-2.9c0.4-0.4,0.5-1,0.1-1.4c-0.4-0.4-1-0.5-1.4-0.1l-3.3,2.9
			  					c-0.4,0.4-0.5,1-0.1,1.4C29.3,12.9,29.6,13.1,29.9,13.1z"/>
			  				<path fill="#F15959" d="M7.6,4.7c0.2,0.3,0.5,0.5,0.9,0.5c0.2,0,0.3,0,0.5-0.1c0.5-0.3,0.7-0.9,0.4-1.3L9.2,3.5
			  					C9,3,8.4,2.8,7.9,3.1C7.4,3.3,7.2,3.9,7.4,4.4L7.6,4.7z"/>
			  				<path fill="#F15959" d="M18.2,7.6c0.6,0,1-0.4,1-1V3.5c0-0.6-0.4-1-1-1s-1,0.4-1,1v3.1C17.2,7.2,17.7,7.6,18.2,7.6z"/>
			  				<path fill="#F15959" d="M18.1,2c0.3,0,0.5-0.1,0.7-0.3C19,1.5,19.1,1.3,19.1,1c0-0.3-0.1-0.5-0.3-0.7c-0.4-0.4-1-0.4-1.4,0
			  					c-0.2,0.2-0.3,0.4-0.3,0.7c0,0.3,0.1,0.5,0.3,0.7C17.5,1.9,17.8,2,18.1,2z"/>
			  				<path fill="#F15959" d="M8.8,7.1l1.6,3.1c0.2,0.3,0.5,0.5,0.9,0.5c0.2,0,0.3,0,0.5-0.1c0.5-0.3,0.7-0.9,0.4-1.3l-1.6-3.1
			  					c-0.3-0.5-0.9-0.7-1.3-0.4C8.7,6,8.5,6.6,8.8,7.1z"/>
			  				<path fill="#F15959" d="M26.7,5.1c0.1,0.1,0.3,0.1,0.5,0.1c0.4,0,0.7-0.2,0.9-0.5l0.2-0.3c0.3-0.5,0.1-1.1-0.4-1.3
			  					c-0.5-0.3-1.1-0.1-1.3,0.4l-0.2,0.3C26,4.3,26.2,4.9,26.7,5.1z"/>
			  				<path fill="#F15959" d="M23.9,10.6c0.1,0.1,0.3,0.1,0.5,0.1c0.4,0,0.7-0.2,0.9-0.5l1.6-3.1c0.3-0.5,0.1-1.1-0.4-1.3
			  					c-0.5-0.3-1.1-0.1-1.3,0.4l-1.6,3.1C23.2,9.7,23.4,10.4,23.9,10.6z"/>
			  			</g>
			  			</svg>
			  		
			  		</a>
			  		<nav class="menu-desktop">
			  			<ul id="main-menu">
			  				<li><a href="<?php echo base_url(); ?>index.php/auth/login" class="button round light">Sign In</a></li>
			  				<li><a href="<?php echo base_url(); ?>index.php/auth/register" class="button round light">Register</a></li>
			  			</ul>
			  		</nav>
			  	</div>
			  	<nav class="menu-mobile show-for-small-only">
			  		<ul id="main-menu-mobile">
			  			<li><a href="<?php echo base_url(); ?>index.php/auth/login">Sign In</a></li>
			  			<li><a href="<?php echo base_url(); ?>index.php/auth/register">Register</a></li>
			  		</ul>
			  	</nav>
			  	<div id="nav-container-mobile" class="text-center show-for-small-only">
			  		<a class="branding-mobile" href="#">Ruby Invoice</a>
			  		<a href="#" id="main-menu-mobile-toggle">menu</a>
			  	</div>
			</div>
		</div>
	</div>
	<section role="main" class="outer-wrap">