<?PHP
//needs to be run once per day at midnight
//will go through each line in table Stats
//and read the affiliate id. 
//if that affilaite has set a referrer id in Webmaster table
//it will get that referrer webmasters info
//and apply the percentage and add the affilaite incom * percentage to the referral income for the referrer webmaster

require_once('../phpinclude/classAffiliate.inc.php');
require_once('../phpinclude/classWebmaster.inc.php');
require_once('../phpinclude/classStats.inc.php');
require_once('../phpinclude/classAffiliate.inc.php');
require_once('../phpinclude/classAPConfig.inc.php');

$db = new AffiliateProgramDB();
$db->connect_to_db();


$res = $db->query("select date_format(date_sub(now(), interval 1 day), '%Y-%m-%d')");
list($date) = $res->fetchRow();
$res = $db->query("select * from Stats where date=?", $date);
while($row = $res->fetchRow(DB_FETCHMODE_ASSOC))
{
	if($row['signups'] == 0)
		continue;
	$affiliate = new Affiliate($db);
	$affiliate->getById($row['affiliate_id']);
	
	$webmaster =& new Webmaster($db);
	$webmaster->getById($affiliate->getWebmasterId());
	$total_signups = $webmaster->getTotalSignups();
	$webmaster->setTotalSignups($webmaster->getTotalSignups()+$row['signups']);
	if(!$webmaster->getReferredWebmasterId())
		continue;
		
	$w2 = new Webmaster($db);
	$w2->getById($webmaster->getReferredWebmasterId());
	$ref_percent = $w2->getReferralPercent();
	$ref_amount = $w2->getReferralAmount();
	
	$affiliate_ids = $w2->getAffiliateIDS();
	$affiliate_id = $affiliate_ids[0]; //just get the first affiliate id in the list to attribute it to
	
	if(!$ref_percent)
	{
		$conf = new APConfig($db);
		$conf_vars = $conf->get_all_vars();	
		$ref_percent = $conf_vars['referral_percent'];
	}
	if($ref_amount)
	{
		$amount = $ref_amount;
	}
	else
	{
		$amount = $row['income'] * ($ref_percent/100);
	}
	//gotta check if this is a bonus or not
	if($total_signups == 0)
	{
		$amount+= $conf_vars['referral_bonus'];	
	}
	//the following line is up above so this is a duplicate
	//$webmaster->setTotalSignups($webmaster->getTotalSignups()+$row['signups']);
	
	$stats =& new Stats($db);
	if($stats->getByAffiliateIdDate($affiliate_id, $date))
	{
		$refamt = $stats->getReferralIncome();
		$refamt += $amount;	
		$stats->setReferralIncome($refamt);
	}
	else
	{
		$stats->setDate($date);
		$stats->setAffiliateId($affiliate_id);
		$stats->setReferralIncome($amount);
			
	}
	
}
?>
