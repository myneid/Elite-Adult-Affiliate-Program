<?php
/**
 * subid_summary.php
 * this program will summarize the days subid hits and sales and put them into the subid_stats table
 * meant to be run once per day sometime after midnight
 */
ini_set('include_path', ini_get('include_path') . ':/web/freelifetimecash.com');
require_once 'PEAR.php';
require_once 'phpinclude/classAffiliateProgramDB.inc.php';

$db = new AffiliateProgramDB();
$db->connect_to_db();

$stats = array();
$yesterday = date("Y-m-d", strtotime("yesterday"));
$res = $db->query("select id, datetime, affiliate_id, hit_type, site_id, uniq, sub_id from Hit where sub_id is not null and datetime >= ? and datetime <=?", array("$yesterday 0:0:0", "$yesterday 23:59:59"));
$hitids = array();

while($row = $res->fetchRow(DB_FETCHMODE_ASSOC))
{
	if($row['hit_type'] == 'second')
		$stats[$row['affiliate_id']][$row['sub_id']]['second_hits']++;
	else
		$stats[$row['affiliate_id']][$row['sub_id']]['hits']++;
		
	if($row['uniq'])
		$stats[$row['affiliate_id']][$row['sub_id']]['uniques']++;
	$hitids[$row['id']] = $row['sub_id'];
}

//ok lets get sales

$res = $db->query("select affiliate_id, datetime, hits_id from Sale where datetime >= ? and datetime <=?", array("$yesterday 0:0:0", "$yesterday 23:59:59"));
while($row = $res->fetchRow(DB_FETCHMODE_ASSOC))
{
	if($hitids[$row['hits_id']])
	{
		$stats[$row['affiliate_id']][$hitids[$row['hits_id']]]['sales']++;
	}
}

$sth = $db->prepare("insert into subid_stats (affiliate_id, date, sub_id, hits, uniques, second_hits, signups) values (?,?,?,?,?,?,?)");
foreach($stats as $aid=>$s)
{
	foreach($s as $subid => $st)
	{
		$db->execute($sth, array($aid, $yesterday, $subid, $st['hits'], $st['uniques'], $st['second_hits'], $st['signups']));
	}
}

