<?php
/*
 * KWDS Schedule
 */
require_once('includes/header.php');

// Make sure the user is logged in as a user that can edit the schedule
if (!(can_add_rooms($_SESSION['user_id']) AND $kwds['KWID'] >= $db->get_kwds_number() OR is_super_user())) {
    echo 'div class="box error">You do not have permissions to view this page.</div>';
    redirect('index');
    include_once(includes/footer.php);
    die;
}
// If the "UNSCHEDULE" button was pressed, remove that class from the schedule
if (isset($_POST['unschedule'])) {
    $db->remove_from_schedule($_POST['cid']);
    echo '<div class="box success">The class was removed from the schedule.</div>';
}
// If the "ADD TO SCHEDULE" button was pressed, update the class info
if (isset($_POST['class'])) {
    $cid=$_POST['cid'];
    $name=sanit($_POST['name']);
    $desc=sanit($_POST['desc']);
    $hours=$_POST['hours']*60+$_POST['minutes'];
    $type=$_POST['type'];
    $room=$_POST['room'];
    $aero=$_POST['aerobic'];
    $diff=$_POST['difficulty'];
    $time=($_POST['hour']<8)?$_POST['hour']+12:$_POST['hour'];
    $era=$_POST['era'];
    $date=$_POST['date'].' '.$time.':'.$_POST['minute'].':00';
    $db->update_class($aero,$cid,$date,$desc,$diff,$era,$hours,$name,$room,$type);
}

$cid = (isset($_GET['id'])) ? $_GET['id'] : 0;
$result = $db->get_class($cid);
if (count($result) >0) {
    $class_name = $result['ClassName'];
    $desc = redisplay($result['ClassDescription']);
    $room = $result['RoomName'];
    $room_id = $result['RoomID'];
    $length = $result['hours'];
    $hour = intval($length / 60);
    $minute = $length % 60;
    $diff = $result['DifficultyID'];
    $aero = $result['AerobicID'];
    $era = $result['EraID'];
    $type = $result['type_id'];
    $hr = date('g', (strtotime($result['day'])));
    $min = date('i', (strtotime($result['day'])));
    $uid = $result['UserID'];
    $cdate= date('Y-m-d', (strtotime($result['day'])));
    $sca_name = $result['Title'] . ' ' . $result['SCAFirst'] . ' ' . $result['SCALast'];
    $mundane_name = $result['PrefixName'] . ' ' . $result['MundaneFirst'] . ' ' . $result['MundaneLast'];
?>
<form class="form" action="class_schedule.php?kwds=<?php echo $kwds['KWID'] ?>" method="post">
<div class="class_info">
    <ul>
        <li><label for="name">Class Name:</label><input type="text" name="name"<?php echo 'value="'.$class_name.'"'; ?> /></li>
        <li><label>Teacher:</label><?php echo $sca_name; if ($mundane_name!="  ") { echo' ('.$mundane_name.' )'; } ?></li>
        <li><label for="desc">Class Description:</label><textarea name="desc" cols="50" rows="10"><?php echo $desc ?></textarea></li>
        <li><label for="hours">Length of Class:</label><?php dropdown_num('hours', 0, 8, 1,$hour); echo 'Hrs '; dropdown_num('minutes', 0, 55, 5, $minute); echo 'Minutes'; ?></li>
        <li><label for="difficulty">Suggested Skill Level:</label><?php $db=new db; $result=$db->get_list('difficulty'); dropdown($result, 'difficulty', $diff) ?></li>
        <li><label for="aerobic">Aerobic Level:</label><?php $result=$db->get_list('aerobic'); dropdown($result, 'aerobic', $aero) ?></li>
        <li><label for="era">Time Period:</label><?php $result=$db->get_list('era'); dropdown($result, 'era', $era) ?></li>
        <li><label for="type">Type of Class:</label><?php $result=$db->get_list('type'); dropdown($result, 'type', $type) ?></li>
        <?php 
        $result=$db->get_rooms($kwds['KWID']); 
        if (count($result)==0) {
            echo '<div class="box error">You need to add rooms to the event before you can schedule any classes.</div>';
        }
        else {
            echo '<li><label for="room">Room:</label>';
                dropdown($result, 'room', $room_id);
            echo'</li>';
            echo '<li><label for="hours">Start Time:</label>';
                dropdown_num('hour', 1, 12, 1,$hr);
            echo ' : ';
                dropdown_num('minute', 0, 55, 5, $min);
            echo '</li><li><label>Date: </label>';
            get_event_dates($cdate);
            echo '<li><input type="submit" class="button" name="unschedule" value="Unschedule Class" />
                <input type="submit" class="button" name="class" value="Add to Schedule" /></li>';
        }
        ?>
    </ul>
    <input type="hidden" name="kwds" value="<?php echo $kwds['KWID']; ?>" />
    <input type="hidden" name="cid" value="<?php echo $cid; ?>" />
</div>
</form>
<?php } ?>
<h1>Schedule</h1>
<div class="schedule">
    <div class="th"><u>Legend</u><br />Black is not rated</div>
    <div class="class europ">European Dance Class <br />(Green Border)</div>
    <div class="class meast">Middle Eastern <br />Dance Class<br />(Red Border)</div>
    <div class="class music">Music Class<br />(Blue Border)</div>
    <div class="class beg">Beginner's Class<br />(Green Text)</div>
    <div class="class int">Intermediate Class<br />(Blue Text)</div>
    <div class="class adv">Advanced Class<br />(Red Text)</div>
</div>
<?php
$keday = (date('z', strtotime($kwds['end_date'])) - date('z', strtotime($kwds['start_date'])));
for ($kday=0; $kday <= $keday; $kday++) {
    $result = $db->get_rooms($kwds['KWID']);
    if (count($result) < 1) {
        echo '<p>There are no classes scheduled yet for day ' . ($kday + 1) . '.</p>';
    } else {
        echo '
<div class="schedule" ><h2>Day ' . ($kday + 1)/* date('l', strtotime('+'.($kday).' days',$ksdate)) */ . '</h2>
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
    <div>';
            $rooms = $db->get_class_rooms($row['id'], date('z', strtotime($kwds['start_date'])) + $kday + 2);
            if (count($rooms) > 0) {
                echo'
        <div class="th">' . $row['name'] . '</div>';
                foreach ($rooms as $room) {
                    echo '<a href="class_schedule.php?kwds=' . $kwds['KWID'] . '&id=' . $room['ClassID'] . '"><div class="class';
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
                        title="' . $room['description'] . '">
                        <input class="mark" type="checkbox" /><div class="title">' . date('g:iA', $thistime) . ' ' . $room['ClassName'] . '</div>
                        <div class="user"> ' . $room['user'] . '</div></div></a>';
                }
            }
            echo'
    </div>';
        }
        echo'
</div>';
    }
}
echo '<div class="schedule"><h2>Unscheduled Classes</h2>';
$classes = $db->get_unscheduled_classes($kwds['KWID']);

if (count($classes) > 0) {
    foreach ($classes as $class) {
                    echo '<a href="class_schedule.php?kwds=' . $kwds['KWID'] . '&id=' . $class['id'] . '"><div class="class';
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
echo'</div>';

require('footer.php');
?>