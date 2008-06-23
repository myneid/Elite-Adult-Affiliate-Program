<?php
ini_set( 'display_errors', true );

//affiliate stats program
require_once('../phpinclude/classAffiliateLogin.inc.php');
require_once('../phpinclude/classAffiliateProgramDB.inc.php');
require_once('../phpinclude/classReports.inc.php');
require_once('../phpinclude/classSmartyEC.inc.php');

$db = new AffiliateProgramDB();
$db->connect_to_db();
$auth = new AffiliateLogin($db);

$smarty = new SmartyEC('../templates');
$smarty->clear_all_cache();
$smarty->display('affiliateindex.html');
