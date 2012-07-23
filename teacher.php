<?php
/*
 * KWDS Teachers
 */
require_once('includes/header.php');

$teachers = $db->get_teachers($kwds['KWID']);

echo '<h1>Teacher and Speaker Information</h1>';
if (count($teachers) == 0) {
    echo '<p>There is no information to report.</p>';
}
else {
    $tid = 0;
    echo '<div class="teachers">';
    foreach ($teachers as $teacher) {
        if ($tid != $teacher['UserID']) {
            $tid = $teacher['UserID'];
            echo '<h2><a href="profile.php?id='.$tid.'">'.$teacher['SCAFirst'].' '.$teacher['SCALast'];
            if ($teacher['MundaneFirst'] != "") {
                echo '('.$teacher['MundaneFirst'].' '.$teacher['MundaneLast'].')';
            }
        }
        echo '</a></h2>';
        echo '<p><a href="schedule.php?kwds='.$teacher['kwds_id'].'&id='.$teacher['ClassID'].'">'.$teacher['ClassName'].'</a></p>';
    }
    echo '</div>';
}

include_once('includes/footer.php');
?>
