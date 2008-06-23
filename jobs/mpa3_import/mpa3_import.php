<?php

	ini_set( 'include_path', '.:/usr/share/pear' );

	require_once	'DB/DataObject.php';

	define( 'NEW_DSN', 'mysql://root@unix(/private/tmp/mysql.sock)/AffiliateProgram' );
	define( 'MPA3_DSN', 'mysql://root@unix(/private/tmp/mysql.sock)/mpa3' );
	define( 'DO_DIR', '/Users/cshepher/Desktop/work/wasteland/DataObjects' );

	$dataobject_options =& PEAR::getStaticProperty( 'DB_DataObject', 'options' );
	$dataobject_options = array(
		'database_new'		=> NEW_DSN,
		'database_old'		=> MPA3_DSN,
		'schema_location'	=> DO_DIR,
		'class_location'	=> DO_DIR,
		'require_prefix'	=> DO_DIR,
		);

	$stats =& DB_DataObject::factory( 'Stats' );
	$dbh = $stats->getDatabaseConnection();

echo microtime()." 1. Clearing and Importing Affiliate Information (Webmaster/Affiliate/AffiliateLogin)\n";
	$mpa3_webmaster =& DB_DataObject::factory( 'Mpa3_webmasters' );
	$dbh->query( 'DELETE FROM Webmaster' );
	$dbh->query( 'DELETE FROM Affiliate' );
	$dbh->query( 'DELETE FROM AffiliateLogin' );
	$mpa3_webmaster->find();
	while( $mpa3_webmaster->fetch() )
	{
		$webmaster =& DB_DataObject::factory( 'Webmaster' );
		$webmaster->firstname           = $mpa3_webmaster->fname;
		$webmaster->lastname            = $mpa3_webmaster->lname;
		$webmaster->ssn_taxid           = $mpa3_webmaster->taxid; 
		$webmaster->street_address      = $mpa3_webmaster->address;
		$webmaster->postal_code         = $mpa3_webmaster->zip;
		$webmaster->city                = $mpa3_webmaster->city;
		$webmaster->state               = $mpa3_webmaster->state;
		$webmaster->country             = $mpa3_webmaster->country;
		$webmaster->email               = $mpa3_webmaster->email;
		$webmaster->referred_webmaster_id = 0;  
		$webmaster->aim                 = '';
		$webmaster->icq                 = $mpa3_webmaster->icq;
		$webmaster->company             = $mpa3_webmaster->company;
		$webmaster->pay_to              = $mpa3_webmaster->payto;
		$webmaster->minimum_payout      = $mpa3_webmaster->minpay;
		$webmaster->payment_method      = $mpa3_webmaster->payment_method;
		$webmaster->notes               = $mpa3_webmaster->notes;
		$webmaster->referral_percent    = 10;
		$webmaster->total_signups       = 0;
		$webmaster->udf1                = '';
		$webmaster->id			= $mpa3_webmaster->id;
		$webmaster->insert();

		$affiliate =& DB_DataObject::factory( 'Affiliate' );
		$affiliate->id = $webmaster->id;
		$affiliate->webmaster_id = $webmaster->id;
		$affiliate->program_id = 1;
		$affiliate->status = 'ACTIVE';
		$affiliate->insert();

		$affiliate_login =& DB_DataObject::factory( 'AffiliateLogin' );
		$affiliate_login->username = $mpa3_webmaster->username;
		$affiliate_login->password = $mpa3_webmaster->password;
		$affiliate_login->affiliate_id = $webmaster->id;
		$affiliate_login->insert();
	}

echo microtime()." 2. Clearing and Importing Sites (Site)\n";
	$dbh->query( 'DELETE FROM Site' );
	$mpa3_sites =& DB_DataObject::factory( 'Mpa3_sites' );
	$mpa3_sites->find();
	while( $mpa3_sites->fetch() )
	{
		$site =& DB_DataObject::factory( 'Site' );
		$site->name = $mpa3_sites->title;
		$site->description = '';
		$site->mainurl = $mpa3_sites->url;
		$site->membersurl = $mpa3_sites->members;
		$site->joinurl = '';
		$site->ext_siteid = 0;
		$site->id = $mpa3_sites->id;
		$site->insert();
	}

echo microtime()." 3. Clearing and Importing Hits (Hit)\n";
	$dbh->query( 'DELETE FROM Stats' );
	$dbh->query( 'DELETE FROM Hit' );
/*
	$mpa3_hits =& DB_DataObject::factory( 'Mpa3_hits' );
	$mpa3_hits->find();
	while( $mpa3_hits->fetch() )
	{
		$hit =& DB_DataObject::factory( 'Hit' );
		$hit->datetime		= date( 'YmdHis', strtotime( $mpa3_hits->visit_date ));
		$hit->affiliate_id	= $mpa3_hits->webmaster;
		$hit->hit_type		= 'first';
		$hit->ipaddress		= $mpa3_hits->ip;
		$hit->browser		= '';
		$hit->referring_url	= $mpa3_hits->referrer;
		$hit->site_id		= $mpa3_hits->site;
		$hit->uniq		= 1;
		$hit->program_id	= 1;
		$hit->insert();

		$stats =& DB_DataObject::factory( 'Stats' );
		$stats->date = $mpa3_hits->visit_date;
		$stats->affiliate_id = $mpa3_hits->webmaster;
		$stats->find();
		if( !$stats->fetch() )
		{
			$stats->hits = 1;
			$stats->insert();
		} else {
			$stats->hits += 1;
			$stats->update();
		}
		$stats->free();
	}
*/

echo microtime()." 4. Clearing and Importing Sales Info (Sales)\n";
	$dbh->query( 'DELETE FROM Sale' );
	$mpa3_transactions =& DB_DataObject::factory( 'Mpa3_transactions' );
	$mpa3_transactions->find();
	while( $mpa3_transactions->fetch() )
	{
		$sale =& DB_DataObject::factory( 'Sale' );
		$sale->datetime		= date( 'YmdHis', strtotime ( $mpa3_transactions->trn_date ));
		$sale->affiliate_id	= $mpa3_transactions->webmaster;
		$sale->amount		= $mpa3_transactions->amount;
		$sale->type		= 'newsale';
		$sale->hits_id		= 0;
		$sale->affiliate_payout = $mpa3_transactions->signup_p;
		$sale->scale_id		= 1;
		$sale->processor_id	= $mpa3_transactions->processor;
		$sale->site_id		= $mpa3_transactions->site;
		$sale->transaction_id	= $mpa3_transactions->transaction_id;
		$sale->member_id	= $mpa3_transactions->subscription_id;
		$sale->notes		= 'Imported from MPA3';
		$sale->insert();
		$sale->free();
	}

echo microtime()." 5. Clearing and Importing Stats Info (Stats)\n";
	$dbh->query( 'DELETE FROM Stats' );
	$mpa3_stats =& DB_DataObject::factory( 'Mpa3_all_stats' );
	$mpa3_stats->find();
	while( $mpa3_stats->fetch() )
	{
		$stats =& DB_DataObject::factory( 'Stats' );
		$stats->date		= date( 'Ymd', strtotime( $mpa3_stats->date ));
		$stats->affiliate_id	= $mpa3_stats->webmaster;
		$stats->find();
		if( $stats->fetch() )
		{
			$stats->uniques		+= $mpa3_stats->uniques;
			$stats->hits		+= $mpa3_stats->uniques;
			$stats->signups		+= $mpa3_stats->free_trials + $mpa3_stats->trials + $mpa3_stats->full_price;
			$stats->renewals	+= $mpa3_stats->conversions + $mpa3_stats->rebills;
			$stats->chargebacks	+= $mpa3_stats->chargebacks_count;
			$stats->income		+= $mpa3_stats->payout;
			$stats->paid		+= $mpa3_stats->paid;
			$stats->update();
		} else {
			$stats->uniques		= $mpa3_stats->uniques;
			$stats->hits		= $mpa3_stats->uniques;
			$stats->signups		= $mpa3_stats->free_trials + $mpa3_stats->trials + $mpa3_stats->full_price;
			$stats->renewals	= $mpa3_stats->conversions + $mpa3_stats->rebills;
			$stats->chargebacks	= $mpa3_stats->chargebacks_count;
			$stats->income		= $mpa3_stats->payout;
			$stats->second_hits	= 0;
			$stats->crosssales	= 0;
			$stats->cancels		= 0;
			$stats->paid		= $mpa3_stats->paid;
			$stats->insert();
		}
		$stats->free();
	}
	$dbh->query( "UPDATE Stats SET Paid = 1 WHERE Paid > 1" );

echo microtime()." Fixing _seq tables\n";
	$tables_to_fix = array( 'AffiliateLogin', 'Affiliate', 'Hit', 'Sale', 'Scale', 'Site', 'Stats', 'Webmaster' );
	foreach( $tables_to_fix as $table )
	{
		$res = $dbh->query( 'SELECT max(id) AS mx FROM '.$table );
		$row = $res->fetchRow( DB_FETCHMODE_ASSOC );
		$max = $row['mx']+1;
		$dbh->query( 'DELETE FROM '.$table.'_seq' );
		$dbh->query( 'INSERT INTO '.$table.'_seq VALUES( '.$max.' )' );
	}

echo microtime()." Done\n";
