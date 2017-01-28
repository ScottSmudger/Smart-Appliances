<main>
	<div class="container-fluid">
		<div class="row">
		  <div class="col-sm-4">
			<div id="topleft">
				<table class="table-striped">
					<thead>
						<tr class="theadings">
							<th>Name</th>
							<th>Address</th>
							<th>Emergency Contact Name</th>
							<th>Emergency Contact Details</th>
						</tr>
					</thead>
					</tbody><?php /*
							foreach($database->getUsersInfo() as $user)
							{
								echo"<tr>";
									echo"<td>".ucfirst(strtolower($user["FIRST_NAME"]))." ".ucfirst(strtolower($user["LAST_NAME"]))."</td>";
									echo"<td>".ucwords(strtolower($user["HOUSE_NO_NAME"].", ".$user["STREET"].", ".$user["TOWN_CITY"]))."<br/>".$user["POSTCODE"]."</td>";
									echo"<td>".ucfirst(strtolower($user["G_FIRST_NAME"]))." ".ucfirst(strtolower($user["G_LAST_NAME"]))."</td>";
									echo"<td>".strtolower($user["EMAIL"])."<br/>".$user["PHONE"]."</td>";
								echo"</tr>";
							} */?>
					</tbody>
				</table><br/>
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
				</tbody><?php /*
					foreach($database->getAllDevicesState() as $device)
					{
						echo"<tr>";
							echo"<td>".$device["device_id"]."</td>";
							echo"<td>".$device["user_id"]."</td>";
							echo"<td>".$device["state"]."</td>";
							echo"<td>".$device["date_time"]."</td>";
							echo"<td>".$device["appliance"]."</td>";
						echo"</tr>";
					} */?>
				</tbody>
			</table>
			<img id="chart" src="/resources/images/chart.png">
		  </div>
		</div>
	</div>
</main>