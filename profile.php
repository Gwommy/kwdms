<?php
/*
 * KWDS User Profile Page
 */
require_once('includes/header.php');

// Retrieve the user id from the web address, otherwise set it to the user's id
$id = (isset($_SESSION['user_id'])) ? $_SESSION['user_id'] : 0;
$id = (isset($_GET['id'])) ? $_GET['id'] : $id;

$result = $db->get_user_info($id);
if ($result) {
    $first = $result['MundaneFirst'];
    $last = $result['MundaneLast'];
    $nick = $result['nickname'];
    $sfirst = $result['SCAFirst'];
    $slast = $result['SCALast'];
    $pre = $result['PrefixName'];
    $email = $result['email'];
    $group = $result['GroupName'];
    $gurl = $result['GroupURL'];
    $kingdom = $result['KingdomName'];
    $kurl = $result['KingdomURL'];
    $about = $result['about'];
    $title = $result['Title'];
?>
    <h1>User Profile
    <?php
    if ($id == $_SESSION['user_id']) { ?>
        <form action="user.php" method="post">
            <input type="hidden" name="uid" value="<?php echo $_SESSION['user_id'] ?>" />
            <a href="edit.php"><input type="submit" name="edit_user" class="button edit" value="Edit Profile" /></a>
        </form>
        <?php
    }
    ?>
</h1>
<div class="profile">
    <ul>
        <li><label for="name">Mundane Name: </label><?php echo $pre . " " . $first . " " . $last; ?></li>
        <li><label>SCA Name: </label> <?php echo $title . " " . $sfirst . " " . $slast ?></li>
        <li><label>Group: </label> <a href="<?php echo $gurl ?>"><?php echo $group ?></a></li>
        <li><label>Kingdom: </label> <a href="<?php echo $kurl ?>"><?php echo $kingdom ?></a></li>
        <li>
            <form action="email.php" method="post">
                <input type="hidden" name="uid" value="<?php echo $id ?>" />
                <input type="submit" class="button float_right" value="Send an email" />
            </form>
        </li>
    </ul>
    <div class="bio">
        <h3>Biography:</h3>
        <p><?php echo $about; ?></p>
    </div>
    <?php
        $result=$db->get_user_jobs($id);
        if (count($result) > 0) {
            echo '
    <div class="jobs">
        <h2>KWDS Staff</h2>
        <ul>';
            foreach ($result as $row) {
                echo '
            <li><label>KWDS '.$row['id'].': </label> '.$row['name'].'</li>';
            }
            echo '
        </ul>
    </div>';
        }
        $result=$db->get_user_classes($id);
        if (count($result) > 0) {
            echo '
    <div class="classes">
        <h2>Classes Submitted</h2>
        <ul>';
            foreach ($result as $row) {
                echo'
            <li><a href="schedule.php?kwds='.$row['kwds_id'].'&id='.$row['id'].'"><span class="bold">KWDS '.$row['kwds_id'].'</span>: '.$row['name'].'</a></li>';
            }
            echo '
        </ul>
    </div>';
        }
    ?>
</div>
<?php
} else {
    echo '<div class="box error">The user profile you are trying to view does not exist.</div>';
    redirect('index');
}

//user.id, user.first, user.last, sca_first, sca_last, title.name, prefix.name, nickname, email, group.name, kingdom.name, about
require('footer.php'); ?>