</main>
<footer>
	<ul class ="lowermenu">
		<li id = "copyright">&copy; Copyright Group 11 </li>
		<?php
			// If logged in display the logout button
			if($this->session->logged_in)
			{ ?>
				<li class="lowerlist" title="Logout button"><a href="/logout">Log Out</a></li><?php
			} ?>
		<li class= "lowerlist"><a href="http://github.com/ScottSmudger/Smart-Appliances" target="_blank">GitHub</a></li>
		<li class="lowerlist"><a data-toggle="modal" data-target="#Contact">Support</a></li>
	</ul>	
</footer>
</body>
</html>

<?php
$this->benchmark->mark('ending_point');
?>
