<?php

/*
 * KWDS Class Listing
 */
require_once('includes/header.php');

echo'<h1>Classes</h1>';
$result = $db->get_class_info($kwds['KWID']);
if (count($result) == 0) {
    echo'<p>There are no classes scheduled for this event yet.</p>';
} else {
    echo'<p>There are ' . count($result) . ' classes.</p>';

    foreach ($result as $row) {
        $class_name = $row['ClassName'];
        $uid = $row['UserID'];
        $sca_name = $row['Title'] . ' ' . $row['SCAFirst'] . ' ' . $row['SCALast'];
        $mundane_name = $row['PrefixName'] . ' ' . $row['MundaneFirst'] . ' ' . $row['MundaneLast'];
        $room = $row['RoomName'];
        $desc = redisplay($row['ClassDescription']);
        $start_time = date('l \a\t g:iA', (strtotime($row['day'])));
        $length = $row['hours'];
        $type = $row['type_id'];
        echo'
<div class="class_info">
    <h2>' . $class_name . '</h2>
    <ul>
        <li><label class="bold">Instructor: </label> <a href="profile.php?id='.$uid.'">' . $sca_name;
        if ($mundane_name != "  ") {
            echo' (' . $mundane_name . ')';
        }
        echo'</a></li>
        <li><label class="bold">Schedule: </label> ' . $room . ' on ' . $start_time . '</li>
    </ul>
    <p>' . $desc . '</p>
</div>
        ';
    }
    $result = $db->get_unscheduled_classes($kwds['KWID']);

    if (count($result) > 0) {
        echo '
<h2>Unscheduled or Canceled Classes</h2>
    <ul>';
        foreach ($result as $row) {
            echo '
        <li>' . $row['name'] . '</li>';
        }
        echo '
    </ul>';
    }
}

require('footer.php'); ?>