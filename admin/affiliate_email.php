<?php
require_once '../phpinclude/classAffiliateProgramDB.inc.php';
require_once('../phpinclude/classWebmaster.inc.php');
require_once('../phpinclude/classSmartyEC.inc.php');
require_once 'Mail.php';
require_once 'Mail/mime.php';

main();

function main()
{
	@$action = $_REQUEST['action'];
	switch($action)
	{
		case 'sendemail':
			send_email();
			break;
		default:
		case '':
			show_form();
			break;
	}
}

function show_form()
{
	$smarty = new SmartyEC('../templates');
	$smarty->clear_all_cache();
	$smarty->assign('program_id', 1);
	$smarty->assign('program_ids', array(1,2));
	$smarty->assign('program_names', array('Default', 'No Console' ));
	$smarty->display('admin/affiliate_email.html');
		
}

function send_email()
{
	$program_id = stripslashes( $_REQUEST['program_id'] );
	$subject    = stripslashes( $_REQUEST['subject'] );
	$body       = stripslashes( $_REQUEST['body'] );
	$from       = stripslashes( $_REQUEST['from'] );
	$db         = new AffiliateProgramDB();

	set_time_limit(0);

	$db->connect_to_db();

	echo "Sending EMail...<BR>\n";
	$query = "SELECT t2.id AS id,t1.email AS email,t3.username AS username FROM Webmaster AS t1 LEFT JOIN Affiliate AS t2 ON t2.webmaster_id=t1.id LEFT JOIN AffiliateLogin AS t3 ON t3.affiliate_id=t2.id WHERE t2.id IS NOT NULL";
	$res = $db->query( $query );
	while( $ar = $res->fetchRow(DB_FETCHMODE_ASSOC) ) {
		$email = $ar['email'];

		$wm_subject = str_replace( "@username@", $ar['username'], $subject );
		$wm_subject = str_replace( "@affiliate_id@", $ar['id'], $wm_subject );

		$wm_body = str_replace( "@username@", $ar['username'], $body );
		$wm_body = str_replace( "@affiliate_id@", $ar['id'], $wm_body );

		$headers = array(
				'From' => $from,
				'Subject' => $wm_subject );

		$mime = new Mail_mime( "\n" );
		$mime->setHTMLBody( $wm_body );

//		$ebody = str_replace( "=3D", "=", $mime->get() );
		$ebody = $mime->get( array( 'html_encoding' => '7bit' ));
		$hdrs = $mime->headers( $headers );
		$mail =& Mail::factory( 'mail' );
		$mail->send( $email, $hdrs, $ebody );
//$fp=fopen('/tmp/mailout/'.$ar['id'],'w');
//fwrite($fp, "$email\n$hdrs\n$ebody\n" );
//fclose($fp);
	}
	echo "Mail sent. <A HREF=/admin/affiliate_email.php>Click Here to Continue.</a><BR>\n";
}

?>
