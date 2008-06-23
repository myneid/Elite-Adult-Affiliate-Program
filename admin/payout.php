<?php
//this is the payout program
//it will handle displaying what will be paid out
//and a link on that page to payout which will create a csv and mark those users as paid
require_once	'../phpinclude/classAffiliateProgramDB.inc.php';
require_once	'../phpinclude/classStats.inc.php';
require_once	'../phpinclude/classWebmaster.inc.php';
require_once	'../phpinclude/classSmartyEC.inc.php';
require_once	'../phpinclude/Payout_Item.php';
require_once	'../phpinclude/Payout_Quickbooks.php';
main();

function main()
{
	@$action = $_REQUEST['action'];
	switch($action)
	{
		case 'payout_submit':
			payout_submit();
			break;
		default:
		case '':
		case 'show_payout':
			show_payout();
			break;
		case 'payout_detail':
			payout_detail();
			break;
		case 'payout_iif':
			payout_iif();
			break;
	}
}

function show_payout()
{
	//need to get end_date
	$db = new AffiliateProgramDB();
	$db->connect_to_db();
	
	@$date = $_REQUEST['date'];
	if(!$date)
		$date = date("Y-m-d");
		
	list($y,$m,$d) = preg_split("/-/", $date);
	if($d<=15)
	{
		$daybefore = "$y-$m-01";
		$res = $db->query("select date_sub('$daybefore', interval 1 day)");
		list($end_date) = $res->fetchRow();
		
	}
	else
	{
		$end_date = "$y-$m-15";	
	}
	
	$stats = new Stats($db);
	$webmaster = new Webmaster($db);
	$all_payouts = $stats->getAllPayouts($end_date);
	$payouts = $webmaster->getPayoutInfo($all_payouts);
	
	$smarty = new SmartyEC('../templates');
	$smarty->clear_all_cache();
	$smarty->assign('payouts', $payouts);
	$smarty->assign('end_date', $end_date);
	$smarty->display('admin/payout.html');
		
}

function payout_detail()
{
	$end_date = $_REQUEST['end_date'];
	$affiliate_id = $_REQUEST['aid'];
	
	$stats = new Stats( $db );
	$payout_detail = $stats->getPayoutDetail( $affiliate_id, $end_date );
	
	reset( $payout_detail );
	foreach( $payout_detail as $detail )
	{
		$total['signups'] += $detail['signups'];
		$total['uniques'] += $detail['uniques'];
		$total['hits']    += $detail['hits'];
		$total['income']  += $detail['income'];
		$total['referral_income'] += $detail['referral_income'];
	}
	
	$smarty = new SmartyEC( '../templates' );
	$smarty->clear_all_cache();
	$smarty->assign( 'detail', $payout_detail );
	$smarty->assign( 'end_date', $end_date );
	$smarty->assign( 'affiliate_id', $affiliate_id );
	$smarty->assign( 'total', $total );
	$smarty->display( 'admin/payout_detail.html' );
}

function payout_submit()
{
	$end_date = $_REQUEST['end_date'];
	$db = new AffiliateProgramDB();
	$db->connect_to_db();
	$stats = new Stats($db);
	$webmaster = new Webmaster($db);
	$all_payouts = $stats->getAllPayouts($end_date);
	$payouts = $webmaster->getPayoutInfo($all_payouts);
	
	$sth = $db->prepare("update Stats set paid=1, payout_date='$end_date' where affiliate_id=? and date<='$end_date' and payout_date is null");
	
	foreach($payouts as $p)
	{
		$res = $db->execute($sth, array($p['affiliate_id']));	
	}
	print "payout submitted";
}

function payout_iif()
{
	//need to get end_date
	$db = new AffiliateProgramDB();
	$db->connect_to_db();
	
	@$date = $_REQUEST['date'];
	if(!$date)
		$date = date("Y-m-d");
		
	list($y,$m,$d) = preg_split("/-/", $date);
	if($d<=15)
	{
		$daybefore = "$y-$m-01";
		$res = $db->query("select date_sub('$daybefore', interval 1 day)");
		list($end_date) = $res->fetchRow();
		
	}
	else
	{
		$end_date = "$y-$m-15";	
	}
	
	$stats = new Stats($db);
	$webmaster = new Webmaster($db);
	$all_payouts = $stats->getAllPayouts($end_date);
	$payouts = $webmaster->getPayoutInfo($all_payouts);

	// set up quickbooks export array
	$payout_data = array();
	foreach( $payouts as $payout )
	{
          $payout_data[] =& Payout_Item::fromArray( array(
                'payableto'     =>      $payout->pay_to,
                'address'       =>      $payout->street_address,
                'city'          =>      $payout->city,
                'state'         =>      $payout->state,
                'postal'        =>      $payout->postal_code,
                'country'       =>      $payout->country,
                'phone'         =>      '',
                'affid'         =>      $payout->affiliate_id,
                'total'         =>      $payout->income,
                ));
	}

	// and do it
	$quickbooks =& new Payout_Quickbooks;
	$quickbooks->payout_data  = $payout_data;
	$quickbooks->program_id   = 1;
	$quickbooks->start_date   = $start_date;
	$quickbooks->end_date     = $end_date;
	$quickbooks->render( 1 );
}
