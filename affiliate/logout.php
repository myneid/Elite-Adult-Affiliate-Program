<?php
ini_set( 'display_errors', true );

//affiliate stats program
require_once('../phpinclude/classAffiliateLogin.inc.php');
require_once('../phpinclude/classAffiliateProgramDB.inc.php');
require_once('../phpinclude/classReports.inc.php');
require_once('../phpinclude/classSmartyEC.inc.php');
require_once('../phpinclude/classAPConfig.inc.php');

$db = new AffiliateProgramDB();
$db->connect_to_db();
$auth = new AffiliateLogin($db);
$auth->logout();
session_destroy();
$conf = new APConfig($db);
$conf_vars = $conf->get_all_vars();

header( "Location: " . $conf_vars['base_url'] );
