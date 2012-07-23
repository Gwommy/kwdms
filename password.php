<?php
/*
 * KWDS Password Retrieval Page
 */
require_once('includes/header.php');

// Check to see if an email was submitted
if (isset($_POST['email']) AND check_email_address($_POST['email'])) {

    // If a valid email is submitted, send a email to change password
    if ($db->email_exist($_POST['email'])) {
        $random=random_gen(32);
        $db->setup_password($_POST['email'], $random);
        $message = 'To reset your password, please visit the following page: '.SITE_URL.'/reset.php?x='.$random;
        mail($_POST['email'], 'KWDS Password Reset', $message, 'From: no_reply@kwds.org');
        echo '<div class="box success">Password reset instructions have successfully been sent to your email address.</div>';
        redirect('index');
        include_once('includes/footer.php');
        die;
    }
    else {
        echo '<div class="box error">That email is not in our system.</div>';
    }
}
// If the email is not valid, show warning
elseif (isset($_POST['email'])) {
    echo '<div class="box error">That is not a valid email address.</div>';
}

// Password Reset Form
?>
<h1>Password Reset</h1>
<p>Please submit your email address. If your email is in our system, you will be sent an email with instructions to reset your password.</p>
<form class="form" action="password.php" method="post">
    <ul>
        <li><label>Enter Email:</label><input type="text" name="email" /></li>
        <li><label></label><input class="button" type="submit" value="Send Me an Email" /></li>
    </ul>
</form>

<?php require('includes/footer.php'); ?>