<?php
//admin stats

//total stats for period
//shows raws, uniques, signups, affiliate income, income
//also show per site
//click through to per day to see this
//also need a per affiliate report for time period given

require_once('../phpinclude/classAffiliateProgramDB.inc.php');
require_once('../phpinclude/classReports.inc.php');
require_once('../phpinclude/classSmartyEC.inc.php');

$db = new AffiliateProgramDB();
$db->connect_to_db();


list($start_date, $end_date) = get_start_and_end_dates($db);

$report = new Reports($db);
$report->setBeginDate($start_date);
$report->setEndDate($end_date);

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
$smarty->display('admin/stats.html');



function get_start_and_end_dates($db)
{
	//get date range
	@$start_date = $_REQUEST['start_date'];
	@$end_date = $_REQUEST['end_date'];
	
	
	if(!$start_date || !$end_date)
	{
		
		@$start_date = $_REQUEST["startYear"] . '-' . $_REQUEST['startMonth'] . '-' . $_REQUEST['startDay'];
		@$end_date = $_REQUEST["endYear"] . '-' . $_REQUEST['endMonth'] . '-' . $_REQUEST['endDay'];

		if(($start_date == '--') || ($end_date == '--'))
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
?>
