<?php
/*

File: Initialisation file
Description: Does any initial data processing and requires() any files
Author: Jamie Davies for Group 11, php provided by ScottSmudger
URL: https://github.com/ScottSmudger/GPIO-Door

*/

// This file will deal with most of the php processing
require_once("resources/init.php");

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Group 11 Prototype</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="/resources/css/style.css">
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="apple-touch-icon" sizes="57x57" href="/resources/images/apple-icon-57x57.png">
	<link rel="apple-touch-icon" sizes="60x60" href="/resources/images/apple-icon-60x60.png">
	<link rel="apple-touch-icon" sizes="72x72" href="/resources/images/apple-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="76x76" href="/resources/images/apple-icon-76x76.png">
	<link rel="apple-touch-icon" sizes="114x114" href="/resources/images/apple-icon-114x114.png">
	<link rel="apple-touch-icon" sizes="120x120" href="/resources/images/apple-icon-120x120.png">
	<link rel="apple-touch-icon" sizes="144x144" href="/resources/images/apple-icon-144x144.png">
	<link rel="apple-touch-icon" sizes="152x152" href="/resources/images/apple-icon-152x152.png">
	<link rel="apple-touch-icon" sizes="180x180" href="/resources/images/apple-icon-180x180.png">
	<link rel="icon" type="image/png" sizes="192x192"  href="/resources/images/android-icon-192x192.png">
	<link rel="icon" type="image/png" sizes="32x32" href="/resources/images/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="96x96" href="/resources/images/favicon-96x96.png">
	<link rel="icon" type="image/png" sizes="16x16" href="/resources/images/favicon-16x16.png">
	<link rel="manifest" href="/manifest.json">
	<meta name="msapplication-TileColor" content="#ffffff">
	<meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
	<meta name="theme-color" content="#ffffff">
	<script src="//ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	</head>
<body>
	<?php
	echo"config array:<pre>";
	var_dump($CONFIG);
	?>
	</pre>
	<?php
		require_once("resources/header.php");
	?>
	<main>
		<div class="container-fluid">
			<div class="row">
			  <div class="col-sm-4">
				<div id="topleft">
					<h3>User Details</h3>
					<h4>Name</h4><p>Name</p>
					<h4>Age</h4><p>Age</p>
					<h4>Address</h4><p>Address</p>
				</div>
				<div id="bottomleft">
					<h3>View Activity</h3></br>
					<select name="time">
						<option value="" ></option>
						<option value="day">Day</option>
						<option value="week">Week</option>
						<option value="month">Month</option>
					</select> </br> </br>
					<button id="enter" type="button" onclick="">Enter</button>
					</br></br></br></br></br></br>
				</div>
			  </div>
			  <div class="col-sm-8">
				<h2>User Data</h2>
				<table>
					<tr class="theadings">
						<th>ID</th>
						<th>User ID</th>
						<th>State</th>
						<th>Date/Time</th>
						<th>Appliance</th>
					</tr>
					<tr class="set1">
						<td> ****** </td>
						<td> ****** </td>
						<td> ****** </td>
						<td> ****** </td>
						<td> ****** </td>
					</tr>
					<tr class="set2">
						<td> ****** </td>
						<td> ****** </td>
						<td> ****** </td>
						<td> ****** </td>
						<td> ****** </td>					
					</tr>
					<tr class="set1">
						<td> ****** </td>
						<td> ****** </td>
						<td> ****** </td>
						<td> ****** </td>
						<td> ****** </td>
					</tr>
				</table>
				<img id="chart" src="/resources/images/chart.png">
			  </div>
			</div>
		</div>
	</main>
	<?php
		require_once("resources/footer.php");
	?>
</body>
</html>
