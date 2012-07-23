<?php
/*
 * KWDS Class Submission Page
 */
require_once('includes/header.php');
// Make sure the user is logged in or he can't submit a class
if (!$session->isLoggedIn()) {
    echo '<div class="box error">You need to be logged in order to submit a class.</div>';
    redirect('index');
    include_once('includes/footer.php');
    die;
}
// Verify that the class has a title
if (isset($_POST['name']) AND $_POST['name']=="") {
    echo '<div class="box warning">Please enter a name or title for your class.</div>';
    show_class_form();
}
// Verify that the class includes a description
elseif (isset($_POST['desc']) AND $_POST['desc']=="") {
    echo '<div class="box warning">Please enter a brief description about your class.</div>';
    show_class_form();
}
// Verify that the hours is entered correctly
elseif (isset($_POST['hours']) AND ($_POST['hours']*60+$_POST['minutes'] < 10)) {
    echo '<div class="box error">Your class should not be less than 10 minutes long.</div>';
    show_class_form();
}
elseif (isset($_POST['class'])) {
    $aero=$_POST['aerobic'];
    $desc=sanit($_POST['desc']);
    $diff=$_POST['difficulty'];
    $era=$_POST['era'];
    $fee=(isset($_POST['fee']))?$_POST['fee']:0;
    $hours=($_POST['hours']*60)+$_POST['minutes'];
    $kwds=$_POST['kwds'];
    $limit=(isset($_POST['limit']))?$_POST['limit']:0;
    $name=sanit($_POST['name']);
    $type=$_POST['type'];
    $url=sanit($_POST['url']);
    $user=$_SESSION['user_id'];
    $db->insert_class($aero, $desc, $diff, $era, $fee, $hours, $kwds, $limit, $name, $type, $url, $user);
    echo '<div class="box success">You have successfully submitted your class.</div>';
    redirect('index');
}
else {
    show_class_form();
}

require('footer.php');

// This function shows the class form
function show_class_form() { ?>
<form class="form" name="class" action="class.php" method="post">
    <h1>New Class Submission</h1>
    <ul>
        <li><label for="name">Class Name:</label><input type="text" name="name"
            <?php if (isset($_POST['name'])) { echo 'value="'.$_POST['name'].'"'; } ?> /></li>
        <li><label for="desc">Class Description:</label><textarea name="desc" cols="50" rows="10"></textarea></li>
        <li><label for="hours">Length of Class:</label><?php dropdown_num('hours', 0, 8); echo 'Hrs '; dropdown_num('minutes', 0, 55, 5); echo 'Minutes'; ?></li>
        <li><label for="fee">Class Fee:</label><input type="text" name="fee" /></li>
        <li><label for="difficulty">Suggested Skill Level:</label><?php $db=new db; $result=$db->get_list('difficulty'); dropdown($result, 'difficulty') ?></li>
        <li><label for="aerobic">Aerobic Level:</label><?php $result=$db->get_list('aerobic'); dropdown($result, 'aerobic') ?></li>
        <li><label for="era">Time Period:</label><?php $result=$db->get_list('era'); dropdown($result, 'era') ?></li>
        <li><label for="type">Type of Class:</label><?php $result=$db->get_list('type'); dropdown($result, 'type') ?></li>
        <li><label for="limit">Attendance Limit:</label><input type="text" name="limit" /></li>
        <li><label for="url">URL for Class Notes:</label><input type="text" name="url" /></li>
        <li><label for="submit">KWDS Submission:</label> <?php $result=$db->get_kwds_submissions(); dropdown($result, 'kwds') ?></li>
        <li><label> </label><input type="submit" class="button" name="class" /></li>
    </ul>
</form>
<?php } ?>