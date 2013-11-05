<form method='POST' action='/users/p_login'>

	<div id='loginForm'>	
		<div id='loginEmail'>
			Email<br>
			<input type='text' name='email'>
		</div>

			<br>
		<div id='loginPassword'>
			Password<br>
			<input type='password' name='password'>
		</div>
	</div>

	<br>

	<?php if(isset($error)): ?>
		<div class='error'>
			Login failed. Please double check your email and password.
		</div>
		<br>
	<?php endif; ?>
	<div id='loginSubmitButton'>
		<input type='submit' value='Log in'>
	</div>

</form>