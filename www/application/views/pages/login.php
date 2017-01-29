<main>
	<div id="description">
		<h3 id="desHeading">Welcome to the Group 11 Smart Appliances Web Application Service</h3>
		<p id="desinfo">Please enter your username and password below.</p>
	</div>
	</br>
	<div id="loginSection">
		</br></br>
		<?=validation_errors()?>
		<?=form_open("authenticate")?>
		<p id="entryFields">Username: <input id="username" type="text" name="username" value="<?=set_value('username')?>"></p>
		</br></br>
		<p id="entryFields">Password: <input id="passowrd" type="password" name="password" value="<?=set_value('password')?>"></p>
		</br>
		<input type="submit" value="Enter">
		</form>
	</div>
</main>
