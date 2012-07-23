<?php
/*
 * KWDS Edit Site Info
 */
require('includes/init.php');
require('header.php');

if (!(is_autocrat($_SESSION['user_id'], $kwds['KWID']) && $kwds['KWID'] >= $db->get_kwds_number()) && !is_super_user()) {
    echo '<div class="box error">You do not have permission to view this page.</div>';
    redirect('index');
    include_once('includes/footer.php');
    die;
}

$info=$db->get_kwds($kwds['KWID']);
if (count($info) > 0) {
    $name = isset($_POST['name'])?$_POST['name']:$info['kwdsName'];
    $address = isset($_POST['address'])?$_POST['address']:$info['address'];
    $city = isset($_POST['city'])?$_POST['city']:$info['city'];
    $state = isset($_POST['state'])?$_POST['state']:$info['state'];
    $country = isset($_POST['country'])?$_POST['country']:$info['country'];
    $zip = isset($_POST['zip'])?$_POST['zip']:$info['zip'];
    $desc = isset($_POST['desc'])?sanit($_POST['desc']):redisplay($info['description']);
    $dir = isset($_POST['dir'])?sanit($_POST['dir']):redisplay($info['directions']);
    $status = isset($_POST['status'])?$_POST['status']:$info['status_id'];
    $group = isset($_POST['group'])?$_POST['group']:$info['group_id'];
    $kingdom = isset($_POST['kingdom'])?$_POST['kingdom']:$info['kingdom_id'];
    $banner = isset($_POST['banner'])?$_POST['banner']:$info['banner'];
    $facebook = isset($_POST['facebook'])?$_POST['facebook']:$info['facebook'];
    $cmonth = isset($_POST['cmonth'])?$_POST['cmonth']:date('n', strtotime($info['class_date']));
    $cday = isset($_POST['cday'])?$_POST['cday']:date('j', strtotime($info['class_date']));
    $cyear = isset($_POST['cyear'])?$_POST['cyear']:date('Y', strtotime($info['class_date']));
    $smonth = isset($_POST['smonth'])?$_POST['smonth']:date('n', strtotime($info['start_date']));
    $sday = isset($_POST['sday'])?$_POST['sday']:date('j', strtotime($info['start_date']));
    $syear = isset($_POST['syear'])?$_POST['syear']:date('Y', strtotime($info['start_date']));
    $emonth = isset($_POST['emonth'])?$_POST['emonth']:date('n', strtotime($info['end_date']));
    $eday = isset($_POST['eday'])?$_POST['eday']:date('j', strtotime($info['end_date']));
    $eyear = isset($_POST['eyear'])?$_POST['eyear']:date('Y', strtotime($info['end_date']));
}

if (isset($_POST['submit'])) {
    $class_date=$cyear.'-'.$cmonth.'-'.$cday.' 00:00:00';
    $start_date=$syear.'-'.$smonth.'-'.$sday.' 00:00:00';
    $end_date=$eyear.'-'.$emonth.'-'.$eday.' 00:00:00';
    $db->update_kwds($address,$banner,$city,$class_date,$country,$desc,$dir,$end_date,$facebook,$group,$kingdom,$kwds['KWID'],$name,$start_date,$state,$status,$zip);
    echo '<div class="box success">The KWDS information has been updated!</div>';
}
?>
<h1>Edit Site Information</h1>
<form class="form" action="kwds.php?kwds=<?php echo $kwds['KWID']?>" method="post">
    <h2>Location</h2>
    <ul>
        <li><label>Name of Site:</label><input name="name" type="text" <?php if(isset($name)) {echo 'value="'.$name.'"';} ?> /></li>
        <li><label>Address:</label><input name="address" type="text" <?php if(isset($address)) {echo 'value="'.$address.'"';} ?> /></li>
        <li><label>City:</label><input name="city" type="text" <?php if(isset($city)) {echo 'value="'.$city.'"';} ?> /></li>
        <li><label>State:</label><input name="state" type="text" <?php if(isset($state)) {echo 'value="'.$state.'"';} ?> /></li>
        <li><label>Zip Code:</label><input name="zip" type="text" <?php if(isset($zip)) {echo 'value="'.$zip.'"';} ?> /></li>
        <li><label>Country:</label><input name="country" type="text" <?php if(isset($country)) {echo 'value="'.$country.'"';} ?> /></li>
    </ul>
    <h2>Description</h2>
    <ul>
        <li><label>Description:</label><textarea name="desc" cols="40" rows="10"><?php if(isset($desc)) {echo redisplay($desc);} ?></textarea></li>
    </ul>
    <h2>Directions</h2>
    <ul>
        <li><label>Directions:</label><textarea name="dir" cols="40" rows="10"><?php if(isset($dir)) {echo redisplay($dir);} ?></textarea></li>
    </ul>
    <h2>Status</h2>
    <ul>
        <li><label>Status:</label><?php $result=$db->get_list('status'); dropdown($result, 'status', $status) ?></li>
        <li><label>Group:</label><?php $result=$db->get_list('`group`');
            $index = (isset($_POST['group']))? $_POST['group']:$group;
            dropdown($result, "group", $index); ?></li>
        <li><label>Kingdom:</label><?php $result=$db->get_list('kingdom'); dropdown($result, 'kingdom',$group) ?></li>
    </ul>
    <h2>Optional Links</h2>
    <ul>
        <li><label>Banner URL:</label><input name="banner" type="text" <?php if(isset($banner)) {echo 'value="'.$banner.'"';} ?> /></li>
        <li><label>Facebook URL:</label><input name="facebook" type="text" <?php if(isset($facebook)) {echo 'value="'.$facebook.'"';} ?> /></li>
    </ul>
    <h2>Dates</h2>
    <ul>
        <li><label>Class Cutoff Date:</label><?php dropdown_num('cmonth',1,12, 1,$cmonth);dropdown_num('cday', 1, 31,1,$cday); dropdown_num('cyear', 1997,date('Y',time())+5,1,$cyear) ?></li>
        <li><label>Start Date:</label><?php dropdown_num('smonth',1,12,1,$smonth);dropdown_num('sday', 1, 31,1,$sday); dropdown_num('syear', 1997,date('Y',time())+5,1, $syear) ?></li>
        <li><label>End Date:</label><?php dropdown_num('emonth',1,12,1,$emonth);dropdown_num('eday', 1, 31,1,$eday); dropdown_num('eyear', 1997,date('Y',time())+5,1,$eyear) ?></li>
        <li><label></label><input type="submit" name="submit" value="Update" /></li>
    </ul>

</form>
<?php require('footer.php'); ?>