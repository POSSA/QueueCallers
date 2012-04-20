<?php
/* Database connection information */
define("ASDBNAME","asterisk");
define("ASDBUSER","root");
define("ASDBPASS","passw0rd");
define("ASDBHOST","localhost");
define("ASDBPORT","3307");

/* Query to select the queues from the Asterisk database */
define("ASSQLQUEUE","SELECT extension, descr FROM queues_config ORDER BY descr ASC");

/* Asterisk CLI command specifics */
define("ASCLI","asterisk -rx 'queue show ?' | sed 1d");
//define("ASCLI","asterisk -rx 'queue show ?'");
define("ASCLINOMEM","No Members");
define("ASCLINOCAL","No Callers");
define("ASCLICAL","Callers:");
define("ASCLIMEM","Members:");
?>
