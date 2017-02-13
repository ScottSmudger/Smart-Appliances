<div class="container-fluid">
	<div class="row">
		<div class="col-sm-4">
			<div id="topleft">
				<h3 class="title">User Details</h3>
				<h4 class="subtitle">Name</h4><p class="info"><?=ucwords(strtolower($user->details["name"]))?></p>
				<h4 class="subtitle">Age</h4><p class="info"><?=$user->details["age"] . " (".unix_to_human($user->details["dob"], FALSE, "eu").")"?></p>
				<h4 class="subtitle">Address</h4><p class="info"><?=$user->details["house"] . " " . ucwords(strtolower($user->details["street"])) . ",<br/>" . ucfirst(strtolower($user->details["town_city"])) . ",<br/>" . $user->details["postcode"]?></p>
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
				</br>
			</div>
			<div id="container"></div>
		</div>
	</div>
</div>

<script>
Highcharts.chart('container', {
	title: {
		text: 'State of Devices from '
	},

	xAxis: {
		title: {
			text: 'Time'
		}
	},

	yAxis: {
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

	series: [{
		name: 'Fridge',
		data: [
			[1486972800, 0],
			[1486980000, 0],
			[1486983600, 1],
			[1486985400, 0],
			[1486987200, 1],
			[1486989000, 0],
			[1486999800, 1],
			[1487001600, 0],
			[1487001600, 0],
			[1487005200, 0],
			[1487008800, 1],
			[1487016000, 1]
		]
	}, {
		name: 'Microwave',
		data: [
			[1486972800, 1],
			[1486980000, 0],
			[1486983600, 0],
			[1486985400, 1],
			[1486987200, 0],
			[1486989000, 1],
			[1486999800, 0],
			[1487001600, 1],
			[1487001600, 1],
			[1487005200, 1],
			[1487008800, 0],
			[1487016000, 0]
		]
	}]
});
</script>
