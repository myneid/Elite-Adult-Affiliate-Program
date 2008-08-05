<?php
//ini_set("display_errors", "on");
//site admin, administrate the sites
require_once('../phpinclude/classSite.inc.php');
require_once('../phpinclude/classSmartyEC.inc.php');
main();

function main()
{
	@$action = $_REQUEST['action'];
	switch($action)
	{
		case 'add_site_page':
			add_site_page();
			break;
		case 'delete_site':
			delete_site();
			break;
		case 'add_site':
			add_site();
			forward_to_main_page();
			break;
		case '':
		case 'list_sites':
		default:
			list_sites();
			break;
	}
}
function add_site_page()
{
	$site = new Site();

	if($_REQUEST['id'])
	{
		$site->getById($_REQUEST['id']);
	}
	$output = array();
	$smarty = new SmartyEC('../templates');
	$smarty->clear_all_cache();
	$smarty->assign('site', $site);
	$smarty->assign('statuss', array('active','innactive','disabled','deleted') );
	$output['body'] = $smarty->fetch('admin/manage_sites_add.html');
	_ajax_output($output);
}
function delete_site()
{
	$site =& new Site();
	if($_REQUEST['id'])
		$site->getById($_REQUEST['id']);
	else
	{
		print "bad site id";
		exit;
	}
	$site->setStatus('deleted');
	forward_to_main_page();

}
function add_site()
{
	$site =& new Site();
	if($_REQUEST['id'])
		$site->getById($_REQUEST['id']);

	$site->setName($_REQUEST['name']);
	$site->setDescription($_REQUEST['description']);
	$site->setMainurl($_REQUEST['mainurl']);
	$site->setMembersurl($_REQUEST['membersurl']);
	$site->setJoinurl($_REQUEST['joinurl']);
	$site->setStatus($_REQUEST['status']);
}
function list_sites()
{
	$msite = new Site();
	$sites = $msite->getAll();

	/*
	  id int not null primary key auto_increment,
  name varchar(32),
  description varchar(128),
  mainurl varchar(128),
  membersurl varchar(128),
  joinurl varchar(128)
  */
	$output = array();
	$smarty = new SmartyEC('../templates');
	$smarty->assign('sites', $sites);
	$output['body']=$smarty->fetch('admin/manage_sites_list.html');
	
	_ajax_output($output);


}
function forward_to_main_page()
{
	//print "<script language=javascript>location.href='?'</script>";
	//print "<a href='?'>Continue</a>";
	$output = array();
	$output['ajax_call'] = 'manage_sites.php';
	_ajax_output($output);
}

function _ajax_output($output)
{
	require_once('../phpinclude/JSON.php');
        $json = new Services_JSON();
        $output = $json->encode($output);
        print $output;
}
