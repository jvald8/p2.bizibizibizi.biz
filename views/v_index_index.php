<h1>Welcome to <?=APP_NAME?></h1>
<?php if($user): ?>

	<!-- <pre>
	<?php
	//print_r($user);
	?> -->
	</pre>
	<h2>Hello <?=$user->first_name;?></h2>
<?php else: ?>
	<h3 id='intro'>Welcome to <?=APP_NAME?>. Where users can complain about, applaud, seek advice on, or just peruse various mustaches. Please <a href='/users/signup'>sign up</a> or <a href='/users/login'>log in.</a></h3>
	<br>
	<em>The two extra features are a profile editing and guard against email duplication.</em>
<?php endif; ?>


