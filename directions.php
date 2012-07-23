<?php
/*
 * KWDS Directions
 */
require_once('includes/init.php');

$kadd = str_replace(" ", "+", $kwds['address']);
$kcity = str_replace(" ", "+", $kwds['city']);
$kstate = str_replace(" ", "+", $kwds['state']);
$kcountry = str_replace(" ", "+", $kwds['country']);
$kzip = str_replace(" ", "+", $kwds['zip']);
$kaddress=$kadd.',+'.$kcity.',+'.$kstate.'+'.$kzip.'+'.$kcountry;

if (isset($_SESSION['user_id'])) {
    $result = $db->get_user_address($_SESSION['user_id']);
    $uadd = str_replace(" ", "+", $result['address']);
    $ucity = str_replace(" ", "+", $result['city']);
    $ustate = str_replace(" ", "+", $result['state']);
    $ucountry = str_replace(" ", "+", $result['country']);
    $uaddress = $uadd.',+'.$ucity.',+'.$ustate.'+'.$result['zip'].'+'.$ucountry;
} else {
    $uaddress = "";
}

require('header.php');
?>
<h1>Directions</h1>

<div class="center">
    <iframe width="425" height="350" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?f=q&amp;source=s_q&amp;hl=en&amp;geocode=&amp;q=<?php echo $kaddress ?>&amp;ie=UTF8&amp;output=embed"></iframe>
    
    <br />
    
    <small>
        <a href="https://maps.google.com/maps?f=q&amp;source=embed&amp;hl=en&amp;geocode=&amp;q=<?php echo $kaddress; ?>&amp;aq=&amp;sll=37.0625,-95.677068&amp;sspn=37.819897,78.662109&amp;t=m&amp;ie=UTF8&amp;hq=&amp;hnear=<?php echo $kaddress; ?>&amp;z=14&amp;ll=43.080487,-73.787474" style="color:#0000FF;text-align:left">View Larger Map</a>
    </small>

    <br />

    <form class="form" action="//maps.google.com/maps" id="map_form" name="v1Form" target="_blank">
        <ul>
            <li><label style="width: 30px;">To:</label><input id="daddr" maxlength="1024" name="daddr" value="<?php echo str_replace('+', ' ', $kaddress); ?>"></li>
            <li><label style="width: 30px;">From:</label><input id="saddr" maxlength="1024" name="saddr" value="<?php echo str_replace('+', ' ', $uaddress); ?>"></li>
            <li><label style="width: 30px;"></label><input class="button" type="submit" value="Get Directions"></li>
        </ul>
    </form>
</div>

<?php require('footer.php'); ?>