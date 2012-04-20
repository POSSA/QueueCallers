<?php
$asdb = mysql_connect(ASDBHOST.":".ASDBPORT, ASDBUSER, ASDBPASS) or die("Could not connect: ".mysql_error());
//$asdb = mysql_connect(localhost, root, passw0rd) or die("Could not connect: ".mysql_error());
mysql_select_db(ASDBNAME, $asdb) or die("Could not select database");
?>
