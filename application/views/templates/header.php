<!DOCTYPE html>
<!--[if IE 9]><html class="lt-ie10" lang="en" > <![endif]-->
<html class="no-js" lang="en" >
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta charset="utf-8">
		<title>Get Paid!</title>
		<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/normalize.css" />
		<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/foundation.css" />
		<!--<link rel="stylesheet" href="<?php $autoload['helper'] = array('url','utility'); ?>assets/css/company.css" />-->
		<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/style.css" />
		<script src="<?php echo base_url(); ?>assets/js/vendor/modernizr.js"></script>
	</head>
	<body>
	<nav class="top-bar" data-topbar>
		<ul class="title-area">
	    <li class="name">
	      <h1><?php echo anchor('/home', 'Home'); ?></h1>
	    </li>
	    <li class="toggle-topbar menu-icon"><a href="#"><span>Menu</span></a></li>
	  </ul>
		<section class="top-bar-section">
			<ul class="right show-for-large-up">
				<li><?php echo anchor('invoices', 'Invoices'); ?></li>
				<li><?php echo anchor('clients', 'Clients'); ?></li>
				<li><?php echo anchor('settings', 'Settings'); ?></li>
			</ul>
			<ul class="right hide-for-large-up">
				<li><?php echo anchor('invoices', 'Invoices'); ?></li>
				<li><?php echo anchor('clients', 'Clients'); ?></li>
				<li><?php echo anchor('settings', 'Settings'); ?></li>
			</ul>
		</section>
	</nav>