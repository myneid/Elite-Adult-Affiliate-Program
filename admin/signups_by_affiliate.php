<?php
//admin stats by affiliate
error_reporting(E_ALL);
require_once('../phpinclude/classAffiliateProgramDB.inc.php');
require_once('../phpinclude/classSmartyEC.inc.php');

$parts = explode( '-', $_REQUEST['start_date'] );
$startTime = $parts[0].$parts[1].$parts[2].'000000';
$parts = explode( '-', $_REQUEST['end_date'] );
$endTime = $parts[0].$parts[1].$parts[2].'235959';

$startDate	= $_REQUEST['start_date'];
$endDate	= $_REQUEST['end_date'];
$affiliate_id	= $_REQUEST['affiliate_id'];

$db = new AffiliateProgramDB();
$db->connect_to_db();

$query = "SELECT datetime,t2.Email,t2.ip_address,t2.Username,t2.Status";
$query.= "  FROM Sale";
$query.="   JOIN candice9.members AS t2";
$query.="     ON (Sale.member_id=t2.ID) ";
$query.="WHERE affiliate_id=? AND datetime>=? AND datetime<=?";
$res = $db->query( $query, array( $affiliate_id,$startTime,$endTime ));
while( $row = $res->fetchRow( DB_FETCHMODE_ASSOC )) {
	$row['epochLink'] = "javascript:PopupWin('http://www.epochsystems.com/search/basicSearch?email={$row['Email']}','Epoch',650,650,1)";
	$results[] = $row;
}

$smarty = new SmartyEC('../templates');
$smarty->clear_all_cache();
$smarty->assign('results', $results);
$smarty->assign('begin_date', $startDate);
$smarty->assign('end_date', $endDate);
$smarty->assign('affiliate_id', $affiliate_id);
$smarty->display('admin/signups_by_affiliate.html');				

?>
