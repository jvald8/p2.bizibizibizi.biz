<?php foreach($users as $user): ?>

	<div class='postsUsers'>
	<!-- Print the user's name -->
	<?=$user['first_name']?> <?=$user['last_name']?>

	<!-- If there exists a connection with this user, show an unfollow link -->
	<?php if(isset($connections[$user['user_id']])): ?>
		<a href='/posts/unfollow/<?=$user['user_id']?>'>Unfollow</a>

	<!-- Otherwise, show the follow link -->
	<?php else: ?>
		<a href='/posts/follow/<?=$user['user_id']?>'>Follow</a>
	<?php endif; ?>

	
	</div>

<?php endforeach ?>
	

