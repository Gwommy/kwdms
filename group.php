<?php
/*
 * KWDS Add A SCA Group
 */
require('includes/init.php');
require('header.php');

if (!$session->isLoggedIn()) {
    echo '<div class="box error">You do not have permission to view this page.</div>';
    redirect('index');
    include_once('includes/footer.php');
    die;
}
else {
    if (isset($_POST['name']) and $_POST['name']!="") {
        $db->insert_group($_POST['name'], $_POST['url'], $_POST['kingdom']);
        echo '<div class="box success">The group was successfully added!</div>';
    }
    if (isset($_POST['name']) and $_POST['name']=="") {
        echo '<div class="box warning">You must enter a name for the group.</div>';
    }

?>
<h1>Add A New SCA Group</h1>
<form class="form" action="group.php" method="post">
    <ul>
        <li><label>Group Name: </label> <input name="name" type="textbox" /></li>
        <li><label>Group Website: </label> <input name="url" type="textbox" /></li>
        <li><label for="kingdom">Kingdom:</label><?php $db= new db(); $result=$db->get_list('kingdom');
            dropdown($result, "kingdom", 0); ?></li>
        <li><label></label> <input type="submit" name="add" value="Add Group" /></li>

    </ul>
</form>
<?php
}
include_once('footer.php');
?>