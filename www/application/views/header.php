<!DOCTYPE html>
<html lang="en">
<head>
	<title>Group 11 - Smart Appliances</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	<!-- Favicon stuff -->
	<link rel="apple-touch-icon" type="image/png" sizes="57x57" href="/assets/images/apple-icon-57x57.png">
	<link rel="apple-touch-icon" type="image/png" sizes="60x60" href="/assets/images/apple-icon-60x60.png">
	<link rel="apple-touch-icon" type="image/png" sizes="72x72" href="/assets/images/apple-icon-72x72.png">
	<link rel="apple-touch-icon" type="image/png" sizes="76x76" href="/assets/images/apple-icon-76x76.png">
	<link rel="apple-touch-icon" type="image/png" sizes="114x114" href="/assets/images/apple-icon-114x114.png">
	<link rel="apple-touch-icon" type="image/png" sizes="120x120" href="/assets/images/apple-icon-120x120.png">
	<link rel="apple-touch-icon" type="image/png" sizes="144x144" href="/assets/images/apple-icon-144x144.png">
	<link rel="apple-touch-icon" type="image/png" sizes="152x152" href="/assets/images/apple-icon-152x152.png">
	<link rel="apple-touch-icon" type="image/png" sizes="180x180" href="/assets/images/apple-icon-180x180.png">
	<link rel="icon" type="image/png" sizes="192x192" href="/assets/images/android-icon-192x192.png">
	<link rel="icon" type="image/png" sizes="32x32" href="/assets/images/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="96x96" href="/assets/images/favicon-96x96.png">
	<link rel="icon" type="image/png" sizes="16x16" href="/assets/images/favicon-16x16.png">
	<link rel="manifest" href="/assets/images/manifest.json">
	<meta name="msapplication-TileColor" content="#ffffff">
	<meta name="msapplication-TileImage" content="/assets/images/ms-icon-144x144.png">
	<meta name="theme-color" content="#ffffff">
	
	<!-- jQuery -->
	<script src="//code.jquery.com/jquery-3.1.1.min.js"></script>
	<script src="/assets/js/jquery.cookie.js" type="text/javascript"></script>
	
	<!-- Custom CSS and JavaScript-->
	<link id="pagestyle" rel="stylesheet" type="text/css" href="/assets/css/blue.css" title="default">
	<link rel="stylesheet" type="text/css" href="/assets/css/mobile.css">
	<script src="/assets/js/custom.js" type="text/javascript"></script>
	
	<!-- BootStrap CSS and JavaScript-->
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	
	<!-- Third party libraries -->
	<script src="//code.highcharts.com/highcharts.js"></script>
	<script src="//code.highcharts.com/modules/exporting.js"></script>
	<link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.0.3/cookieconsent.min.css" />
	<script src="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.0.3/cookieconsent.min.js"></script>
</head>
<body>
<header>
	<!-- Logo Section of the header-->
	<br/><br/><br/>
	<div class="logowrap">
		<a href="/"><img id="logo" alt="Group 11 Logo" src="/assets/images/logo.png" title="Group 11 Logo"></a>
	</div>
	<!-- Nafvigation bar at the top of the screen -->
	<ul id ="uppermenu">
		<!-- Support Modal -->
		<li class="upperoptions" id="supButton" title="Link to support page"><a data-toggle="modal" data-target="#Contact">Support</a></li>
		<!-- Github page link -->
		<li class="upperoptions" title="Link to our Github page"><a href="http://github.com/ScottSmudger/Smart-Appliances" target="_blank">Github</a></li>
		<?php
		// If logged in display the logout button
		if($this->session->logged_in)
		{ ?>
			<li class="navright" title="Logout button"><a href="/logout">Log Out</a></li><?php
		} ?>
		<li id="right">
			<select title="Select which theme you would like" class="colour_change" id="colourChange" onchange="changeStyle()">
				<option value="blue">Default</option>
				<option value="red">Red</option>
				<option value="green">Green</option>
			</select>
		</li>
	</ul>
</header>
<main>

<!-- Support Modal -->
<div class="modal fade" id="Contact" tabindex="-1" role="dialog" aria-labelledby="Contact" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" >Support Page</h4>
			</div>
			<div class="modal-body">
				<div class="form-group">
					<?=form_open("sa/email")?>
						<p>Please enter your details and describe your issue. We will get back to you as soon as possible.</p>
						<h5 class="EHeader">Subject</h5>
						<input type="text" name="subject" id="modalSubject">
						
						<h5 class="EHeader">Name</h5>
						<input type="text" name="from_name" id="modalName">
						
						<h5 class="EHeader">Email Address</h5>
						<input type="text" name="from_email" id="modalAddress">
						
						<h5 class="EHeader">Issue</h5>
						<textarea class="form-control" name="message" id="modalIssue"></textarea>

						<br/>
						<input id="formsubmit" type="submit" value="Submit" onSubmit="return emailAuth()">
					</form>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
