<?php
/*
 * KWDS My Schedule
 */
require_once('includes/header.php');
?>
<h1>My Schedule for KWDS <?php echo $kwds['KWID']; ?></h1>
<?php
if (!isset($_POST['checkboxes'])) {
    echo '<div class="box attention">You don\'t have any classes selected from the schedule.</div>';
    redirect('schedule');
    include_once('includes/footer.php');
    die;
}
$where="class.id='-1' ";
echo '<form class="form" action="schedule.php?kwds='.$kwds['KWID'].'" method="post">';

foreach ($_POST as $key => $value) {
    echo '<input type="hidden" name="'.$key.'" value="'.$value.'" />';
    if ($key!="checkboxes" AND $key!="europ" AND $key!="meast" AND $key!="music") {
        $where.="OR class.id=$value ";
    }
}

$result=$db->get_my_schedule($where);

if (count($result) == 0) {
    echo '<div class="box attention">You don\'t have any classes selected from the schedule.</div>';
    redirect('schedule');
    include_once('includes/footer.php');
    die;
}

$day="";
echo '<div class="my_sched">';
foreach ($result as $row) {
    if ($day != date('l',strtotime($row['day']))) {
        $day = date('l',strtotime($row['day']));
        echo "<br /><h2>$day</h2>";
    }
    
    echo '<div class="time">'.  date('g:i A',strtotime($row['day'])).'</div>';
    echo '<div class="room">'.$row['RoomName'].'</div>';
    echo '<div class="name">'.$row['ClassName'].'</div>';
    echo '<div class="prof">'.$row['SCAFirst'].' '.$row['SCALast'].'</div>';
}
echo '</div>';
echo '<input class="button" name="checkboxes" type="submit" value="Return to Schedule" />';
echo '</form>';

require('footer.php'); ?>