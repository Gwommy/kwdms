<?php
/*
 * KWDS Password Reset
 */
require_once('includes/header.php');


if (isset($_GET['x']) AND $db->verify_value($_GET['x'])) {
    if (isset($_POST['pass']) AND $_POST['pass1']==$_POST['pass2']) {
        // verify email and x match
        $uid=$db->verify_email($_GET['x'], $_POST['email']);
        if ($uid!=0) {
            // remove password reset value
            $db->delete_reset($uid);
            //change password
            $db->update_password($uid, $_POST['email'], sanit(md5($_POST['pass1'])));
            echo '<div class="box success">Your password has been changed. You will not be logged in.</div>';
            //*redirect('login');
            $result = $db->login($_POST['email'], sanit(md5($_POST['pass1'])), 'yes');
            redirect('index');
            
            include_once('includes/footer.php');
            die;
        }
    }
?>
<h1>Change Password</h1>
<form class="form" action="reset.php?x=<?php echo $_GET['x']; ?>" method="post">
    <ul>
        <li><label>Verify Email Address:</label><input type="text" name="email" /></li>
        <li><label>Enter New Password:</label><input type="password" name="pass1" /></li>
        <li><label>Verify Password:</label><input type="password" name="pass2" /></li>
        <li><label></label><input type="submit" class="button" name="pass" value="Change Password" /></li>
    </ul>
</form>
<?php
}
else {
    echo '<div class="box error">You do not have proper documentation to be here.</div>';
    redirect('index');
}

require('footer.php'); ?>
