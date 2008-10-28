<?php
//affiliate subid stats program
require_once('../phpinclude/classAffiliateLogin.inc.php');
require_once('../phpinclude/classAffiliateProgramDB.inc.php');
require_once('../phpinclude/classReports.inc.php');
require_once('../phpinclude/classSmartyEC.inc.php');

//ini_set('display_errors', 'on');
//get period

//total stats for period
//stats for the period by site
//stats for the period by day

$t = @$_REQUEST['t'];
if(!$t)
	$t = 'all';
$db = new AffiliateProgramDB();
$db->connect_to_db();


$auth = new AffiliateLogin($db);

list($start_date, $end_date) = get_start_and_end_dates($db);




$report = new Reports($db);
$report->setBeginDate($start_date);
$report->setEndDate($end_date);
$report->setAffiliateId($auth->getAffiliateId());


$stats = $report->generateSubidStats();

$totals = array();


foreach($stats as $k => $s) {
	$totals['hits'] += $s['hits'];
	$totals['uniques'] += $s['uniques'];
	$totals['second_hits'] += $s['second_hits'];
	$totals['signups'] += $s['signups'];
	

}

$totals['ratio'] = $report->getRatio($totals['uniques'], $totals['signups']);
if($_REQUEST['format'] == 'csv')
{
	header("Content-type: text/csv");
	print "date, sub_id, hits, sales\n";
	foreach($stats as $s)
	{
	if( $s['signups'] == '' )
		$s['signups'] = 0;
		print $s['date'] . ',' . $s['sub_id'] . ',' . $s['hits'] . ',' . $s['signups'] . "\n";
	}
	exit;
}


$smarty = new SmartyEC('../templates');
$smarty->clear_all_cache();
$smarty->assign($totals);

$smarty->assign('begin_date', $start_date);
$smarty->assign('end_date', $end_date);
$smarty->assign('affiliate_id', $auth->getAffiliateId());
$smarty->assign('campaign_stats', $stats);
$smarty->display('subid_stats.html');
/** this was from stats.php
$total_stats = $report->generateTotalStats();
$stats_by_site = $report->generateStatsBySite();
$stats_by_day = $report->generateStatsByDay();

$smarty = new SmartyEC('../templates');
$smarty->clear_all_cache();
$smarty->assign($total_stats);
$smarty->assign(array(
						'stats_by_day' =>$stats_by_day,
						'stats_by_site' => $stats_by_site
					)
				);
$smarty->assign('begin_date', $start_date);
$smarty->assign('end_date', $end_date);
$smarty->assign('affiliate_id', $auth->getAffiliateId());
$smarty->assign('t', $t);
$smarty->display('stats.html');
*/


function get_start_and_end_dates()
{
	@$start_date = $_REQUEST['start_date'];
	@$end_date = $_REQUEST['end_date'];
	if(!$start_date || !$end_date)
	{

		@$start_date = $_REQUEST["startYear"] . '-' . $_REQUEST['startMonth'] . '-' . $_REQUEST['startDay'];
		@$end_date = $_REQUEST["endYear"] . '-' . $_REQUEST['endMonth'] . '-' . $_REQUEST['endDay'];

		if($start_date == '--' || $end_date == '--')
		{
			@$date = $_REQUEST['date'];
			if(!$date)
			$date = date("Y-m-d");

			//get start and end date

			list($y,$m,$d) = preg_split("/-/", $date);
			if($d <= 15)
			{
				$start_date = "$y-$m-01";
				$end_date = "$y-$m-15";
			}
			else
			{
				$thirtyone = array(1,3,5,7,8,10,12);
				$thirty = array(4,6,9,11);

				if(in_array(intval($m), $thirtyone))
				$d = 31;
				elseif (in_array(intval($m), $thirty))
				$d = 30;
				else
				{
					//february
					if($y%4 ==0)
					$d = 29;
					else
					$d = 28;
				}

				$end_date = "$y-$m-$d";

				$start_date = "$y-$m-16";
			}
		}
	}
	return array($start_date, $end_date);
}
