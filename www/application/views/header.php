<!DOCTYPE html>
<html lang="en">
<head>
	<title>Group 11 Alpha</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="<?=base_url("assets")?>/style.css">
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="apple-touch-icon" type="image/png" sizes="57x57" href="<?=base_url("assets")?>/images/apple-icon-57x57.png">
	<link rel="apple-touch-icon" type="image/png" sizes="60x60" href="<?=base_url("assets")?>/images/apple-icon-60x60.png">
	<link rel="apple-touch-icon" type="image/png" sizes="72x72" href="<?=base_url("assets")?>/images/apple-icon-72x72.png">
	<link rel="apple-touch-icon" type="image/png" sizes="76x76" href="<?=base_url("assets")?>/images/apple-icon-76x76.png">
	<link rel="apple-touch-icon" type="image/png" sizes="114x114" href="<?=base_url("assets")?>/images/apple-icon-114x114.png">
	<link rel="apple-touch-icon" type="image/png" sizes="120x120" href="<?=base_url("assets")?>/images/apple-icon-120x120.png">
	<link rel="apple-touch-icon" type="image/png" sizes="144x144" href="<?=base_url("assets")?>/images/apple-icon-144x144.png">
	<link rel="apple-touch-icon" type="image/png" sizes="152x152" href="<?=base_url("assets")?>/images/apple-icon-152x152.png">
	<link rel="apple-touch-icon" type="image/png" sizes="180x180" href="<?=base_url("assets")?>/images/apple-icon-180x180.png">
	<link rel="icon" type="image/png" sizes="192x192"  href="<?=base_url("assets")?>/images/android-icon-192x192.png">
	<link rel="icon" type="image/png" sizes="32x32" href="<?=base_url("assets")?>/images/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="96x96" href="<?=base_url("assets")?>/images/favicon-96x96.png">
	<link rel="icon" type="image/png" sizes="16x16" href="<?=base_url("assets")?>/images/favicon-16x16.png">
	<link rel="manifest" href="<?=base_url("assets")?>/images/manifest.json">
	<meta name="msapplication-TileColor" content="#ffffff">
	<meta name="msapplication-TileImage" content="<?=base_url("assets")?>/images/ms-icon-144x144.png">
	<meta name="theme-color" content="#ffffff">
	<script src="//ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<script src="//code.highcharts.com/highcharts.js"></script>
	<script src="https://code.highcharts.com/stock/highstock.js"></script>
	<script src="//code.highcharts.com/modules/exporting.js"></script>
</head>
<body>
<header>
	<div class="logowrap">
		<a href="/"><img id="logo" src="<?=base_url("assets")?>/images/logo.png"></a>
	</div>	
	<ul>
		<li><a data-toggle="modal" data-target="#Contact">Support</a></li>
		<li><a href="http://github.com/ScottSmudger/Smart-Appliances" target="_href">Github</a></li>
		<?php
		// If logged in display logout button
		if($this->session->logged_in)
		{ ?>
			<li class="navright"><a href="/logout">Log Out</a></li><?php
		} ?>
	</ul>
</header>
<main>
<!-- Support Modal -->
<div class="modal fade" id="Contact" tabindex="-1" role="dialog" aria-labelledby="Contact" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="Contact">Support Page</h4>
			</div>
			<div class="modal-body">
				<?=form_open('sa/email')?>
					<p>Please enter your details and describe your issue. We will get back to you as soon as possible.</p>
					<h5 class="EHeader">Subject</h5>
					<input type="text" name="subject">
					
					<h5 class="EHeader">Name</h5>
					<input type="text" name="from_name">

					<h5 class="EHeader">Email Address</h5>
					<input type="text" name="from_email">

					<h5 class="EHeader">Issue</h5>
					<textarea></textarea>

					<input id = "formsubmit" type="submit" value="Submit">
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
