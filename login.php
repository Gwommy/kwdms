<?php

/*
 * KWDS User Login Page
 */
require_once('./includes/header.php');

// If you're not logged in, display the login form.
if (!isset($_POST['login'])) {
    get_login_form();
} 
// If password or username is blank, give error and display login form
else if ($_POST['username'] == '' || $_POST['password'] == '') {
    echo '<div class="box error">Please enter your username or email and your password.</div>';
    get_login_form();
} else {
    // Get input from login form
    $username = sanit($_POST['username']);
    $password = sanit(md5($_POST['password']));

    // Check if the 'remember me' box has been checked
    $remember = (isset($_POST['remember'])) ? TRUE : FALSE;

    // Check input against database
    $result = $db->login($username, $password, $remember);

    if (count($result) > 0) {
        echo '<div class="box success">You have successfully logged in!</div>';
        redirect('index');
    } else {
        echo '<div class="box error">The username, email or password you entered is incorrect. Please try again.</div>';
        get_login_form();
    }
}
require('footer.php');

// Display the login form
function get_login_form() {
    global $session;

    if (!$session->isLoggedIn()) {
        echo '<div class="box attention">Please enter your username or email and your password, or <a href="./register.php">Register</a> a new account.</div>';
        echo '
            <form class="form submit_form" method="post" action="./login.php">
	    	<ul>
	    		<li><label for="username">Username or Email:</label> <input type="text" name="username" id="username" /></li>
	    		<li><label for="password">Password:</label> <input type="password" name="password" id="password" /></li>
	    		<li class="remember"><label for="remember"><a href="password.php">Forgot Password?</a></label><label><input type="checkbox" id="remember" name="remember" />Remember Me</label></li>
	    		<li><label> </label><input class="button" type="submit" name="login" value="Login" /></li>
	    	</ul>
            </form>';
    // Otherwise the user is logged in, display error and redirect back to main page
    } else {
        echo '<div class="box error">You are already logged in!</div>';
        redirect('index');
    }
}

?>