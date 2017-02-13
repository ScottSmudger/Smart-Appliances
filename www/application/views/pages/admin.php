<div class="container-fluid">
	<div class="row">
		<div class="col-sm-4">
			<div id="topleft">
				<h3 class="title">User Details</h3>
				<h4 class="subtitle">Name</h4><p class ="info"><?=ucwords(strtolower($admin->details["name"]))?></p>
				<h4 class="subtitle">Age</h4><p class ="info"><?=$admin->details["age"] . " (".unix_to_human($admin->details["dob"], FALSE, "eu").")"?></p>
				<h4 class="subtitle">Address</h4><p class ="info"><?=$admin->details["house"] . " " . ucwords(strtolower($admin->details["street"])) . ",<br/>" . ucfirst(strtolower($admin->details["town_city"])) . ",<br/>" . $admin->details["postcode"]?></p>
				<h4 class="subtitle">Telephone</h4><p class= "info"><?=$admin->details["phone"]?></p>
			</div>
			<div id="bottomleft">
				<h3 class ="title">View Activity</h3><br/>
				<h4 class ="subtitle">Devices</h4>
				<select id = "dropdown1" name="Device">
					<option value="" ></option>
					<option value="Fridge">Fridge</option>
					<option value="Microwave">Microwave</option>
				</select><br/><br/>
				<button id="enter" type="button" onclick="">Enter</button>
				<br/><br/><br/><br/><br/><br/>
			</div>
		</div>
		<div class="col-sm-8">
			<div id = "table">
			<h3 class = "title">User Data</h3>
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
				</br>
			</div>
			<img id="chart" src="/application/assets/images/chart.png">
		</div>
	</div>
</div>



