<?php
require_once('../phpinclude/classAffiliateLogin.inc.php');
require_once('../phpinclude/classAffiliateProgramDB.inc.php');
require_once('../phpinclude/classAffiliate.inc.php');
require_once('../phpinclude/classWebmaster.inc.php');
require_once('../phpinclude/classReports.inc.php');
require_once('../phpinclude/classSmartyEC.inc.php');

//webmaster info

$db = new AffiliateProgramDB();
$db->connect_to_db();


$auth = new AffiliateLogin($db);

main();
function main()
{
	@$action = $_REQUEST['action'];
	switch($action)
	{
		default:
		case '':
		case 'show_info':
			show_info();
			break;	
	}	
}
function show_info()
{
	global $auth, $db;
	
	$affiliate = new Affiliate($db);
	$affiliate->getById($auth->getAffiliateId());
	
	$webmaster = new Webmaster($db);
	$webmaster->getById($affiliate->getWebmasterId());
	$affiliate_ids = $webmaster->getAffiliateIDs();
	
	$aff_login = new AffiliateLogin(false, false);
	$aids = array();
	foreach($affiliate_ids as $aid)
	{
		$aff_login->getByAffiliateId($aid);
		$aids[$aid]['username'] = $aff_login->getUsername();
		$aids[$aid]['password'] = $aff_login->getPassword();
	}

	$smarty = new SmartyEC("../templates");
	$smarty->assign('webmaster_id', $_REQUEST['webmaster_id']);
	$smarty->assign('firstname', $webmaster->getFirstname());
	$smarty->assign('lastname', $webmaster->getLastName());
	$smarty->assign('ssn_taxid', $webmaster->getSsnTaxid());
	$smarty->assign('street_address', $webmaster->getStreetAddress());
	$smarty->assign('postal_code', $webmaster->getPostalCode());
	$smarty->assign('city', $webmaster->getCity());
	$smarty->assign('state', $webmaster->getState());
	$smarty->assign('country', $webmaster->getCountry());
	$smarty->assign('email', $webmaster->getEmail());
	$smarty->assign('referred_webmaster_id', $webmaster->getReferredWebmasterId());
	$smarty->assign('aim', $webmaster->getAim());
	$smarty->assign('icq', $webmaster->getIcq());
	$smarty->assign('company', $webmaster->getCompany());
	$smarty->assign('pay_to', $webmaster->getPayTo());
	$smarty->assign('minimum_payout', $webmaster->getMinimumPayout());
	$smarty->assign('payment_method', $webmaster->getPaymentMethod());
	$smarty->assign('notes', $webmaster->getNotes());
	$smarty->assign('referral_percent', $webmaster->getReferralPercent());
	
	$smarty->assign('affiliate_ids', $aids);
	
	$smarty->display('webmaster_info.html');	
}
?>