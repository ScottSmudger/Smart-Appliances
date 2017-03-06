<div class="container-fluid">
	<div class="row">
		<div class="col-sm-4">
			<div id="topleft">
<<<<<<< HEAD
				<h3 class="title" title = "User's Details are displayed below">User Details</h3>
				<h4 class="subtitle" title = "User's Name is below">Name</h4><p class="info"><?=$user->details["name"]?></p>
				<h4 class="subtitle" title = "User's Age is below">Age</h4><p class="info"><?=$user->details["age"] . " (".$user->details["dob"].")"?></p>
				<h4 class="subtitle" title = "User's Address is below">Address</h4><p class="info"><?=$user->details["house"] . " " . $user->details["street"] . ",<br/>" . $user->details["town_city"] . ",<br/>" . $user->details["postcode"]?></p>
				<h4 class="subtitle" title = "User's Telephone number is below">Telephone</h4><p class= "info"><?=$user->details["phone"]?></p>
			</div>
			<div id="bottomleft">
				<h3 class="title" title = "Select what data you would like to view below">View Activity</h3><br/>
				<h4 class="subtitle">Devices</h4>
				<select id="dropdown1" name="Device" title = "Select the device you would like to view">
=======
				<h3 class="title">User Details</h3>
				<h4 class="subtitle">Name</h4><p class="info"><?=$user->details["name"]?></p>
				<h4 class="subtitle">Age</h4><p class="info"><?=$user->details["age"] . " (".$user->details["dob"].")"?></p>
				<h4 class="subtitle">Address</h4><p class="info"><?=$user->details["house"] . " " . $user->details["street"] . ",<br/>" . $user->details["town_city"] . ",<br/>" . $user->details["postcode"]?></p>
				<h4 class="subtitle">Telephone</h4><p class= "info"><?=$user->details["phone"]?></p>
			</div>
			<div id="bottomleft">
				<h3 class="title">View Activity</h3><br/>
				<h4 class="subtitle">Devices</h4>
				<select id="dropdown1" name="Device">
>>>>>>> 316dc7366d7d9d810cc08feb625d8ecae2d073f8
					<option value="0">All Devices</option><?php
						foreach($user->devices as $device)
						{
							echo "<option value=".$device->id.">".$device->appliance."</option>";
						} ?>
				</select><br/><br/>
<<<<<<< HEAD
				<select id="dropdown1" name="Time" title = "Select the time you would like to view">
=======
				<select id="dropdown1" name="Time">
>>>>>>> 316dc7366d7d9d810cc08feb625d8ecae2d073f8
					<option value="time">Time</option> 
					<option value="today">Today</option>
					<option value="thisweek">This Week</option>
					<option value="thismonth">This Month</option>
					<option value="thismonth">This Year</option>
				</select>
				</br></br>
				<button id="enter" type="button" onclick="">Enter</button>
				<br/><br/><br/><br/><br/><br/></br><br/></br>
			</div>
			</br>
			<div id="glyndwr">
<<<<<<< HEAD
				<img id="stripes" src="/assets/images/glyndwr.jpg" alt = "Glyndwr University Logo" title = "Glyndwr University Logo">
=======
				<img id="stripes" src="/assets/images/glyndwr.jpg">
>>>>>>> 316dc7366d7d9d810cc08feb625d8ecae2d073f8
			</div>
			</br>
		</div>
		<div class="col-sm-8">
			<div id="table">
<<<<<<< HEAD
			<h3 class="title" title = "Selected data is viewed below">User Data</h3>
				<table class="table-striped">
					<thead>
						<tr class="theadings">
							<th title = "The device's ID number">Device ID</th>
							<th title = "The device's state">State</th>
							<th title = "The device's date and time update">Date/Time Updated</th>
							<th title = "The appliance's name">Appliance</th>
=======
			<h3 class="title">User Data</h3>
				<table class="table-striped">
					<thead>
						<tr class="theadings">
							<th>Device ID</th>
							<th>State</th>
							<th>Date/Time Updated</th>
							<th>Appliance</th>
>>>>>>> 316dc7366d7d9d810cc08feb625d8ecae2d073f8
						</tr>
					</thead>
					<tbody><?php
						foreach($user->devices as $device)
						{
							echo "<tr>";
								echo "<td>".$device->id."</td>";
								echo "<td>".$device->state."</td>";
								echo "<td>".$device->date_time."</td>";
								echo "<td>".$device->appliance."</td>";
							echo "</tr>";
						} ?>
					</tbody>
				</table>
				<br/>
			</div>
			<div id="box">
<<<<<<< HEAD
				<h3 class="title" title = "Graphical analysis is shown below">Device History</h3>
=======
				<h3 class="title">Device History</h3>
>>>>>>> 316dc7366d7d9d810cc08feb625d8ecae2d073f8
				<div id="container"></div>
			</div>
			<br>
		</div>
	</div>
</div>

<?php
// Dump the graph script code here
require_once("graph.php")
?>
