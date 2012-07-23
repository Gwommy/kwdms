<?php

/*
 * KWDS Sessions Class File
 */

class Session {
    public $user_id;    // The user ID of the logged in user

    // Function to start the session
    function __construct() {
        session_start();

        // Check if the user has a cookie set, use it on the session variable
        if (isset($_COOKIE['user'])) {
            $_SESSION['user_id'] = $_COOKIE['user'];
        }
    }

    // Returns true or false whether the user is logged in or not
    public function isLoggedIn() {
        if (isset($_SESSION['user_id'])) {
            $this->user_id = $_SESSION['user_id'];
            return true;
        }
        return false;
    }

    // Create a session variable based on the user's ID
    public function login($id, $remember) {
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['user_id'] = $id;

            // If remember is checked, set the cookie's expiration time to a month
            if ($remember) {
                $expire = time() + 60 * 60 * 24 * 30;
                setcookie('user', $id, $expire);
            }
        } else {
            get_error_page('You are already logged in!');
        }
    }

    // Logout method
    function logout() {
        session_destroy();
        $this->isLoggedIn = false;
        setcookie('user', '', time() - 3600);
    }

}