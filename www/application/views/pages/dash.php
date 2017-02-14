<div class="container-fluid">
	<div class="row">
		<div class="col-sm-4">
			<div id="topleft">
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
					<option value="0">All Devices</option><?php
						foreach($user->devices as $device)
						{
							echo "<option value=".$device->id.">".$device->appliance."</option>";
						} ?>
				</select><br/><br/>
				<button id="enter" type="button" onclick="">Enter</button>
				<br/><br/><br/><br/><br/><br/>
			</div>
		</div>
		<div class="col-sm-8">
			<div id="table">
			<h3 class="title">User Data</h3>
				<table class="table-striped">
					<thead>
						<tr class="theadings">
							<th>Device ID</th>
							<th>State</th>
							<th>Date/Time Updated</th>
							<th>Appliance</th>
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
			<div id="container"></div>
		</div>
	</div>
</div>

<script>
	Highcharts.chart('container', {
		title: {
			text: 'State of Devices for user <?=$user->details["name"]?>'
		},

		// X axis (Device state)
		xAxis: {
			title: {
				text: 'Time'
			},
			type: 'datetime'
		},

		// Y axis (time)
		yAxis: {
			categories: ['Closed', 'Open'],

			labels: {
				formatter: function () {
					return this.value;
				}
			},

			title: {
				text: 'State'
			}
		},

		legend: {
			layout: 'vertical',
			align: 'right',
			verticalAlign: 'middle'
		},

		plotOptions: {
			series: {
				pointStart: 2017
			}
		},

		// Graphs data
		series: <?=json_encode($user->graph)?>
	});
</script>
