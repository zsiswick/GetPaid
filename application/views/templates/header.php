<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Get Paid!</title>
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/foundation.css" />
	<!--<link rel="stylesheet" href="<?php $autoload['helper'] = array('url','utility'); ?>assets/css/company.css" />-->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/style.css" />
	<script src="<?php echo base_url(); ?>assets/js/vendor/modernizr.js"></script>
</head>
<body>
<nav class="top-bar">
	<ul class="title-area">
    <li class="name">
      <h1><?php echo anchor('/home', 'Home'); ?></h1>
    </li>
  </ul>
	<section class="top-bar-section">
		<ul class="right">
			<li><?php echo anchor('invoices', 'Invoices'); ?></li>
			<li><?php echo anchor('clients', 'Clients'); ?></li>
			<li><?php echo anchor('settings', 'Settings'); ?></li>
		</ul>
	</section>
</nav>