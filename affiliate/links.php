<?php
//ini_set( 'display_errors', true );

//links.php  this file will generate teh links to show to the webmaster
require_once('../phpinclude/classAffiliateLogin.inc.php');
require_once('../phpinclude/classAffiliateProgramDB.inc.php');
require_once('../phpinclude/classAffiliate.inc.php');
require_once('../phpinclude/classSite.inc.php');
require_once('../phpinclude/classSmartyEC.inc.php');
require_once('../phpinclude/classAPConfig.inc.php');



$db = new AffiliateProgramDB();
$db->connect_to_db();


$apconfig = new APConfig($db);
$config_vars = $apconfig->get_all_vars();
$base_url = $config_vars['base_url'] . '/track/track.php?';
$referral_url = $config_vars['base_url'] . '/track/wm_track.php?';




$auth = new AffiliateLogin($db);

$affiliate_id = $auth->getAffiliateId();
$affiliate = new Affiliate($db);
$affiliate->getById($affiliate_id);

$site=new Site($db);

$sites = $site->getAll();

$links = array(); //this is for smarty
foreach($sites as $s)
{
	if($s->getStatus() == 'active')
	{
		$t = array();
		$t['site_name'] = $s->getName();
		$t['url'] = $s->getMainURL();
		$t['id'] = $s->getId();
		$t['link'] = $base_url . "sid=" . $s->getID() . "&aid=$affiliate_id";
		
		array_push($links, $t);
	}
}
$t = @$_REQUEST['t'];
if(!$t)
	$t = 'all';
$smarty = new SmartyEC('../templates');
$smarty->clear_all_cache();
$smarty->assign('links', $links);
$smarty->assign('t', $t);
$smarty->assign('referral_link', $referral_url . "id=" . $affiliate->getWebmasterId());
$smarty->display('links.html');

?>