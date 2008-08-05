<?php
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");    // Date in the past
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
                                                             // always modified
header("Cache-Control: no-store, no-cache, must-revalidate");  // HTTP/1.1
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
//admin program for the APConfig class
require_once('../phpinclude/classAPConfig.inc.php');
require_once('../phpinclude/classSmartyEC.inc.php');
main();
function main()
{
	@$action = $_REQUEST['action'];
	switch($action)
	{
		case 'add':
		case 'edit':
			edit();
			forward_to_main_page();
			break;
		case 'add_page':
		case 'edit_page':
			edit_page();
			break;
		case '':
		case 'list_config':
		default:
			list_config();	
			break;
	}	
}
function edit_page()
{
	$config = new APConfig();
	if($_REQUEST['id'])
		$config->getById($_REQUEST['id']);
		
	$smarty = new SmartyEC("../templates");
	$smarty->assign('name', $config->getName());
	$smarty->assign('id', $config->getId());
	$smarty->assign('value', $config->getValue());
	$smarty->assign('description', $config->getDescription());
	$output['body']=$smarty->fetch('admin/manage_config_edit.html');	
	_ajax_output($output);
}
function edit()
{
	$config =& new APConfig();
	if($_REQUEST['id'])
		$config->getById($_REQUEST['id']);
	
	$config->setName($_REQUEST['name']);
	$config->setValue($_REQUEST['value']);
	$config->setDescription($_REQUEST['description']);
}
function list_config()
{
	$config = new APConfig();
	$allconfig = $config->getAll();
	
	$configvars = array();
	foreach($allconfig as $c)
	{
		$configvars[$c->getId()]['name'] = $c->getName();	
		$configvars[$c->getId()]['value'] = $c->getValue();	
		$configvars[$c->getId()]['description'] = $c->getDescription();	
	}
	$smarty = new SmartyEC("../templates");
	$smarty->clear_all_cache();
	$smarty->assign('configvars', $configvars);
	$output['body']=$smarty->fetch('admin/manage_config_list.html');
	_ajax_output($output);
}
function _forward_to_main_page()
{
	print "<script language=javascript>location.href='?'</script>";
	print "<a href='?'>Continue</a>";	
}
function forward_to_main_page()
{
	//print "<script language=javascript>location.href='?'</script>";
	//print "<a href='?'>Continue</a>";
	$output = array();
	$output['ajax_call'] = 'manage_config.php';
	_ajax_output($output);
}

function _ajax_output($output)
{
	require_once('../phpinclude/JSON.php');
        $json = new Services_JSON();
        $output = $json->encode($output);
        print $output;
}
