<?php
ini_set("display_errors" , "on");
require_once('../phpinclude/classAffiliateProgramDB.inc.php');
require_once('../phpinclude/classAffiliateLogin.inc.php');
require_once('../phpinclude/classSmartyEC.inc.php');


$smarty = new SmartyEC("../templates");  
$smarty->display('admin/index.html');
