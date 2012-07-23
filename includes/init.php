<?php
/**
 * KWDS System Initialization File
 * 
 * Initializes subsystems and sets up some default variables for use across all
 * pages.
 */
//ob_start(); //TODO: DELETE ME AFTER SEPARATING BUSINESS AND PRESENTATIONAL LOGIC!

// Include and setup the database
require('includes/db.class.php');
$db=new db();

// Include extra functions and start the session
require('includes/functions.php');
require('includes/session.php');
$session = new Session;

// Determine which KWDS to display
if (!isset($_GET['kwds']) OR !is_numeric($_GET['kwds'])) {
    $_GET['kwds']=0;
}
// Get KWDS information and store it in variables
$kwds = $db->get_kwds($_GET['kwds']);