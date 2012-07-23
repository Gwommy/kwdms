<?php
/*
 * KWDS Registration
 */
require('includes/init.php');
require('header.php');
?>
<h1>Site Fees and Registration</h1>
<div class="fees">
<?php
$result = $db->get_fees($kwds['KWID']);
$prereg="0";
$type="";
if (count($result) > 0) {
    foreach ($result as $row) {

        // If the next fee type and preregistration does not match, display the next title
        if (($type.$prereg) != ($row['FeeTypeName'].$row['prereg'])) {
            $type = $row['FeeTypeName'];
            $prereg = $row['prereg'];
            echo '<h2>'.$type;
            if ($prereg==1) {
                echo ' Pre-registration Fees';
            }
            echo '</h2>';
        }
        $name = $row['FeeName'];
        $price = $row['price'];
        $desc = $row['description'];
        setlocale (LC_MONETARY, 'en_US');
        //$amount = money_format('%n', floatval($price));
        echo '<div class="box info"><span class="float_right">$'. number_format($price, 2).'</span>
            <h3 class="bold">' . $name .'</h3><br />' . $desc .'</div>';
    }
}
else {
    echo '<p>There is no information to report.</p>';
}
?>
</div>

<?php require('footer.php'); ?>