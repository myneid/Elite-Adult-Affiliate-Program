<?php
//ini_set('display_errors', true);
//affiliate management
//search for an affiliate
//display list of searched for affilaites
//display edit feilds for affiliate info
//save affilaite info
require_once('../phpinclude/classAffiliateProgramDB.inc.php');
require_once('../phpinclude/classAffiliateLogin.inc.php');
require_once('../phpinclude/classSmartyEC.inc.php');
require_once('../phpinclude/classWebmaster.inc.php');
require_once('../phpinclude/classWireInfo.inc.php');

main();
function main()
{
	@$action = $_REQUEST['action'];
	
	switch($action)
	{
		case 'view_affiliate_info':
			view_by_affid();
			break;
		case 'view_webmaster_info':
			view_webmaster_info();
			break;
		case 'save_webmaster':
			save_webmaster();
			print_search_box();
			break;
		case 'view_wire_info':
			view_wire_info();
			break;
		case 'save_wire_info':
			save_wire_info();
			view_webmaster_info();
			break;
		case 'search':
			search();
			break;
		case 'aff_login':
			do_aff_login();
			break;
		default:
		case '':
		case 'print_search_box':
			print_search_box();
			break;
	}
}
function view_by_affid()
{
	$aff = new Affiliate();
	$aff->getByID( $_REQUEST['affid'] );
	$_REQUEST['webmaster_id'] = $aff->webmaster_id;
	view_webmaster_info();
}
function do_aff_login()
{
	require_once('../phpinclude/classAPConfig.inc.php');
	$config_obj = new APConfig();
	$config = $config_obj->get_all_vars();
	
	@session_start();
	$affSession = new AffiliateLogin( false, false );
	$affSession->getByAffiliateID( $_REQUEST['affid'] );
	$q = "update AffiliateLogin set session_id=NULL where session_id=?";
	$affSession->db->query( $q, array( session_id() ));
	header( "Location: " . $config['base_url'] . "/affiliate/stats.php?username={$affSession->username}&password={$affSession->password}" );
	exit;
}
function save_webmaster()
{
	$webmaster = new Webmaster();
	$webmaster->getById($_REQUEST['webmaster_id']);	
	
	$webmaster->setFirstname($_REQUEST['firstname']);
	$webmaster->setLastname($_REQUEST['lastname']);
	$webmaster->setStreetAddress($_REQUEST['street_address']);
	$webmaster->setCity($_REQUEST['city']);
	$webmaster->setState($_REQUEST['state']);
	$webmaster->setPostalCode($_REQUEST['postal_code']);
	$webmaster->setCountry($_REQUEST['country']);
	$webmaster->setEmail($_REQUEST['email']);
	$webmaster->setSsnTaxid($_REQUEST['ssn_taxid']);
	$webmaster->setAim($_REQUEST['aim']);
	$webmaster->setIcq($_REQUEST['icq']);
	$webmaster->setCompany($_REQUEST['company']);
	$webmaster->setPayTo($_REQUEST['pay_to']);
	$webmaster->setMinimumPayout($_REQUEST['minimum_payout']);
	$webmaster->setPaymentMethod($_REQUEST['payment_method']);
	$webmaster->setNotes($_REQUEST['notes']);
	$webmaster->setReferralPercent($_REQUEST['referral_percent']);
	$webmaster->setReferralAmount($_REQUEST['referral_amount']);
	$webmaster->setReferredWebmasterId($_REQUEST['referred_webmaster_id']);
	$webmaster->setUDF1( $_REQUEST['udf1'] );
	
	$webmaster->save();
	
	//save affiliate login and affiliate
	$affiliate_ids = $webmaster->getAffiliateIDs();
	
	
	$aids = array();
	foreach($affiliate_ids as $aid)
	{
		$aff_login =& new AffiliateLogin(false, false);
		$aff_login->getByAffiliateId($aid);
		$aff_login->setUsername($_REQUEST["username_$aid"]);
		$aff_login->setPassword($_REQUEST["password_$aid"]);
		
		$affiliate =& new Affiliate();
		$affiliate->getById($aid);
		$affiliate->setStatus($_REQUEST["status_$aid"]);
		$affiliate->setRating($_REQUEST["rating_$aid"]);
	}
	//print "<script language=javascript>history.go(-2)</script>";
	
}
function view_wire_info()
{
	$wireinfo = new Wire_Info();
	$wireinfo->getByWebmasterID( $_REQUEST['webmaster_id'] );

	$res = $wireinfo->db->query("select name, alpha2 from countrycodes");
	$countries = array();
	while(list($name, $code) = $res->fetchRow())
	{
		$countries[$code] = $name;
	}

	$smarty = new SmartyEC("../templates");     
	$smarty->clear_all_cache();
	$smarty->assign('webmaster_id', $_REQUEST['webmaster_id']);
	$smarty->assign('countries', $countries);
	$smarty->assign('fullname', $wireinfo->getFullName() );
	$smarty->assign('phonenumber', $wireinfo->getPhoneNumber() );
	$smarty->assign('bankname', $wireinfo->getBankName() );
	$smarty->assign('bankcity', $wireinfo->getBankCity() );
	$smarty->assign('bankcountry', $wireinfo->getBankCountry() );
	$smarty->assign('bankswift', $wireinfo->getBankSWIFT() );
	$smarty->assign('bankaba', $wireinfo->getBankABA() );
	$smarty->assign('bankphonenumber', $wireinfo->getBankPhoneNumber() );
	$smarty->assign('accountnumber', $wireinfo->getAccountNumber() );
	$smarty->assign('intermediarybankname', $wireinfo->getIntermediaryBankName() );
	$smarty->assign('intermediarybankcity', $wireinfo->getIntermediaryBankCity() );
	$smarty->assign('intermediarybankcountry', $wireinfo->getIntermediaryBankCountry() );
	$smarty->assign('intermediarybankswift', $wireinfo->getIntermediaryBankSWIFT() );
	$smarty->assign('intermediarybankaba', $wireinfo->getIntermediaryBankABA() );
	$smarty->assign('intermediaryaccountnumber', $wireinfo->getIntermediaryAccountNumber() );
	$smarty->assign('other', $wireinfo->getOther() );

	$output['body']=$smarty->fetch('admin/manage_affiliates_view_wire_info.html');
	_ajax_output($output);	
}
function save_wire_info()
{
	$wireinfo = new Wire_Info();
	$wireinfo->getByWebmasterID( $_REQUEST['webmaster_id'] );

	// following line necessary if record wasn't found...
	$wireinfo->setWebmasterID( $_REQUEST['webmaster_id'] );
	$wireinfo->setFullName( $_REQUEST['fullname'] );
	$wireinfo->setPhoneNumber( $_REQUEST['phonenumber'] );
	$wireinfo->setBankName( $_REQUEST['bankname'] );
	$wireinfo->setBankCity( $_REQUEST['bankcity'] );
	$wireinfo->setBankCountry( $_REQUEST['bankcountry'] );
	$wireinfo->setBankSWIFT( $_REQUEST['bankswift'] );
	$wireinfo->setBankABA( $_REQUEST['bankaba'] );
	$wireinfo->setBankPhoneNumber( $_REQUEST['bankphonenumber'] );
	$wireinfo->setAccountNumber( $_REQUEST['accountnumber'] );
	$wireinfo->setIntermediaryBankName( $_REQUEST['intermediarybankname'] );
	$wireinfo->setIntermediaryBankCity( $_REQUEST['intermediarybankcity'] );
	$wireinfo->setIntermediaryBankSWIFT( $_REQUEST['intermediarybankswift'] );
	$wireinfo->setIntermediaryBankABA( $_REQUEST['intermediarybankaba'] );
	$wireinfo->setIntermediaryAccountNumber( $_REQUEST['intermediaryaccountnumber'] );
	$wireinfo->setOther( $_REQUEST['other'] );

	$wireinfo->_update();
}
function view_webmaster_info()
{
	$webmaster = new Webmaster();
	$webmaster->getById($_REQUEST['webmaster_id']);
	$affiliate_ids = $webmaster->getAffiliateIDs();
	
	$aff_login = new AffiliateLogin(false, false);
	$aids = array();
	foreach($affiliate_ids as $aid)
	{
		$aff_login->getByAffiliateId($aid);
		$aids[$aid]['username'] = $aff_login->getUsername();
		$aids[$aid]['password'] = $aff_login->getPassword();
		
		$affiliate = new Affiliate();
		$affiliate->getById($aid);
		$aids[$aid]['status'] = $affiliate->getStatus();
		//$aids[$aid]['rating'] = $affiliate->getRating();
		
		//check scale
		$res = $webmaster->db->query("select * from Scale where affiliate_id=?", array($aid));
		if($res->numRows() == 0)
		{
			//uses default scale, click here to create a custom scale
			$aids[$aid]['scale_text'] = "Uses Default pay scale. <a href='javascript:ajax_call(\"manage_scale.php?affiliate_id=$aid\", \"Manage Scale\")'>Click here to give a custom pay scale.</a>";
		}
		else 
		{
			//uses a custom scale, click here to view/modify it or click here to delete it and use the default scale
			$aids[$aid]['scale_text'] = "Uses Custom pay scale. <a href='javascript:ajax_call(\"manage_scale.php?affiliate_id=$aid\", \"Manage Scale\")'>Click here to edit pay scale.</a>  <a href='javascript:ajax_call(\"manage_scale.php?affiliate_id=$aid&action=delete\", \"Delete Scale\")'>Click here to delete custom pay scale.</a>";
	
		}
	}

	$res = $webmaster->db->query("select name, alpha2 from countrycodes");
	$countries = array();
	while(list($name, $code) = $res->fetchRow())
	{
		$countries[$code] = $name;	
	}

	$payment_methods = array(
		'Check'      => 'Check',
		'Wire'       => 'Wire',
		'ePassporte' => 'ePassporte',
		'PayPal'     => 'PayPal',
	);
	
	
	$smarty = new SmartyEC("../templates");
	$smarty->clear_all_cache();
	$smarty->assign('webmaster_id', $_REQUEST['webmaster_id']);
	$smarty->assign('firstname', $webmaster->getFirstname());
	$smarty->assign('lastname', $webmaster->getLastName());
	$smarty->assign('ssn_taxid', $webmaster->getSsnTaxid());
	$smarty->assign('street_address', $webmaster->getStreetAddress());
	$smarty->assign('postal_code', $webmaster->getPostalCode());
	$smarty->assign('city', $webmaster->getCity());
	$smarty->assign('state', $webmaster->getState());
	$smarty->assign('country', strtoupper($webmaster->getCountry()));
	$smarty->assign('email', $webmaster->getEmail());
	$smarty->assign('referred_webmaster_id', $webmaster->getReferredWebmasterId());
	$smarty->assign('aim', $webmaster->getAim());
	$smarty->assign('icq', $webmaster->getIcq());
	$smarty->assign('company', $webmaster->getCompany());
	$smarty->assign('pay_to', $webmaster->getPayTo());
	$smarty->assign('minimum_payout', $webmaster->getMinimumPayout());
	$smarty->assign('payment_method', $webmaster->getPaymentMethod());
	$smarty->assign('notes', $webmaster->getNotes());
	$smarty->assign('referral_percent', $webmaster->getReferralPercent());
	$smarty->assign('referral_amount', $webmaster->getReferralAmount());
	$smarty->assign('udf1', $webmaster->getUDF1());
	
	$smarty->assign('countries', $countries);
	
	$smarty->assign('affiliate_ids', $aids);
	
	$smarty->assign('affiliate_statuss', array('ACTIVE'=>'ACTIVE', 'DISABLED'=>'DISABLED', 'DISABLED-SPAM'=>'DISABLED-SPAM'));
	$smarty->assign('payment_methods', $payment_methods );
	$smarty->assign('wirelink', '[ <A HREF="'.$_SERVER['PHP_SELF']."?action=view_wire_info&webmaster_id=".$_REQUEST['webmaster_id'].'">Manage Wire Payment Info</a> ]');
	
	$output['body']=$smarty->fetch('admin/manage_affiliates_view_webmaster_info.html');
	_ajax_output($output);	
	
}
function search()
{
	$db = new AffiliateProgramDB();
	$db->connect_to_db();
	$res = 	$db->query("select * from Webmaster,Affiliate,AffiliateLogin where Affiliate.webmaster_id=Webmaster.id and Affiliate.id=AffiliateLogin.affiliate_id and (firstname like ? or lastname like ? or ssn_taxid like ? or street_address like ? or postal_code like ? or city like ? or state like ? or country like ? or email like ? or referred_webmaster_id like ? or aim like ? or icq like ? or company like ? or pay_to like ? or  username like ? or  Affiliate.id like ?) order by Affiliate.id", array('%' . $_REQUEST['search_for'] . '%', '%' . $_REQUEST['search_for'] . '%','%' . $_REQUEST['search_for'] . '%','%' . $_REQUEST['search_for'] . '%','%' . $_REQUEST['search_for'] . '%','%' . $_REQUEST['search_for'] . '%','%' . $_REQUEST['search_for'] . '%','%' . $_REQUEST['search_for'] . '%','%' . $_REQUEST['search_for'] . '%','%' . $_REQUEST['search_for'] . '%','%' . $_REQUEST['search_for'] . '%','%' . $_REQUEST['search_for'] . '%','%' . $_REQUEST['search_for'] . '%','%' . $_REQUEST['search_for'] . '%','%' . $_REQUEST['search_for'] . '%','%' . $_REQUEST['search_for'] . '%'));
	if(DB::isError($res))
		print_r($res);
	$smarty = new SmartyEC("../templates");
	$smarty->clear_all_cache();
	$return = array();
	while($row = $res->fetchRow(DB_FETCHMODE_ASSOC))
	{
		array_push($return, $row);
	}
	$smarty->assign(array('affiliates' => $return));
	$output['body']=$smarty->fetch('admin/manage_affiliates_search_results.html');	
	_ajax_output($output);	
	
}
function print_search_box()
{
	$smarty = new SmartyEC("../templates");
	$smarty->clear_all_cache();
	$output['body']=$smarty->fetch('admin/manage_affiliates_searchbox.html');	
	_ajax_output($output);	
}

function forward_to_main_page()
{
	//print "<script language=javascript>location.href='?'</script>";
	//print "<a href='?'>Continue</a>";
	$output = array();
	$output['ajax_call'] = 'manage_affiliates.php';
	_ajax_output($output);
}

function _ajax_output($output)
{
	require_once('../phpinclude/JSON.php');
        $json = new Services_JSON();
        $output = $json->encode($output);
        print $output;
}
