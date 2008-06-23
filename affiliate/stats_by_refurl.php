<?PHP
//stats by referring url
// show referring url, hits, uniques signups
//only by day cause theres a lot of data to crunch
require_once('../phpinclude/classAffiliateLogin.inc.php');
require_once('../phpinclude/classAffiliateProgramDB.inc.php');
require_once('../phpinclude/classReports.inc.php');
require_once('../phpinclude/classSmartyEC.inc.php');

/*
$res = $db->query("select referring_url, uniq from Hit where affiliate_id=? and datetime >= ? and datetime<=?", array());

$res = $db->query("select Hit.referring_url, Sale.id from Sale, Hit where Hit.id=Sale.hits_id and Sale.affiliate_id=? and Sale.datetime >= ? and Sale.datetime<=?", array());
*/
$db = new AffiliateProgramDB();
$db->connect_to_db();


$auth = new AffiliateLogin($db);

$date = $_REQUEST['date'];
if(!$date)
	$date = date("Y-m-d");
	
$report = new Reports($db);
$report->setBeginDate($date . " 0:0:0");
$report->setEndDate($date . " 23:59:59");
$report->setAffiliateId($auth->getAffiliateId());

$stats = $report->generateStatsByReferringUrl();

$smarty = new SmartyEC('../templates');
$smarty->assign(array(
						'stats' =>$stats
					)
				);
$smarty->assign('date', $date);
$smarty->display('stats_by_refurl.html');
?>