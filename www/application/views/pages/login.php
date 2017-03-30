<div id="description">
	<h3 id="desHeading">Welcome to the Group 11 Smart Appliances Web Application Service</h3>
	<p id="desinfo">Please enter your username and password below</p>
</div>
<br/>
<div id="loginSection">
	<?=form_open("authenticate")?>
		<br/>
		<br/>
		<p class="entryFields">Username: <input id="username" type="text" name="username" value="<?=set_value('username')?>" title = "Enter your username"></p>
		<br/><br/>
		<p class="entryFields">Password: <input id="passowrd" type="password" name="password" value="" title = "Enter your password"></p>
		<br/>
		<input id="logsubmit" type="submit" value="Enter" title = "Log into system">
		<br/>
		<br/>
		
		<div id="authentication"><?=validation_errors()?></div>
	</form>
</div>