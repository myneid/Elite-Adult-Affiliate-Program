<?php

require_once 'PEAR.php';
require_once 'classAffiliateProgramDB.inc.php';
require_once('classStats.inc.php');
require_once('classHit.inc.php');
require_once('classSale.inc.php');
require_once('classSite.inc.php');
/**
* all reports that are generated should be calling this class. it will handle every single report
* and call out to the other objects that it needs to complete its job. it should return the array
* ready for a smarty template.
*
* long description of class
*
* @author Tanguy de Courson <tanguy@0x7a69.net>
* @author Derek Volker <dvolker@0x7a69.net>
* @version .9b
* @access public
* @package AffiliateProgram
*/
class Reports extends PEAR
{
	/**
	* description of id
	*@var int
	*/
	var $id;
	/**
	* description of affiliate_id
	*@var int
	*/
	var $affiliate_id;
	/**
	* description of begin_date
	*@var date
	*/
	var $begin_date;
	/**
	* description of end_date
	*@var date
	*/
	var $end_date;
	
	/**
	*determines weather this record was changed with the set accessor methods
	*@var boolean
	*/
	var $_modified = false;
	
	/**
	* contains the PEAR DB object
	* @var object
	*/
	var $db;
	/**
	* if the current object record is a new one or one already in the database
	*@var boolean
	*/
	var $_record_exists = false;
	/**
	* Constructor
	*
	* @access public
	*/
	function Reports($db = false)
	{
		$this->PEAR();
		
		if(!$db)
		{
			$mdb = new AffiliateProgramDB();
			$db = $mdb->connect_to_db();
		}
		$this->db = $db;
	}
	/**
	* Destructor
	*Descructor: this will call the _update function upon unset to tie changes into the database
	*
	* @access private
	*/
	function _Reports()
	{
		if($this->_modified)
		$this->_update();
	}
	/**
	* Acessor function to set the id variable
	*
	*@param mixed
	*@access public
	*/
	function setId($id)
	{
		$this->_modified = true;
		$this->id = $id;
	}
	/**
	* Acessor function to set the affiliate_id variable
	*
	*@param mixed
	*@access public
	*/
	function setAffiliateId($affiliate_id)
	{
		$this->_modified = true;
		$this->affiliate_id = $affiliate_id;
	}
	/**
	* Acessor function to set the begin_date variable
	*
	*@param mixed
	*@access public
	*/
	function setBeginDate($begin_date)
	{
		$this->_modified = true;
		$this->begin_date = $begin_date;
	}
	/**
	* Acessor function to set the end_date variable
	*
	*@param mixed
	*@access public
	*/
	function setEndDate($end_date)
	{
		$this->_modified = true;
		$this->end_date = $end_date;
	}
	/**
	* Acessor function to get the id variable
	*
	*@access public
	*@return mixed
	*/
	function getId()
	{
		return $this->id;
	}
	/**
	* Acessor function to get the affiliate_id variable
	*
	*@access public
	*@return mixed
	*/
	function getAffiliateId()
	{
		return $this->affiliate_id;
	}
	/**
	* Acessor function to get the begin_date variable
	*
	*@access public
	*@return mixed
	*/
	function getBeginDate()
	{
		return $this->begin_date;
	}
	/**
	* Acessor function to get the end_date variable
	*
	*@access public
	*@return mixed
	*/
	function getEndDate()
	{
		return $this->end_date;
	}
	/**
	*this function will update or insert into the database as needed
	*
	*@access private
	*/
	function _update()
	{
		$query = '';
		$valueArray = array();
		if($this->_record_exists)
		{
			//update
			$query = "update Reports set affiliate_id=?,begin_date=?,end_date=? where id=?";
			$valueArray = array($this->getAffiliateId(),$this->getBeginDate(),$this->getEndDate(),$this->getId());
		}
		else
		{
			//insert
			if($this->getId() == '')
			$this->setId($this->_generateNextId());
			
			$query = "insert into Reports (id,affiliate_id,begin_date,end_date) values (?,?,?,?)";
			$valueArray = array($this->getId(),$this->getAffiliateId(),$this->getBeginDate(),$this->getEndDate());
		}
		$sth = $this->db->prepare($query);
		$res = $this->db->execute($sth, $valueArray);
		if(DB::isError($res))
		{
			trigger_error($res->getmessage(), E_USER_ERROR);
		}
		$this->_modified = false;
		$this->_record_exists = true;
	}
	/**
	this function will get the record by its id
	*
	*@access public
	*/
	function getById($id = '')
	{
		if($id == '')
		$id = $this->getId();
		if(!$id)
		trigger_error("you must set id to get by it", E_USER_ERROR);
		
		$query = "select * from Reports where id=?";
		$sth = $this->db->prepare($query);
		$res = $this->db->execute($sth, array($id));
		
		$row = $res->fetchRow(DB_FETCHMODE_ASSOC);
		
		$this->setId($row['id']);
		$this->setAffiliateId($row['affiliate_id']);
		$this->setBeginDate($row['begin_date']);
		$this->setEndDate($row['end_date']);
		$this->_record_exists = true;
		$this->_modified = false;
	}
	
	/*
	*this function will generate the next id
	*
	*@access private
	*/
	function _generateNextId()
	{
		return $this->db->nextId("Reports", true);
	}
	
	
	
	/***************** This is where the real work starts **************************/
	//all these reporting functions will prepare an array for a smarty template
	//if you dont know smarty get with it http://smarty.php.net
	
	/**
	* this function should return an array
	* raws, uniques, signups, ratio, amount
	*
	*@access public
	*@return mixed array
	*/
	function generateTotalStats()
	{
		$return = array();
		$stats = new Stats($this->db);
		$return = $stats->getSumTotal($this->getBeginDate(), $this->getEndDate(), $this->getAffiliateId());
		
		
		$return['ratio'] = $this->getRatio($return['uniques'], $return['signups']);
		return $return;
		
	}
	/**
	* this will return an array for smarty that will seperate stats by site
	* this may take some time
	*
	*@access public
	*@return mixed array
	*/
	function generateStatsBySite()
	{
		$hit = new Hit($this->db);
		$hits_by_site = $hit->getTotalBySite($this->getBeginDate(), $this->getEndDate(), $this->getAffiliateId());
		$sale = new Sale($this->db);
		$sales_by_site = $sale->getTotalBySite($this->getBeginDate(), $this->getEndDate(), $this->getAffiliateId());

		$site = new Site($this->db);
		$sitenames = $site->getNames();
		
		$return = array();
		foreach($hits_by_site as $site_id => $hits_ar)
		{
			$return[$sitenames[$site_id]]['hits'] = sprintf("%d", $hits_ar['hits']);
			$return[$sitenames[$site_id]]['uniques'] = sprintf("%d", $hits_ar['uniques']);
			$return[$sitenames[$site_id]]['signups'] = 0;
			$return[$sitenames[$site_id]]['income'] = 0;
			$return[$sitenames[$site_id]]['ratio'] = "0:" . $hits_ar['uniques'];
			
		}
		
		foreach($sales_by_site as $site_id => $signup_ar)
		{
			$sales = $signup_ar['sales'];
			$income = $signup_ar['income'];
			$return[$sitenames[$site_id]]['signups'] = sprintf("%d", $sales);
			$return[$sitenames[$site_id]]['income'] = sprintf("%.2f", $income);
			$return[$sitenames[$site_id]]['ratio'] = $this->getRatio($return[$sitenames[$site_id]]['uniques'], $sales);
			
		}
		return $return;
		
		
	}

	/**
	* get per-site, per-affiliate totals
	*
	*@access public
	*@return mixed array
	*/
	function generateSiteStatsByAff($sitename)
	{
		$hit = new Hit($this->db);
		$hits_by_site = $hit->getSiteTotalByAff($this->getBeginDate(), $this->getEndDate());
		$sale = new Sale($this->db);
		$sales_by_site = $sale->getSiteTotalByAff($this->getBeginDate(), $this->getEndDate());
		
		$site = new Site($this->db);
		$sitenames = $site->getNames();
		while( list($id,$name) = each( $sitenames )) {
			if( $name == $sitename )
				break;
		}
		
		$return = array();
		foreach($hits_by_site[$id] as $aff_id => $hits_ar)
		{
			$return[$aff_id]['hits'] = @sprintf("%d", $hits_ar['hits']);
			$return[$aff_id]['uniques'] = @sprintf("%d", $hits_ar['uniques']);
			$return[$aff_id]['signups'] = 0;
			$return[$aff_id]['income'] = 0;
			$return[$aff_id]['ratio'] = "0:" . @$hits_ar['uniques'];
			
		}

		if( @is_array( $sales_by_site[$id] ))
		{
			foreach($sales_by_site[$id] as $aff_id => $signup_ar)
			{
				$sales = $signup_ar['sales'];
				$income = $signup_ar['income'];
				$return[$aff_id]['signups'] = sprintf("%d", $sales);
				$return[$aff_id]['income'] = sprintf("%.2f", $income);
				$return[$aff_id]['ratio'] = $this->getRatio(@$return[$sitenames[$site_id]]['uniques'], $sales);
			}
		}

		return $return;
		
		
	}
	/**
	* this will return an array by date of all the stats for hte given period
	*
	*@access public
	*@return mixed array
	*/
	function generateStatsByDay()
	{
		$return = array();
		$date = $this->getBeginDate();
		
		/* the mysql function datediff started in mysql 4.1.1 (atm not in production)
		$res = $this->db->query("select datediff(?,?)", array($this->getBeginDate(), $this->getEndDate()));
		if(DB::isError($res))
		print_r($res);
		list($num_days) = $res->fetchRow();
		*/
		
		$startt = strtotime($this->getBeginDate());
		$endt = strtotime($this->getEndDate());
		$difft = $endt-$startt;
		$minutes = $difft/60;
		$hours = $minutes/60;

		// the period containing the 'Spring Forward' ST->DT switch
		// will only have 14.95 days in it
		// i'd expect the 'Fall Back' DT->ST switch would conversely
		// contain 15.05 days
		// round() does what you'd expect and returns 15 in both
		// cases. -cs
		$num_days = round( $hours/24 );
		
		
		for($i=0; $i<=$num_days; $i++)
		{
			$stats = new Stats($this->db);
			$stats->setAffiliateId($this->getAffiliateId());
			$res = $this->db->query("select date_add('$date', INTERVAL $i DAY)");
			list($newdate) = $res->fetchRow();
			if($this->getAffiliateID())
			{
				$stats->getByAffiliateIdDate($this->getAffiliateId(), $newdate);
				$hits = $stats->getHits();
				$uniques = $stats->getUniques();
				$signups = $stats->getSignups();
				$income = $stats->getIncome();
				
			}
			else
			{
				$ret = $stats->getSumTotal($newdate, $newdate);
				
				$hits = $ret['hits'];
				$uniques = $ret['uniques'];
				$signups = $ret['signups'];
				$income = $ret['income'];
			}
			$return[$newdate]['hits'] = sprintf("%d", $hits);
			$return[$newdate]['uniques'] = sprintf("%d", $uniques);
			$return[$newdate]['signups'] = sprintf("%d", $signups);
			$return[$newdate]['income'] = sprintf("%.2f", $income);
			$return[$newdate]['ratio'] = $this->getRatio($uniques, $signups);
			
		}
		
		return $return;
	}
	/**
	* this function is for admin useage in order to display stats by affiliate
	*
	*@access public
	*@return mixed array
	*/
	function generateStatsByAffiliate()
	{
		$stats = new Stats($this->db);
		$stats_by_affiliate = $stats->getDateRangeByAffiliate($this->getBeginDate(), $this->getEndDate());
		
		// now get revenue
		$parts = explode('-',$this->getBeginDate() );
		$rev_beginDate	= $parts[0].$parts[1].$parts[2].'000000';
		$parts = explode('-',$this->getEndDate() );
		$rev_endDate	= $parts[0].$parts[1].$parts[2].'235959';
		$query = "SELECT affiliate_id,format(sum(amount),2) AS amount,format(sum(affiliate_payout),2) AS payout from Sale where datetime>=? and datetime<=? group by affiliate_id";
		$res = $this->db->query( $query, array($rev_beginDate,$rev_endDate ));
		while( $row = $res->fetchRow( DB_FETCHMODE_ASSOC )) {
			$id = $row['affiliate_id'];
			if( $id == '' )
				continue;
			if( @$stats_by_affiliate[$id] )
			{
				$stats_by_affiliate[$id]['amount'] = $row['amount'];
				$stats_by_affiliate[$id]['profit'] = $stats_by_affiliate[$id]['amount']-$stats_by_affiliate[$id]['income']-$stats_by_affiliate[$id]['referral_income'];
			} else {
				$stats_by_affiliate[$id]['amount'] = $row['amount'];
				$stats_by_affiliate[$id]['profit'] = $row['amount'];
				$stats_by_affiliate[$id]['income'] = 0;
				$stats_by_affiliate[$id]['referral_income'] = 0;
				$stats_by_affiliate[$id]['hits'] = 0;
				$stats_by_affiliate[$id]['uniques'] = 0;
				$stats_by_affiliate[$id]['signups'] = 0;
				$stats_by_affiliate[$id]['cancels'] = 0;
				$stats_by_affiliate[$id]['chargebacks'] = 0;
				$stats_by_affiliate[$id]['renewals'] = 0;
				ksort( $stats_by_affiliate );
			}
			
		}

		reset( $stats_by_affiliate );
		while( list( $id, $row ) = each( $stats_by_affiliate )) {
			if( @$stats_by_affiliate[$id]['amount'] == '' ) {
				$stats_by_affiliate[$id]['amount'] = 0;
			}
			if( @$stats_by_affiliate[$id]['profit'] == '' ) {
				$stats_by_affiliate[$id]['profit'] = 0;
			}
		}
		
		return $stats_by_affiliate;
	}
	/**
	* get hits, uniques, sales by referring url
	* this one is intensive
	*
	*@return mixed array
	*/
	function generateStatsByReferringUrl()
	{
		$return = array();
		$res = $this->db->query("select referring_url, uniq from Hit where affiliate_id=? and datetime >= ? and datetime<=?", array($this->getAffiliateId(), $this->getBeginDate(), $this->getEndDate()));
		if(DB::isError($res))
			print_r($res);
		while(list($refurl, $uniq) = $res->fetchRow())
		{
			if(!$refurl)
				$refurl = 'No Ref URL';
			$return[$refurl]['hits']++;
			if($uniq)
				$return[$refurl]['uniques']++;	
				
			$return[$refurl]['signups'] = 0;
			$return[$refurl]['ratio'] = "0:" . $return[$refurl]['uniques'];
		}

		$res = $this->db->query("select Hit.referring_url, Sale.id, Sale.affiliate_payout from Sale, Hit where Hit.id=Sale.hits_id and Sale.type='newsale' and Sale.affiliate_id=? and Sale.datetime >= ? and Sale.datetime<=?", array($this->getAffiliateId(), $this->getBeginDate(), $this->getEndDate()));	
		if(DB::isError($res))
			print_r($res);
		while(list($refurl, $id, $income) = $res->fetchRow())
		{
			if(!$refurl)
				$refurl = 'No Ref URL';
			$return[$refurl]['signups']++;
			$return[$refurl]['income']+=$income;
			$return[$refurl]['ratio']= $this->getRatio($return[$refurl]['uniques'], $return[$refurl]['signups']);
			
		}
		
		return $return;
		
	}
	/**
	* helper funciton to create a string of the ratio of signups to stats
	*
	*@access public
	*@param mixed int
	*@param mixed int
	*/
	function getRatio($hits,$sales)
	{
		$ratio = "0:0" ;
		if ($sales)
		{
			$ratio = $hits / $sales;
			$ratio = (int) $ratio;
			$ratio = "1:" . $ratio;
			
		}
		else if($hits)
		{
			$ratio = "0:" . $hits;
		}
		return $ratio;
	}
	
}

?>
