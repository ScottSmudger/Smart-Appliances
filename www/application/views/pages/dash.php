<main>
	<div class="container-fluid">
		<div class="row">
		  <div class="col-sm-4">
			<div id="topleft">
				<div id="title"><h3>User Details</h3></div>
				<h4>Name</h4><p><?="Name"?></p>
				<h4>Age</h4><p><?="Age"?></p>
				<h4>Address</h4><p><?="Address"?></p>
			</div>
			<div id="bottomleft">
				<div id="title"><h3>View Activity</h3></div><br/>
				<select name="time">
					<option value="" ></option>
					<option value="day">Day</option>
					<option value="week">Week</option>
					<option value="month">Month</option>
				</select> <br/> <br/>
				<button id="enter" type="button" onclick="">Enter</button>
				<br/><br/><br/><br/><br/><br/>
			</div>
		  </div>
		  <div class="col-sm-8">
			<h2>User Data</h2>
			<table class="table-striped">
				<thead>
					<tr class="theadings">
						<th>Device ID</th>
						<th>State</th>
						<th>Date/Time Updated</th>
						<th>Appliance</th>
					</tr>
				</thead>
				</tbody><?php /*
					foreach($database->getAllDevicesState() as $device)
					{
						echo"<tr>";
							echo"<td>".$device["device_id"]."</td>";
							echo"<td>".$device["state"]."</td>";
							echo"<td>".$device["date_time"]."</td>";
							echo"<td>".$device["appliance"]."</td>";
						echo"</tr>";
					} */?>
				</tbody>
			</table>
			<img id="chart" src="/application/assets/images/chart.png">
		  </div>
		</div>
	</div>
</main>
