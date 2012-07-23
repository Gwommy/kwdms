<?php
/*
 * KWDS Logout Page
 */

require('includes/init.php');

$session->logout();

require('header.php');

echo '<div class="box success">You have successfully logged out!</div>';
redirect('index');

require('footer.php');