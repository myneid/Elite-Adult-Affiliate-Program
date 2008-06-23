<?php
		require_once '../phpinclude/classAffiliateProgramDB.inc.php';
		require_once('../phpinclude/classStats.inc.php');
		require_once('../phpinclude/classWebmaster.inc.php');
		require_once('../phpinclude/classSmartyEC.inc.php');

		main();

function main()
{
	@$action = $_REQUEST['action'];
	switch($action)
	{
		default:
		case '':
			payout_list();
			break;
		case 'show_payout':
			show_payout();
			break;
	}
}

function payout_list()
{
	$db = new AffiliateProgramDB();
	$db->connect_to_db();

	// get list of all times payout was run
	$res = $db->query( "SELECT distinct(payout_date) FROM Stats WHERE payout_date IS NOT NULL ORDER BY payout_date" );
	while( list($datum) = $res->fetchRow() ) {
		$payout_dates[] = $datum;
	}

	$smarty = new SmartyEC('../templates');
	$smarty->clear_all_cache();
	$smarty->assign('payout_dates', $payout_dates );
	$smarty->display('admin/payouts.html');
}

function show_payout()
{
	//need to get end_date
	$db = new AffiliateProgramDB();
	$db->connect_to_db();
	
	@$date = $_REQUEST['date'];
	$origdate = $date;
	$parts = explode('-', $date );
	$date = $parts[0].$parts[1].$parts[2];
	
	$query = "SELECT affiliate_id,Affiliate.webmaster_id,Webmaster.firstname,";
	$query.= "  Webmaster.lastname,Webmaster.email,Webmaster.pay_to,Webmaster.street_address,";
	$query.= "  Webmaster.city,Webmaster.postal_code,Webmaster.state,Webmaster.country,";
	$query.= "  Webmaster.notes,SUM(signups) AS signups,SUM(income) AS income ";
	$query.= "FROM Stats";
	$query.= "  JOIN Affiliate ON (Stats.affiliate_id=Affiliate.id)";
	$query.= "  JOIN Webmaster ON (Affiliate.webmaster_id=Webmaster.id) ";
	$query.= "WHERE payout_date=$date ";
	$query.= "GROUP BY affiliate_id ";
	$query.= "ORDER BY affiliate_id";

	$res = $db->query( $query );
	while( $row = $res->fetchRow( DB_FETCHMODE_ASSOC )) {
		$results[] = $row;
	}
	
	$smarty = new SmartyEC('../templates');
	$smarty->clear_all_cache();
	$smarty->assign('results', $results );
	$smarty->assign('date', $origdate );
	$smarty->display('admin/archive_payouts.html');
		
}

?>
