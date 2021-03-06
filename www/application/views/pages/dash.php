<div class="container-fluid">
	<div class="row">
		<div class="col-sm-4">
			<div id="topleft">
				<!-- Div that displays the User's Details which is queried from the database-->
				<h3 class="title" title="User's Details are displayed below">User Details</h3>
				<h4 class="subtitle" title="User's Name is below">Name</h4><p class="info"><?=$user->details["first_name"]." ".$user->details["last_name"]?></p>
				<h4 class="subtitle" title="User's Age is below">Age (Date of Birth)</h4><p class="info"><?=$user->details["age"] . " (".$user->details["dob"].")"?></p>
				<h4 class="subtitle" title="User's Address is below">Address</h4><p class="info"><?=$user->details["house"] . " " . $user->details["street"] . ",<br/>" . $user->details["town_city"] . ",<br/>" . $user->details["postcode"]?></p>
				<h4 class="subtitle" title="User's Telephone number is below">Telephone</h4><p class= "info"><?=$user->details["phone"]?></p>
			</div>
			<div id="bottomleft">
				<!-- Div that contains the dropdowns that selects the data that needs to be displayed on the graph -->
				<h3 class="title" title="Select what data you would like to view below">View Activity</h3><br/>
				<h4 class="subtitle">Devices</h4>
				<form method="GET">
					<select class="choicedropdown" name="device_id" title="Select the device you would like to view">
						<!-- Devices selection dropdown -->
						<option value=0>All Devices</option><?php
						foreach($user->devices as $device)
						{
							echo "<option value=".$device->id.">".$device->appliance."</option>";
						} ?>
					</select><br/><br/>
					<!-- Time period selection dropdown -->
					<h4 class="subtitle">Time Period</h4>
					<select class="choicedropdown" name="time_period" title="Select the time you would like to view" onchange="test()">
						<option value="everything">All Data</option> 
						<option value="today">Today</option>
						<option value="thisweek">This Week</option>
						<option value="thismonth">This Month</option>
						<option value="thisyear">This Year</option>
					</select>
					<br/><br/>
					<button title="Enter your selection" id="enter" type="button" onclick="this.form.submit()">Enter</button>
				</form>
				<br/><br/><br/><br/><br/><br/><br/>
			</div>
		</div>
		<div class="col-sm-8">
		<!-- Div that contains device history table -->
			<div id="table">
				<h3 class="title" title="Selected data is viewed below">User Data</h3>
					<div class="table-responsive">
					<table class="table-striped">
						<thead>
							<tr class="theadings">
								<th title="The device's ID number">Device ID</th>
								<th title="The device's state">State</th>
								<th title="The device's date and time update">Date/Time Updated</th>
								<th title="The appliance's name">Appliance</th>
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
					</div>
			</div>

			<div id="box">
				<h3 class="title" title="Graphical analysis is shown below">Device History</h3><?php
				if($user->graph["devices"])
				{ ?>
					<div id="container"></div><?php
				}
				else
				{ ?>
					<div class="alert alert-danger">No Data to Display!</div><?php
				} ?>
			</div>
			<br/>
		</div>
	</div>
</div>
<!-- Code for the graph -->
<script>
	// All of the code for the graph
	var data = <?=json_encode($user->graph["devices"])?>;

	var chart = Highcharts.chart('container', {
		title: {
			text: '<?=$user->graph["title"]?>'
		},

		// X axis (time)
		xAxis: {
			title: {
				text: 'Time'
			},

			type: 'datetime'
		},

		// Y axis (Device state)
		yAxis: {
			title: {
				text: 'State'
			},

			labels: {
				formatter: function () {
					return this.value;
				}
			},

			categories:['Closed', 'Open']
		},

		// Display the legend
		legend: {
			enabled: true
		},

		// Formats the unix time properly so we can see
		// the hour and minute
		tooltip: {
			xDateFormat: '%a. %e %B %Y - %H:%M',
			shared: true
		},

		// json_encode()'d for plotting on the graph
		series: data
	});
</script>
 