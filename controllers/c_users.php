<?php
class users_controller extends base_controller {

    public function __construct() {
        parent::__construct();
        
    } 

    public function index() {
        echo "This is the index page";
    }

    public function signup() {
        # Setup view
            $this->template->content = View::instance('v_users_signup');
            $this->template->title   = "Sign Up";

        # Render template
            echo $this->template;
    }

    public function p_signup() {
    
            # Sanitize Data Entry
            $_POST = DB::instance(DB_NAME)->sanitize($_POST);
    
            # Set up Email / Password Query
            $q = "SELECT * FROM users WHERE email = '".$_POST['email']."'"; 
            
            # Query Database
            $user_exists = DB::instance(DB_NAME)->select_rows($q);
            
            # Check if email exists in database
            if(!empty($user_exists)){
                            
            # Send to Login page
                    
                    Router::redirect('/users/login');

                }
                            
                else {
                                    
                    # Mail Setup
                        $to = $_POST['email'];
                        $subject = "Welcome to Jon's App!";
                        $message = "Thanks for signing up with Jon's App";
                        $from = 'jvald8@gmail.com';
                        $headers = "From:" . $from;         
                                    
                    # More data we want stored with the user
                        $_POST['created'] = Time::now();
                        $_POST['modified'] = Time::now();
                    
                        # Encrypt password
                        $_POST['password'] = sha1(PASSWORD_SALT.$_POST['password']);
                    
                        # Create encrypted token via email and random string
                        $_POST['token'] = sha1(TOKEN_SALT.$_POST['email'].Utils::generate_random_string());
                    
                        # Insert this user into the database
                        $user_id = DB::instance(DB_NAME)->insert('users', $_POST);
                    
                        # Send Email
        if(!$this->user) {
                    mail($to, $subject, $message, $headers);
        }         
                    
                        # Send to the login page
                        Router::redirect('/users/login');
            }
    }//</cm>


    public function login($error = NULL) {
        //echo "This is the login page";
        # Set up the view
            $this->template->content = View::instance('v_users_login');
            $this->template->title   = "Login";

        # Pass data to the view
            $this->template->content->error = $error;

        # Render template
            echo $this->template;

    }

    public function p_login() {

        # Sanitize the user entered data to prevent funny business
        $_POST = DB::instance(DB_NAME)->sanitize($_POST);

        # Hash submitted password so we can compare it against one in the db
        $_POST['password'] = sha1(PASSWORD_SALT.$_POST['password']);

        # Search the db fpr this email and password
        # Retrieve the token if it's available
        $q = "SELECT token
            FROM users
            WHERE email = '".$_POST['email']."' 
            AND password = '".$_POST['password']."'";

        $token = DB::instance(DB_NAME)->select_field($q);

        # If we didn't find a matching token in the db, it means login failed
        if(!$token) {

            Router::redirect("/users/login/error");
                

        # But if we did, login succeeded!
        } else {

            
            /* 
            Store this token in a cookie using setcookie()
            Important Note: *Nothing* else can echo to the page before setcookie is called
            Not even one single white space.
            param 1 = name of the cookie
            param 2 = the value of the cookie
            param 3 = when to expire
            param 4 = the path of the cookie (a single forward slash sets it for the entire domain)
            */
            setcookie("token", $token, strtotime('+2 weeks'), '/');
            

            # Send them to the main page - or wherevr you want them to go
            Router::redirect("/");
            # Send them back to the login page
        }
    }

    public function logout() {
        # echo "This is the logout page";
        # Generate and save a new token for next login
        $new_token = sha1(TOKEN_SALT.$this->user->email.Utils::generate_random_string());

        # Create the data array we'll use with the update method
        # In this case, we're only updating one field, so our array only has one entry
        $data = Array("token" => $new_token);

        # Do the update
        DB::instance(DB_NAME)->update("users", $data, "WHERE token = '".$this->user->token."'");

        # Delete their token cookie by setting it to a date in the past, logging them out
        setcookie("token", "", strtotime('-1 year'), '/');

        # Send them back to the main index.
        Router::redirect("/");
    }

    public function profile($user_name = NULL) {

        if(!$this->user) {//$user_name == NULL) {
            //echo "No user specified";
            //echo "$user_name";
            //Router::redirect('/');
            die('Members only. <a href="/users/login">Login</a>');
        }
        else {
            echo "This is the profile for ".$this->user->first_name;
            
            echo '<a href="/users/profile_edit"> Edit Profile</a>';
        }
    }

    public function profile_edit() {
        // Set up the view
        $this->template->content = View::instance('v_users_profile_edit');
        $this->template->title   = "Edit Profile";

        // Render the view
        echo $this->template;

    }


    public function p_profile_edit() {


        $q = "UPDATE    users
            SET         first_name = '".$_REQUEST['first_name']."',
                        last_name = '".$_REQUEST['last_name']."',
                        email = '".$_REQUEST['email']."'
            WHERE       email = '".$this->user->email."'";

        DB::instance(DB_NAME)->query($q);
        Router::redirect("/users/profile");

        // Send them back to the login page with a success message
        #Router::redirect("/users/profile"); 

        
    }

} # end of the class