</main>
<footer>
	<!-- Navigation bar at the bottom of the page -->
	<ul class="lowermenu">
		<!-- Copyright -->
		<li id="copyright">&copy; Copyright Group 11 </li>
		<!-- HTML5 Logo -->
		<li id="html" title="HTML5 Approved Badge"><img alt ="HTML5 Badge" id="badge" src="<?=base_url("assets")?>/images/htmlbadge.png"/></li>
		<li id="html" title="W3C Compliant"><img alt="W3C Badge" id="badge" src="http://validator.w3.org/images/v15445.gif"/></li>
		<?php
			// If logged in display the logout button
			if($this->session->logged_in)
			{ ?>
				<li class="lowerlist" title="Logout button"><a href="/logout">Log Out</a></li><?php
			} ?>
		<!-- Github Page Link -->
		<li class="lowerlist" title="Link to our Github page"><a href="http://github.com/ScottSmudger/Smart-Appliances" target="_blank">GitHub</a></li>
		<!-- Support Page Link -->
		<li class="lowerlist" title="Link to support page"><a data-toggle="modal" data-target="#Contact">Support</a></li>
	</ul>	
</footer>
</body>
</html>

<?php
$this->benchmark->mark('ending_point');
?>
