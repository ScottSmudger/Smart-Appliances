<div id="description">
	<h3 id="desHeading">Welcome to the Group 11 Smart Appliances Web Application Service</h3>
	<p id="desinfo">Please enter your username and password below</p>
</div>
</br>
<div id="loginSection">
	<?=form_open("authenticate")?>
<<<<<<< HEAD
		</br>
		</br>
		<p id="entryFields">Username: <input id="username" type="text" name="username" value="<?=set_value('username')?>" title = "Enter your username"></p>
		</br></br>
		<p id="entryFields">Password: <input id="passowrd" type="password" name="password" value="" title = "Enter your password"></p>
		</br>
		<input id="logsubmit" type="submit" value="Enter" title = "Log into system">
		</br>
		</br>
=======
		</br></br>
		<p id="entryFields">Username: <input id="username" type="text" name="username" value="<?=set_value('username')?>"></p>
		</br></br>
		<p id="entryFields">Password: <input id="passowrd" type="password" name="password" value=""></p>
		</br>
		<input id="logsubmit" type="submit" value="Enter">
		</br></br>
>>>>>>> 316dc7366d7d9d810cc08feb625d8ecae2d073f8
		
		<div id="authentication"><?=validation_errors()?></div>
	</form>
</div>
