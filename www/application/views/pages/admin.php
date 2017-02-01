<div class="container-fluid">
	<div class="row">
		<div class="col-sm-4">
			<div id="topleft">
				<div class="title"><h3>Admin Details</h3></div>
				<h4>Name</h4><p><?=ucwords(strtolower($admin->details["name"]))?></p>
				<h4>Age</h4><p><?=$admin->details["age"]?></p>
				<h4>Address</h4><p><?=$admin->address["house"] . " " . ucwords(strtolower($admin->address["street"])) . ",<br/>" . ucfirst(strtolower($admin->address["town_city"])) . ",<br/>" . $admin->address["postcode"]?></p>
			</div>
			<div id="bottomleft">
				<div class="title"><h3>View Activity</h3></div><br/>
				<select name="time">
					<option value="" ></option>
					<option value="day">Day</option>
					<option value="week">Week</option>
					<option value="month">Month</option>
				</select><br/><br/>
				<button id="enter" type="button" onclick="">Enter</button>
				<br/><br/><br/><br/><br/><br/>
			</div>
		</div>
		<div class="col-sm-8">
			<h2>Device Data</h2>
				<table class="table-striped">
					<thead>
						<tr class="theadings">
							<th>Device ID</th>
							<th>User ID</th>
							<th>State</th>
							<th>Date/Time Updated</th>
							<th>Appliance</th>
						</tr>
					</thead>
					<tbody><?php
						foreach($admin->devices as $device)
						{
							echo "<tr>";
								echo "<td>".$device->id."</td>";
								echo "<td>".$device->user_id."</td>";
								echo "<td>".$device->state."</td>";
								echo "<td>".$device->date_time."</td>";
								echo "<td>".$device->appliance."</td>";
							echo "</tr>";
						} ?>
					</tbody>
				</table>
			<img id="chart" src="/application/assets/images/chart.png">
		</div>
	</div>
</div>
