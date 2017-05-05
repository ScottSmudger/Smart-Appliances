<!-- Content of Support Modal -->
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-4">
			<div id="topleft">
				<h3 class="title">User Details</h3>
				<h4 class="subtitle">Name</h4><p class="info"><?=ucwords(strtolower($user->details["name"]))?></p>
				</br>
				<h4 class="subtitle">Age</h4><p class="info"><?=$user->details["age"]?></p>
				</br>
				<h4 class="subtitle">Address</h4><p class="info"><?=$user->details["house"] . " " . ucwords(strtolower($user->details["street"])) . ",<br/>" . ucfirst(strtolower($user->details["town_city"])) . ",<br/>" . $user->details["postcode"]?></p>
			</div>
		</div>
	</div>
</div>
