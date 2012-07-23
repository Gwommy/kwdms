<?php
/*
 * KWDS 404 Page Not Found
 */
require('includes/init.php'); 

require('header.php');
?>
<h1>404 Page Not Found</h1>
<div class="box warning">The page you are trying to view has not been documented.</div>

<?php 
redirect('index'); 
require('includes/footer.php');
?>