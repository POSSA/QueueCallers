<?php

//  Automatically ger FreePBX database access credentials from freepbx.conf file
$bootstrap_settings['freepbx_auth'] = false;
if (!@include_once(getenv('FREEPBX_CONF') ? getenv('FREEPBX_CONF') : '/etc/freepbx.conf')) {
include_once('/etc/asterisk/freepbx.conf');
}

define("ASDBNAME",$amp_conf['AMPDBNAME']);
define("ASDBUSER",$amp_conf['AMPDBUSER']);
define("ASDBPASS",$amp_conf['AMPDBPASS']);
define("ASDBHOST",$amp_conf['AMPDBHOST']);
define("ASDBPORT","3307");   //<-- assumes MySQL



/* Database connection information (deprecated).  Uncomment these lines and fill in database access vales
   only if the lines above fail to get FreePBX db credentials   */
// define("ASDBNAME","asterisk");
// define("ASDBUSER","root");
// define("ASDBPASS","passw0rd");
// define("ASDBHOST","localhost");
// define("ASDBPORT","3307");

/* Query to select the queues from the Asterisk database */
define("ASSQLQUEUE","SELECT extension, descr FROM queues_config ORDER BY descr ASC");

/* Asterisk CLI command specifics */
define("ASCLI","asterisk -rx 'queue show ?' | sed 1d");
define("ASCID","asterisk -rx 'core show channel ?'");
//define("ASCLI","asterisk -rx 'queue show ?'");
define("ASCLINOMEM","No Members");
define("ASCLINOCAL","No Callers");
define("ASCLICAL","Callers:");
define("ASCLIMEM","Members:");
