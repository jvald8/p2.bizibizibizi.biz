<h1>Welcome to <?=APP_NAME?></h1>
<?php if($user): ?>

	<pre>
	<?php
	print_r($user);
	?>
	</pre>
	<h2>Hello <?=$user->first_name;?></h2>
<?php else: ?>
	Welcome to my app. Please sign up or log in.
<?php endif; ?>


