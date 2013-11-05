<!DOCTYPE html>
<html>
<head>
	
	<title><?php if(isset($title)) echo $title; ?></title>

	
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />	
	<!--<?php //echo '<link rel="stylesheet" href="p2.StyleSheet.css" type="text/css">'; ?>-->				
	<!-- Controller Specific JS/CSS -->
	<?php if(isset($client_files_head)) echo $client_files_head; ?>
	<link rel="stylesheet" href="/css/p2StyleSheet.css" type="text/css">
	<link href='http://fonts.googleapis.com/css?family=Raleway' rel='stylesheet' type='text/css'>


	
</head>

<body>	

	<div id='menu'>

		<a href='/'>Home</a>

		<!-- Menu for users who are logged in -->
		<?php if($user): ?>

			<a href='/users/logout'>|Logout</a>
			<a href='/users/profile'>|Profile</a>
			<a href='/posts/add'>|Add a Post!</a>
			<a href='/posts'>|Browse Posts!</a>
			<a href='/posts/users'>|Follow Somebody</a>

		<!-- Menu options for users who are not logged in -->
		<?php else: ?>

			<a href='/users/signup'>Sign up</a>
			<a href='/users/login'>Log in</a>

		<?php endif; ?>
	</div>

	<br>

	<?php if(isset($content)) echo $content; ?>


	<?php if(isset($client_files_body)) echo $client_files_body; ?>
</body>
</html>