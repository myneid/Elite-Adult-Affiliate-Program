<?php
//ini_set( 'display_errors', true );

//links.php  this file will generate teh links to show to the webmaster
require_once('../phpinclude/classAffiliateLogin.inc.php');
require_once('../phpinclude/classAffiliateProgramDB.inc.php');
require_once('../phpinclude/classAffiliate.inc.php');
require_once('../phpinclude/classSite.inc.php');
require_once('../phpinclude/classSmartyEC.inc.php');
require_once('../phpinclude/classAPConfig.inc.php');

define( 'BANNER_BASE', '/web/pinkpays.com/banners' );
define( 'BANNER_URL', 'http://new.pinkpays.com/banners' );

$banner_sizes = array(
	'468x60'	=> '460x60',
	'468x80'	=> '468x80',
	'500x300'	=> '500x300',
	'120x60'	=> '120x60',
	'125x125'	=> '125x125',
	'240x60'	=> '240x60',
	'full_page'	=> 'Full Page',
	'half_page'	=> 'Half Page',
	'exit_console'	=> 'Exit Console'
	);

$db = new AffiliateProgramDB();
$db->connect_to_db();

$apconfig = new APConfig($db);
$config_vars = $apconfig->get_all_vars();

$auth = new AffiliateLogin($db);

$affiliate_id = $auth->getAffiliateId();
$affiliate = new Affiliate($db);
$affiliate->getById($affiliate_id);

$site=new Site($db);
$site->getById( $_REQUEST['sid'] );

while( list( $directory, $typename ) = each( $banner_sizes ))
{
	// scan directory
	$dh = opendir( BANNER_BASE.'/'.intval( $_REQUEST['sid'] ).'/'.$directory );
	if( $dh === false )
	{
		continue;
	}
	while(( $file = readdir( $dh )) !== false )
	{
		if( substr( $file, 0, 1 ) == '.' )
		{
			continue;
		}
		$banner['path'] = BANNER_URL.'/'.intval( $_REQUEST['sid'] ).'/'.$directory.'/'.$file;
		$banner['size'] = $typename;
		$banner['name'] = $file;
		$banners[] = $banner;
	}
	closedir( $dh );
}

$smarty = new SmartyEC('../templates');
$smarty->clear_all_cache();
$smarty->assign( 'banners', $banners );
$smarty->assign( 'sitename', $site->getName() );
$smarty->display('banners.html');
