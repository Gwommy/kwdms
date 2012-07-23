<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Known World Dance and Music Symposium</title>
        
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        
        <link rel="stylesheet" href="css/kwds.css" type="text/css" media="screen" />
        <link rel="stylesheet" href="css/print.css" type="text/css" media="print" />
    </head>
    <body>
        <div id="wrapper">
            <div id="header">
                <?php if ($kwds['banner'] == "") { ?>
                    <h1>
                        <div class="float_left inline"><img src="./images/kingdoms/<?php echo $kwds['arms']; ?>" alt="<?php echo $kwds['kingdom']; ?>" title="<?php echo $kwds['kingdom']; ?> Kingdom"/></div>
                        <a href="http://kwds.org">Known World Dance and Music Symposium <br /><?php echo roman($kwds['KWID']); ?></a>
                    </h1>
                    <h2><?php echo date('M j, Y', strtotime($kwds['start_date'])).' to '.date('M j, Y', strtotime($kwds['end_date'])); ?></h2>
                    
                <?php } else { ?>
                    <div id="banner">
                        <div class="inline"><img src="./images/kingdoms/<?php echo $kwds['arms']; ?>" alt="Kingdom Arms" /></div>
                        <a href="http://kwds.org"><img src="images/header/<?php echo $kwds['banner']; ?>" title="KWDS<?php echo $kwds['KWID']; ?>" /></a>
                    </div>
                <?php } ?>
            </div>
            <div id="main_content">
                <?php
                require_once('includes/menu.php');
                require_once('includes/side_menu.php');
                ?>
                <div id="container">