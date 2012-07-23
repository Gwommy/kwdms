<?php
/*
 * KWDS Adding a Room
 */
require_once('includes/header.php');

if (isset($_SESSION['user_id']) AND can_add_rooms($_SESSION['user_id'])) {
    if (isset($_POST['name']) AND $_POST['name']!="") {
        $db->insert_room($_POST['name'], $_POST['building'], $_POST['size'], $_POST['kwds'], $_POST['notes']);
        echo '<div class="box success">The room has been successfully added!</div>';
    }
    elseif (isset($_POST['name']) AND $_POST['name']=="") {
        echo '<div class="box error">You must enter a name for the room. Please try again.</div>';
    }

?>
<h1>Add A Room</h1>
<form class="form" action="room.php" method="post">
    <ul>
        <li><label>Room Name:</label> <input type="textbox" name="name" /></li>
        <li><label>Building (optional):</label> <input type="textbox" name="building" /></li>
        <li><label>Floor:</label> <?php dropdown_num('floor', 0, 10);?></li
        <li><label>Size:</label> <input type="textbox" name="size" /></li>
        <li><label>Notes:</label> <textarea name="notes" cols="50" rows="5"></textarea></li>
        <?php if (is_super_user($_SESSION['user_id'])) {
            echo'
        <li><label>KWDS:</label> <input type="number" name="kwds" value="'.$kwds['KWID'].'" />';
        } else {
            echo '<input type="hidden" name="kwds" value="'.$kwds['KWID'].'" />';
        } ?>
        <li><label></label> <input type="submit" class="button" value="Add Room" /></li>
    </ul>
</form>
<?php
} else {
    echo '<div class="box error">You do not have permission to view this page.</div>';
    redirect('index');
}

require('footer.php'); ?>