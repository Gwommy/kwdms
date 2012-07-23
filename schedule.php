<?php
/*
 * KWDS Schedule
 */
require_once('includes/header.php');

// Determine if a class was clicked on for individual viewing
$cid = (isset($_GET['id'])) ? $_GET['id'] : 0;
$result = $db->get_class($cid);

// Get the class information and store it in variables
if (count($result) > 0) {
    $class_name = $result['ClassName'];
    $uid = $result['UserID'];
    $sca_name = $result['Title'] . ' ' . $result['SCAFirst'] . ' ' . $result['SCALast'];
    $mundane_name = $result['PrefixName'] . ' ' . $result['MundaneFirst'] . ' ' . $result['MundaneLast'];
    $room = $result['RoomName'];
    $desc = redisplay(redisplay($result['ClassDescription']));
    $start_time = date('l \a\t g:iA', (strtotime($result['day'])));
    $length = $result['hours'];
    $type = $result['type_id'];

    // Display the class information
    echo '<div class="class_info">
        <h2>' . $class_name . '</h2>
        <ul>
            <li><label class="bold">Instructor: </label> <a href="profile.php?id=' . $uid . '">' . $sca_name;
        if ($mundane_name != "  ") {
            echo' (' . $mundane_name . ')';
        }
        echo'</a></li>
            <li><label class="bold">Schedule: </label> ' . $room . ' on ' . $start_time . '</li>
        </ul>
        <p>' . $desc . '</p>
    </div>';
}
$where="type_id>0";
?>

<script language="JavaScript" type="text/javascript">

    function form_submit(id) {
        document.forms["class_form"].action="schedule.php?kwds=<?php echo $kwds['KWID']; ?>&id="+id;
        document.forms["class_form"].submit();
    }

    function my_schedule() {
        document.forms["class_form"].action="myschedule.php?kwds=<?php echo $kwds['KWID'];; ?>";
        document.getElementById("button").submit();
        //document.forms["class_form"].submit();
    }

</script>
<?php // Display the legend and the schedule ?>
<h1>Schedule for KWDS <?echo roman($kwds['KWID']);?></h1>
<form id="class_form" method="post">
<div class="schedule legend">
    <div class="th"><u>Legend</u><br />Black is not rated</div>
    <div class="class europ">European Dance Class <br />(Green Border)<br /><input type="checkbox" name="europ" value="europ" onclick="form_submit(0)"
        <?php if (isset($_POST['europ'])) {echo 'checked="checked" '; $where.=" AND type_id!='2'";} ?> />Hide</div>
    <div class="class meast">Middle Eastern <br />Dance Class<br />(Red Border)<br /><input type="checkbox" name="meast" value="meast" onclick="form_submit(0)"
        <?php if (isset($_POST['meast'])) {echo 'checked="checked" '; $where.=" AND type_id!='3'";} ?>/>Hide</div>
    <div class="class music">Music Class<br />(Blue Border)<br /><input type="checkbox" name="music" value="music" onclick="form_submit(0)"
        <?php if (isset($_POST['music'])) {echo 'checked="checked" '; $where.=" AND type_id!='4'";} ?>/>Hide</div>
    <div class="class beg">Beginner's Class<br />(Green Text)</div>
    <div class="class int">Intermediate Class<br />(Blue Text)</div>
    <div class="class adv">Advanced Class<br />(Red Text)</div>
</div>
<?php

// Determines number of days that this KWDS lasts
$kday = 0;
$keday = (date('z', strtotime($kwds['end_date'])) - date('z', strtotime($kwds['start_date'])));
for ($kday; $kday <= $keday; $kday++) {
    $result = $db->get_rooms($kwds['KWID']);

    // Show message if there are no rooms submitted for this KWDS
    if (count($result) < 1) {
        echo '<div class="box attention">There are no rooms available for this KWDS yet.</div>';
        $kday = $keday;
    }

    else {
        $newdate=strtotime('+'.($kday)." day", strtotime($kwds['start_date']));
        echo '
<div class="schedule" ><h2>Day ' . ($kday+1) . ': '.date('l',$newdate).'</h2>
    <div class="tr">
        <div class="time">TIME</div>';
        for ($i = 9; $i != 6; $i++) {
            echo '
        <div class="hour">' . $i . ':00</div>';
            if ($i >= 12) {
                $i = 0;
            }
        }
        echo '
    </div>';
        foreach ($result as $row) {
            echo'
    <div class="tr">';
            $rooms = $db->get_class_rooms($row['id'], date('z', strtotime($kwds['start_date'])) + $kday + 2, $where);
            if (count($rooms) > 0) {
                echo'
        <div class="th">' . $row['name'] . '</div>';
                foreach ($rooms as $room) {
                        echo '<div class="class';
                        switch ($room['type_id']) {
                            case 2:
                                echo ' europ';
                                break;
                            case 3:
                                echo ' meast';
                                break;
                            case 4:
                                echo ' music';
                                break;
                            default:
                                break;
                        }
                        switch ($room['difficulty_id']) {
                            case 2:
                                echo ' beg';
                                break;
                            case 3:
                                echo ' int';
                                break;
                            case 4:
                                echo ' adv';
                                break;
                            default:
                                break;
                        }
                        $thistime = strtotime($room['day']);
                        echo '" style="width:' . ($room['hours'] * 1.1) . 'px; position: absolute; margin-left: ' . $room['time'] . 'px;"
                        title="' . $room['ClassName'] . ' - ' . $room['description'] . '">
                        <input class="mark" type="checkbox" name="c' . $room['ClassID'] . '" value="' . $room['ClassID'] . '"';
                        if (isset($_POST['c' . $room['ClassID']]) AND $_POST['c' . $room['ClassID']] == $room['ClassID']) {
                            echo ' checked="checked"';
                        }
                        echo ' /><a onclick="form_submit(' . $room['ClassID'] . ')"><div class="title">' . date('g:iA', $thistime) . ' ' . $room['ClassName'] . '</div>
                        <div class="user"> ' . $room['user'] . '</div></a></div>';
                }
            }
            echo '</div>';
        }
        echo '</div>';
    }
}
?>
    <input id="button" type="submit" class="button" name="checkboxes" onclick="my_schedule()" value="Show My Schedule" />
</form>
<div class="schedule unschedule"><h2 class="unschedule">Unscheduled Classes</h2>
<?php
$classes = $db->get_unscheduled_classes($kwds['KWID']);

if (count($classes) > 0) {
    foreach ($classes as $class) {
        echo '<a href="schedule.php?kwds=' . $kwds['KWID'] . '&id=' . $class['id'] . '"><div class="class';
        
        switch ($class['type_id']) {
            case 2:
                echo ' europ';
                break;
            case 3:
                echo ' meast';
                break;
            case 4:
                echo ' music';
                break;
            default:
                break;
        }
        
        switch ($class['difficulty_id']) {
            case 2:
                echo ' beg';
                break;
            case 3:
                echo ' int';
                break;
            case 4:
                echo ' adv';
                break;
            default:
                break;
        }
        
        echo '" style="width:' . ($class['hours'] * 1.1) . 'px;" >' . $class['name'] . '</div></a>';
    }
}
?>
</div>

<?php require('footer.php'); ?>