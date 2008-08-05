<?php
//administrate the scales
//for now lets just do the default one
error_reporting(E_ALL);
ini_set('display_errors',1);
require_once('../phpinclude/classScale.inc.php');
require_once('../phpinclude/classProgram.inc.php');
require_once('../phpinclude/classSmartyEC.inc.php');
main();

function main()
{
	@$action = $_REQUEST['action'];
	@$affiliate_id = $_REQUEST['affiliate_id'];
	@$program_id = $_REQUEST['program_id'];
	if(!$affiliate_id)
		$affiliate_id = 'default';

	if(!$program_id)
		$program_id=1;

	switch($action)
	{
		case 'add_scale':
			add_scale($affiliate_id, $program_id);
			forward_to_main_page();
			break;
		case 'save_all':
			save_all($affiliate_id, $program_id);
			forward_to_main_page();
			break;
		case 'ajax_list_scales':
			ajax_list_scales($affiliate_id, $program_id);
			break;
		case 'delete_scale':
			delete_scale($_REQUEST['id']);
			ajax_list_scales($affiliate_id, $program_id);
			break;
		case 'save_scale':
			save_scale($affiliate_id, $program_id);
			ajax_list_scales($affiliate_id, $program_id);
			break;
		case '':
		case 'list_scales':
		default:
			list_scales($affiliate_id, $program_id);
			break;
	}
}
function save_scale($affliate_id, $program_id=1)
{
	
	$val = $_REQUEST['id'];
	$scale =& new Scale();
	if($val != 'new')
		$scale->getById($val);
	else 
		$scale->setAffiliateId($affliate_id);
	$scale->setProgramId($program_id);
	$scale->setPercentage($_REQUEST['percentage' . "_$val"]);
	$scale->setSignups($_REQUEST['signups' . "_$val"]);
	$scale->setRevsharepercent($_REQUEST['revsharepercent' . "_$val"]);
	$scale->setPriceperhit($_REQUEST['priceperhit' . "_$val"]);
	$scale->setPricePersignup($_REQUEST['pricepersignup' . "_$val"]);
	$scale->setPricereducedpercancel($_REQUEST['pricereducedpercancel' . "_$val"]);
	$scale->setPricereducedperchargeback($_REQUEST['pricereducedperchargeback' . "_$val"]);
	$scale->_update();
	
}
function save_all($affiliate_id, $program_id=1)
{
	foreach($_REQUEST as $key => $val)
	{
		if(preg_match("/id_(.*?)/", $key, $matches))
		{
			$scale =& new Scale();
			
			$scale->getById($val);
			$scale->setProgramId($program_id);
			$scale->setPercentage($_REQUEST['percentage' . "_$val"]);
			$scale->setSignups($_REQUEST['signups' . "_$val"]);
			$scale->setRevsharepercent($_REQUEST['revsharepercent' . "_$val"]);
			$scale->setPriceperhit($_REQUEST['priceperhit' . "_$val"]);
			$scale->setPricePersignup($_REQUEST['pricepersignup' . "_$val"]);
			$scale->setPricereducedpercancel($_REQUEST['pricereducedpercancel' . "_$val"]);
			$scale->setPricereducedperchargeback($_REQUEST['pricereducedperchargeback' . "_$val"]);
		}
	}
}
function add_scale($affiliate_id, $program_id=1)
{
	$scale =& new Scale();
	$scale->setAffiliateId($affiliate_id);
	$scale->setProgramId($program_id);
	$scale->setPercentage($_REQUEST['percentage']);
	$scale->setSignups($_REQUEST['signups']);
	$scale->setRevsharepercent($_REQUEST['revsharepercent']);
	$scale->setPriceperhit($_REQUEST['priceperhit']);
	$scale->setPricePersignup($_REQUEST['pricepersignup']);
	$scale->setPricereducedpercancel($_REQUEST['pricereducedpercancel']);
	$scale->setPricereducedperchargeback($_REQUEST['pricereducedperchargeback']);
}
function list_scales($affiliate_id, $program_id=1)
{
	
	$scale = new Scale();
	$scales = $scale->getAllByAffiliateId($affiliate_id, $program_id);
//print "scales for $affiliate_id, $program_id";
	$smarty = new SmartyEC('../templates');
	$smarty->clear_all_cache();
	$smarty->assign('scales', $scales);
	$smarty->assign('affiliate_id', $affiliate_id);
	$smarty->assign('program_id', $program_id);
	$program = new Program();
	$programs = $program->getNames();
	//$smarty->assign('program_ids', array(1, 2, 3));
	//$smarty->assign('program_names', array('Default', 'No Console', 'Cross Sale'));
	$smarty->assign('program_ids', array_keys($programs));
	$smarty->assign('program_names', array_values($programs));
	$html = $smarty->fetch('admin/manage_scale.html');
	$output = array();
	$output['body'] = $html;
	
	_ajax_output($output);
}
function delete_scale($id)
{
	$db = new AffiliateProgramDB();
	$db->connect_to_db();
	
	$db->query('delete from Scale where id=?', array($id));
}
function ajax_list_scales($affiliate_id, $program_id=1)
{
	$ret = array();
	$scale = new Scale();
	$scales = $scale->getAllByAffiliateId($affiliate_id, $program_id);
	$smarty = new SmartyEC('../templates');
	$smarty->clear_all_cache();
	$smarty->assign('scales', $scales);
	$smarty->assign('affiliate_id', $affiliate_id);
	$smarty->assign('program_id', $program_id);
	$smarty->assign('program_ids', array(1, 2, 3));
	$smarty->assign('program_names', array('Default', 'No Console', 'Cross Sale'));
	$html = $smarty->fetch('admin/ajax_list_scales.html');
	$output = array();
	$output['body'] = $html;
	$output['element_id'] = 'scales';
	
	_ajax_output($output);
	
}
function _list_scales($affiliate_id, $program_id=1)
{
	$scale = new Scale();
	$scales = $scale->getAllByAffiliateId($affiliate_id, $program_id);
/*
  affiliate_id varchar(32),
  percentage float,
  signups int,
  priceperhit float,
  pricepersignup float,
  pricereducedpercancel float,
  pricereducedperchargeback float,
 */
	print "<h3>List Scales</h3>";
	print "<br><form method=post>Program<input type=hidden name=action value='list_scales'><input type=hidden name=affiliate_id value='$affiliate_id'>
	<select name='program_id'><option value='1' " . ($program_id == 1 ? 'selected' : '') . ">default</option><option value='2' " . ($program_id == 2 ? 'selected' : '') . ">No Console</option><option value='3' " . ($program_id == 3 ? 'selected' : '') . ">Cross Sales</option></select>
	<input type=submit value='Change Scale'></form><br>";
	print "<form method=post><input type=hidden name=action value='add_scale'><input type=hidden name=affiliate_id value='$affiliate_id'><input type=hidden name=program_id value='$program_id'>
	Add Scale<br>
	<table border=1>
	<tr><th>Percentage</th><th>Signups</th><th>Price Per Hit</th><th>Price Per Signup</th><th>Price Reduced Per Cancel</th><th>Price Reduced Per Chargeback</th></tr>
	<tr><td><input type=text name=percentage></td><td><input type=text name=signups></td><td><input type=text name=priceperhit></td><td><input type=text name=pricepersignup></td><td><input type=text name=pricereducedpercancel></td><td><input type=text name=pricereducedperchargeback></td></tr>
	</table><input type=submit></form>";

	print "<form method=post><input type=hidden name=action value='save_all'>";
	print "<input type=hidden name=affiliate_id value='$affiliate_id'><input type=hidden name=program_id value='$program_id'>";
	print "Scale for $affiliate_id";
	print "<table border=1>
	<tr><th>Percentage</th><th>Signups</th><th>Price Per Hit</th><th>Price Per Signup</th><th>Price Reduced Per Cancel</th><th>Price Reduced Per Chargeback</th></tr>";
	foreach($scales as $s)
	{
		$id = $s->getId();
		print "<input type=hidden name=id_$id value=$id>";
		print "<tr>";
		print "<td><input type=text name=percentage_$id value='" . $s->getPercentage() . "'></td>";
		print "<td><input type=text name=signups_$id value='" . $s->getSignups() . "'></td>";
		print "<td><input type=text name=priceperhit_$id value='" . $s->getPricePerHit() . "'></td>";
		print "<td><input type=text name=pricepersignup_$id value='" . $s->getPricepersignup() . "'></td>";
		print "<td><input type=text name=pricereducedpercancel_$id value='" . $s->getPricereducedpercancel() . "'></td>";
		print "<td><input type=text name=pricereducedperchargeback_$id value='" . $s->getPricereducedperchargeback() . "'></td>";
		print "</tr>";
	}
	print "</table>";
	print "<input type=submit value='Save These Scales'>";
	print "<br><Br><br><br><a name='description'>
	ok, you can techncially pay out by conversion ratio or based on number of signups. currently the system is only set up to
	pay out on number of signups. so make sure that for percentage you always put a 0.
	make sure you fill out every feidl as well.
	now the way this works is that if you want to pay $20 per signup for up to 10 signups then you want to pay $25 per sign up from 11 signups to 31 signups, then 31+ signups you want to pay $35 per signup you would do it like this:
	<br>
	the first entry you would put 10 in the signups box and 20 in the persignup box. this means that 0-10 signups will pay $20 per signup.<br>
	then you would make a second entry and put 31 in the signups box and 25 in teh per signup box.<br>
	then you would make another entry but put a large number like 999999999 for signups and put 35 in the pay per signup box. this means that signups 32 till 999999999 signups will pay 35 per signup
	";
}
function forward_to_main_page()
{
	//print "<script language=javascript>location.href='?'</script>";

	//print "<a href='?'>Continue</a>";
	$output = array();
	$output['ajax_call'] = 'manage_scale.php';
	_ajax_output($output);

}

function _ajax_output($output)
{
	require_once('../phpinclude/JSON.php');
        $json = new Services_JSON();
        $output = $json->encode($output);
        print $output;
}
