<?php
//hit tracking and forwarding program
require_once('../phpinclude/classStats.inc.php');
require_once('../phpinclude/classSite.inc.php');



$site = new Site();
//if a domain name is passed as field domain look up the site by that
if(@$_REQUEST['domain'] && !@$_REQUEST['sid'])
{
	$host_ar = explode('.', $_REQUEST['domain']);
	//hopefully there is no .co.uk domains
	$domain = $host_ar[count($host_ar)-2] . '.' . $host_ar[count($host_ar)-1];
	$site->getByDomain($domain);
	$_REQUEST['sid'] = $site->getId();
}
else 
{
	$site->getById($_REQUEST['sid']);
}


$unique = true;
if(isset($_COOKIE[$_REQUEST['sid']]))
	$unique = false;

$stats =& new Stats();
$hits_id = $stats->addHit($unique);

SetCookie($_REQUEST['sid'],$hits_id,time() + 84600,"/");
SetCookie('aid_' . $_REQUEST['sid'],$hits_id,time() + 84600,"/");





$link = $site->getMainURL();

if(!$link)
{
	$site->getById(1);

	$link = $site->getMainURL();
}

$hits_info  = '';
if(preg_match("/\?/", $link))
	$hits_info = '&';
else
	$hits_info = '?';

@$program_id=$_REQUEST['program_id'];
if($program_id)
	$pid = "&pid=$program_id";
	
$hits_info .= 'hitsid=' .  $hits_id . '&aid=' . $_REQUEST['aid'] . $pid;
if(preg_match("/MSIE .*?; Mac_PowerPC/", $_SERVER['HTTP_USER_AGENT']))
	header("Location: " . $link);
else
	header("Location: " . $link . $hits_info);





