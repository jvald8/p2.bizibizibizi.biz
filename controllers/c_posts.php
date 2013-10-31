<?php 
class posts_controller extends base_controller {
	
	public function __construct() {
		parent::__construct();

		# Make sure user is logged in if they want to use anything in this controller
		if(!$this->user) {
			die("Members only. <a href='/users/login'>Login</a>");
		}
	}

	public function add() {

		# Setup view
		$this->template->content = View::instance('v_posts_add');
		$this->template->title   = "New Post";

		# Render template
		echo $this->template;
	}

	public function p_add() {

		# Associate this post with the user
		$_POST['user_id'] = $this->user->user_id;

		# Unix timestamp of when this was created and modified
		$_POST['created']  = Time::now();
		$_POST['modified'] = Time::now();

		# Insert
		DB::instance(DB_NAME)->insert('posts', $_POST);

		# feedback
		echo "Your post has been added. <a href='/posts/add'>Add another</a>";

	}

	public function index() {

		# Set up the view
		$this->template->content = View::instance('v_posts_index');
		$this->template->title   = "Posts";

		# Build the query
		$q = "SELECT 
				posts .* ,
				users.first_name,
				users.last_name
			FROM posts
			INNER JOIN users
				ON posts.user_id = users.user_id";

		# Run Query
		$posts = DB::instance(DB_NAME)->select_rows($q);

		# Pass data to the View
		$this->template->content->posts = $posts;

		# Render the View
		echo $this->template;
		
	}
}