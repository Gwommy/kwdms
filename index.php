<?php
/*
 * KWDS Index Home Page
 */
require('includes/init.php');
require('header.php');
?>
    <h1 class="header"><a href="index.php?kwds=<?php echo $kwds['KWID']; ?>" title="Home">KWDS <? echo $kwds['KWID']; ?></a></h1>
    <div class="entry">
        <div class="address">
            <h2><?php echo $kwds['kwdsName']; ?></h2>
            <h2><?php echo $kwds['address']; ?></h2>
            <h2><?php echo $kwds['city'];
                if ($kwds['city'] != "" && $kwds['state'] != "") {
                    echo ', ';
                }
                echo $kwds['state'].' '. $kwds['zip']; ?></h2>
            <h2><?php echo $kwds['country']; ?></h2>
        </div>
        <div class="kwds_description">
            <p><?php echo $kwds['description']; ?></p>
        </div>
    </div>


<?php require('footer.php'); ?>