<?php
/*
 * KWDS Sending an Email
 */
require('includes/init.php');

if (isset($_POST['message'])) {
    $to = $db->get_user_email($_POST['uid']);
    $from = $db->get_user_email($_SESSION['user_id']);
    $message = 'This message was sent via kwds.org:'.escape_query($_POST['message']);
    mail($to, '[KWDS]'.$_POST['subject'], redisplay($message), 'FROM: '.$from);
}

require('header.php');

if (!isset($_SESSION['user_id'])) {
    echo '<div class="box error">You must be logged in to send an email to another user.</div>';
    redirect('login');
}
elseif (isset($_POST['message'])) {
    echo '<div class="box success">Your email has been sent!</div>';
    redirect('index');
}
elseif (!isset($_POST['uid'])) {
    echo '<div class="box error">To send an email, go to the user\'s profile page</div>';
    redirect('index');
}
else {
?>

<h1>Send an Email</h1>
<div class="box attention">When sending an email to another user, your email will be sent so the user can reply directly you.</div>
<form action="email.php" method="post" class="form">
    <ul>
        <li><label>To:</label><input type="text" readonly="readonly" value="<?php echo $db->get_username($_POST['uid']) ?>" /></li>
        <li><label>Subject:</label><input type="text" name="subject" /></li>
        <li><label>Message:</label><textarea name="message" cols="50" rows="5"></textarea> </li>
        <li><label></label><input type="submit" class="button" value="Send Email" /></li>
    </ul>
    <input type="hidden" name="uid" value="<?php echo $_POST['uid'] ?>" />
</form>

<?php }
require('footer.php'); ?>