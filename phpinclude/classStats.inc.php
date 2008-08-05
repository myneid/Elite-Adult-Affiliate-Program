<?php

require_once 'PEAR.php';
require_once 'classAffiliateProgramDB.inc.php';
require_once('classHit.inc.php');
require_once('classScale.inc.php');
require_once('classSale.inc.php');
require_once 'classAPConfig.inc.php';

/**
 * The stats object is from the stats table, which is basically a summary
 * of the stats broken down by day, by affiliate. the stats object is also where you will
 * add new stats such as a new hit or a new signup
 *
 * long description of class
 *
 * @author Tanguy de Courson <tanguy@0x7a69.net>
 * @author Derek Volker <dvolker@0x7a69.net>
 * @version .9b
 * @access public
 * @package AffiliateProgram
*/
class Stats extends PEAR
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
	* description of date
	*@var date
	*/
	var $date;
	/**
	* description of hits
	*@var int
	*/
	var $hits;
	/**
	* description of uniques
	*@var int
	*/
	var $uniques;
	/**
	* description of signups
	*@var int
	*/
	var $signups;
	var $crosssales;
	var $second_hits;
	/**
	* description of cancels
	*@var int
	*/
	var $cancels;
	/**
	* description of chargebacks
	*@var int
	*/
	var $chargebacks;
	/**
	* description of renewals
	*@var int
	*/
	var $renewals;
	/**
	* description of scale_id
	*@var int
	*/
	var $scale_id;
	/**
	* affilaites income for this day
	*@var float
	*/
	var $income;
	/**
	* referral income for the day
	*@var float
	*/
	var $referral_income;
	/**
	* if this day was paid or not
	*@var bool
	*/
	var $paid;
	/**
	* the date that this affilaite id on this day was paid out
	*@var date
	*/
	var $payout_date;
	
	/**
	* set this variable if the sale is to be credited to a house
	* account regardless of hits data
	*/
	var $to_house = 0;
	

	
	/**
	* set this variable to force a scale_id through addSale()
	*/
	var $force_scale = 0;

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
	function Stats($db = false)
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
	function _Stats()
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
	* Acessor function to set the date variable
	*
	*@param mixed
	*@access public
	*/
	function setDate($date)
	{
		$this->_modified = true;
		$this->date = $date;
	}
	/**
	* Acessor function to set the hits variable
	*
	*@param mixed
	*@access public
	*/
	function setHits($hits)
	{
		$this->_modified = true;
		$this->hits = $hits;
	}
	function setSecondHits($hits)
	{
		$this->_modified = true;
		$this->second_hits = $hits;
	}
	/**
	* Acessor function to set the uniques variable
	*
	*@param mixed
	*@access public
	*/
	function setUniques($uniques)
	{
		if($uniques != $this->uniques)
		{
			$this->_modified = true;
			$this->uniques = $uniques;
		}
	}
	/**
	* Acessor function to set the signups variable
	*
	*@param mixed
	*@access public
	*/
	function setSignups($signups)
	{
		$this->_modified = true;
		$this->signups = $signups;
	}
	/**
	* Acessor function to set the crosssales variable
	*
	*@param mixed
	*@access public
	*/
	function setCrosssales($signups)
	{
		$this->_modified = true;
		$this->crosssales = $signups;
	}
	/**
	* Acessor function to set the cancels variable
	*
	*@param mixed
	*@access public
	*/
	function setCancels($cancels)
	{
		$this->_modified = true;
		$this->cancels = $cancels;
	}
	/**
	* Acessor function to set the chargebacks variable
	*
	*@param mixed
	*@access public
	*/
	function setChargebacks($chargebacks)
	{
		$this->_modified = true;
		$this->chargebacks = $chargebacks;
	}
	/**
	* Acessor function to set the renewals variable
	*
	*@param mixed
	*@access public
	*/
	function setRenewals($renewals)
	{
		$this->_modified = true;
		$this->renewals = $renewals;
	}
	/**
	* Acessor function to set the scale_id variable
	*
	*@param mixed
	*@access public
	*/
	function setScaleId($scale_id)
	{
		$this->_modified = true;
		$this->scale_id = $scale_id;
	}
	/**
	* Acessor function to set the income variable
	*
	*@param mixed
	*@access public
	*/
	function setIncome($income)
	{
		if($income != $this->income)
		{
			$this->_modified = true;
			$this->income = $income;
	
		}
	}
	/**
	* Acessor function to set the referral_income variable
	*
	*@param mixed
	*@access public
	*/
	function setReferralIncome($income)
	{
		if($income != $this->referral_income)
		{
			$this->_modified = true;
			$this->referral_income = $income;
	
		}
	}
	/**
	* Acessor function to set the payout_date variable
	*
	*@param mixed
	*@access public
	*/
	function setPayoutDate($payout_date)
	{
		if($payout_date != $this->payout_date)
		{
			$this->_modified = true;
			$this->payout_date = $payout_date;
	
		}
	}
	/**
	* Acessor function to set the paid variable
	*
	*@param mixed
	*@access public
	*/
	function setPaid($paid)
	{
		if($paid != $this->paid)
		{
			$this->_modified = true;
			$this->paid = $paid;
	
		}
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
	* Acessor function to get the date variable
	*
	*@access public
	*@return mixed
	*/
	function getDate()
	{
		return $this->date;
	}
	/**
	* Acessor function to get the hits variable
	*
	*@access public
	*@return mixed
	*/
	function getHits()
	{
		return $this->hits;
	}
	function getSecondHits()
	{
		return $this->second_hits;
	}
	/**
	* Acessor function to get the uniques variable
	*
	*@access public
	*@return mixed
	*/
	function getUniques()
	{
		return $this->uniques;
	}
	/**
	* Acessor function to get the signups variable
	*
	*@access public
	*@return mixed
	*/
	function getSignups()
	{
		return $this->signups;
	}
	/**
	* Acessor function to get the crosssales variable
	*
	*@access public
	*@return mixed
	*/
	function getCrosssales()
	{
		return $this->crosssales;
	}
	/**
	* Acessor function to get the cancels variable
	*
	*@access public
	*@return mixed
	*/
	function getCancels()
	{
		return $this->cancels;
	}
	/**
	* Acessor function to get the chargebacks variable
	*
	*@access public
	*@return mixed
	*/
	function getChargebacks()
	{
		return $this->chargebacks;
	}
	/**
	* Acessor function to get the renewals variable
	*
	*@access public
	*@return mixed
	*/
	function getRenewals()
	{
		return $this->renewals;
	}
	/**
	* Acessor function to get the scale_id variable
	*
	*@access public
	*@return mixed
	*/
	function getScaleId()
	{
		return $this->scale_id;
	}
	/**
	* Acessor function to get the income variable
	*
	*@access public
	*@return mixed
	*/
	function getIncome()
	{
		return $this->income;
	}
	/**
	* Acessor function to get the referral_income variable
	*
	*@access public
	*@return mixed
	*/
	function getReferralIncome()
	{
		return $this->referral_income;
	}
	/**
	* Acessor function to get the paid variable
	*
	*@access public
	*@return mixed
	*/
	function getPaid()
	{
		return $this->paid;
	}
	/**
	* Acessor function to get the payout_date variable
	*
	*@access public
	*@return mixed
	*/
	function getPayoutDate()
	{
		return $this->payout_date;
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
			$query = "update Stats set affiliate_id=?,date=?,hits=?,uniques=?,second_hits=?,signups=?,crosssales=?,cancels=?,chargebacks=?,renewals=?,scale_id=?,income=?,referral_income=?,paid=?,payout_date=? where id=?";
			$valueArray = array($this->getAffiliateId(),$this->getDate(),$this->getHits(),$this->getUniques(),$this->getSecondHits(),$this->getSignups(),$this->getCrosssales(),$this->getCancels(),$this->getChargebacks(),$this->getRenewals(),$this->getScaleId(),$this->getIncome(), $this->getReferralIncome(), $this->getPaid(),$this->getPayoutDate(), $this->getId());
		}
		else
		{
			//insert
			if($this->getId() == '')
				$this->setId($this->_generateNextId());

			$query = "insert into Stats (id,affiliate_id,date,hits,uniques,second_hits,signups,crosssales,cancels,chargebacks,renewals,scale_id,income,referral_income,paid,payout_date) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
			$valueArray = array($this->getId(),$this->getAffiliateId(),$this->getDate(),$this->getHits(),$this->getUniques(),$this->getSecondHits(),$this->getSignups(),$this->getCrosssales(),$this->getCancels(),$this->getChargebacks(),$this->getRenewals(),$this->getScaleId(),$this->getIncome(),$this->getReferralIncome(),$this->getPaid(),$this->getPayoutDate());
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

		$query = "select * from Stats where id=?";
		$sth = $this->db->prepare($query);
		$res = $this->db->execute($sth, array($id));

		$row = $res->fetchRow(DB_FETCHMODE_ASSOC);

		$this->setId($row['id']);
		$this->setAffiliateId($row['affiliate_id']);
		$this->setDate($row['date']);
		$this->setHits($row['hits']);
		$this->setUniques($row['uniques']);
		$this->setSecondHits($row['second_hits']);
		$this->setSignups($row['signups']);
		$this->setCrosssales($row['crosssales']);
		$this->setCancels($row['cancels']);
		$this->setChargebacks($row['chargebacks']);
		$this->setRenewals($row['renewals']);
		$this->setScaleId($row['scale_id']);
		$this->setIncome($row['income']);
		$this->setReferralIncome($row['referral_income']);
		$this->setPaid($row['paid']);
		$this->setPayoutDate($row['payout_date']);
		$this->_record_exists = true;
		$this->_modified = false;
	}
	/**
	this function will get the record by its affiliate id and date as taht is a key
	*
	*@access public
	*/
	function getByAffiliateIdDate($id = '', $date='')
	{
		if($id == '')
			$id = $this->getId();
		if(!$id) {
echo "getByAffiliateIDDate( $id , $date );\n";
return false;
//			trigger_error("you must set id to get by it", E_USER_ERROR);
		}
		if($date == '')
			$date = $this->getDate();
		if(!$date)
			trigger_error("you must set date to get by it", E_USER_ERROR);

		$query = "select * from Stats where affiliate_id=? and date=?";
		$sth = $this->db->prepare($query);
		$res = $this->db->execute($sth, array($id, $date));
		
		if($res->numRows() == 0)
			return false;

		$row = $res->fetchRow(DB_FETCHMODE_ASSOC);

		$this->setId($row['id']);
		$this->setAffiliateId($row['affiliate_id']);
		$this->setDate($row['date']);
		$this->setHits($row['hits']);
		$this->setUniques($row['uniques']);
		$this->setSecondHits($row['second_hits']);
		$this->setSignups($row['signups']);
		$this->setCrosssales($row['crosssales']);
		$this->setCancels($row['cancels']);
		$this->setChargebacks($row['chargebacks']);
		$this->setRenewals($row['renewals']);
		$this->setScaleId($row['scale_id']);
		$this->setIncome($row['income']);
		$this->setReferralIncome($row['referral_income']);
		$this->setPaid($row['paid']);
		$this->setPayoutDate($row['payout_date']);
		$this->_record_exists = true;
		$this->_modified = false;
		
		return true;
	}
	
	/*
	*this function will generate the next id
	*
	*@access private
	*/
	function _generateNextId()
	{
		return $this->db->nextId("Stats", true);
	}
	/**
	* this function will essentially add a hit, to this object and to the Hit table
	*it will return the value from the Hit table insert
	*
	*@access public
	*@param mixed unique bool
	*@return mixed int hits_id
	*/
	function addHit($unique, $type='first')
	{
		$res = $this->db->query("select id from Stats where affiliate_id=? and date=?", array($_REQUEST['aid'], date("Y-m-d")));
		list($id) = $res->fetchRow();
		$u = 0;
		if($unique)
			$u=1;
		if($id)
		{
			$unique_statement = '';
			if($unique)
				$unique_statement = ", uniques=uniques+1 ";
			if($type == 'second')
			$res = $this->db->query("update Stats set second_hits=second_hits+1 $unique_statement where id=?", array($id));				
			else
			$res = $this->db->query("update Stats set hits=hits+1 $unique_statement where id=?", array($id));	
		}	
		else
		{
			if($type == 'second')
			$res = $this->db->query("insert into Stats (affiliate_id, date, hits, uniques, second_hits,signups, cancels, chargebacks, renewals,income) values (?, now(), 1, $u, 0,0,0,0,0,0)", array($_REQUEST['aid']));	
			else
			$res = $this->db->query("insert into Stats (affiliate_id, date, hits, uniques, second_hits,signups, cancels, chargebacks, renewals,income) values (?, now(), 0, $u, 1,0,0,0,0,0)", array($_REQUEST['aid']));	
		}
		
		$hit =& new Hit($this->db);
		$hit->setAffiliateId($_REQUEST['aid']);
		$hit->setBrowser($_SERVER['HTTP_USER_AGENT']);
		$hit->setReferringUrl(@$_SERVER['HTTP_REFERER']);
		$hit->setDatetime(date("Y-m-d H:i:s"));
		$hit->setIpAddress($_SERVER['REMOTE_ADDR']);
		$hit->setSiteId($_REQUEST['sid']);
		$hit->setSubId(@$_REQUEST['sub_id']);
		@$program_id=$_REQUEST['program_id'];
		if(!$program_id)
			$program_id=1;
		$hit->setProgramId($program_id);
		$hit->setUnique($u);
		$hit->setHitType($type);
		$hit->save();
		
		return $hit->getId();
	}
	/**
	* this is the bulk of marking a sale donw
	* this will get the scale id, get the payout for this sale
	* update the Sale record for raw sales reporting
	* update the stats record for this day
	*
	*@access public
	*@return mixed int the sale id
	*/
	function addSale($mem_id)
	{
		//need the affiliate id from the Hit record
		$hit = new Hit($this->db);
		$hit->getById($_REQUEST['hitsid']);

		if( $this->to_house > 0 ) {
			$affiliate_id = $this->to_house;
		} else {
			$affiliate_id = $hit->getAffiliateId();
		}

		$config = new APConfig($this->db);
		$conf_vars = $config->get_all_vars();
		$period_interval = $conf_vars['period_interval'];

		if( $period_interval == 'BIMONTHLY' ) {
			$cur_month = date('m');
			$cur_day   = date('d');
			$cur_year  = date('Y');
			if( $cur_day > 15 ) {
				$start_day = 16;
				if( in_array( $cur_month, array(1,3,5,7,8,10,12)))
					$end_day = 31;
				elseif( in_array( $cur_month, array(4,6,9,11) ))
					$end_day = 30;
				else
				{
					if( $cur_year%4==0)
						$end_day=29;
					else
						$end_day=28;
				}
			} else {
				$start_day = '01';
				$end_day = 15;
			}
// cshepherd bugfix - date('m') doesn't need this
//			if( $cur_month < 10 )
//				$cur_month = '0'.$cur_month;

			$start_date = $cur_year.$cur_month.$start_day;
			$end_date = $cur_year.$cur_month.$end_day;
		}



		$res = $this->db->query("select sum(signups),sum(uniques) from Stats where affiliate_id=? and date>=? and date<=?", array($affiliate_id, $start_date, $end_date ));
		list($period_signups,$period_uniques) = $res->fetchRow();
					
		
		$res = $this->db->query("select id, signups, uniques from Stats where affiliate_id=? and date=?", array($affiliate_id,date('Ymd') ));
		list($id, $signups, $uniques) = $res->fetchRow();

		if(!$id)
		{
			$signups = 1;
			$uniques = 0;	
		}
		
		//we need to get the scale id to get the affiliate payout
		$scale = new Scale($this->db);
		
		if( $this->force_scale > 0 ) {
			$scale->getByID( $this->force_scale );
		} else {
			$scale->calculate($affiliate_id, $period_signups, $period_uniques, $hit->getProgramID());
		}

$fp=fopen('/tmp/scale.log','a');
fwrite($fp, "affiliate_id = $affiliate_id\n" );
fwrite($fp, "period_signups = $period_signups\n" );
fwrite($fp, "period_uniques = $period_uniques\n" );
fwrite($fp, "start_date = $start_date\n" );
fwrite($fp, "end_date = $end_date\n" );
fwrite($fp, "scale_id = ".$scale->id."\n" );
fwrite($fp, "--\n" );
fclose($fp );
		
		$sale =& new Sale($this->db);
		/*
		  datetime datetime,
  affiliate_id int,
  ipaddress varchar(15),
  amount float,
  type varchar(32),
  hits_id int,
  affiliate_payout float,
  scale_id int,
  processor_id tinyint,
  */
  		$sale->setAffiliateId($affiliate_id);
  		$sale->setIpaddress($_REQUEST['ipaddress']);
  		$sale->setAmount($_REQUEST['amount']);
  		$sale->setType('newsale');
  		$sale->setHitsId($_REQUEST['hitsid']);
  		$sale->setTransactionID($_REQUEST['transaction_id']);
  		$sale->setProcessorId(1);
  		$sale->setDatetime(date("Y-m-d H:i:s"));
  		$sale->setSiteId($hit->getSiteId());
  		$sale->setMemberId($mem_id);
  		$sale->setScaleId($scale->getId());
		$affpayout =0;
		if($scale->getPricepersignup() > 0 )
			$affpayout = $scale->getPricepersignup();
		else if($scale->getRevsharepercent() > 0)
			$affpayout = sprintf("%.2d", $_REQUEST['amount']*($scale->getRevsharepercent()/100));
  		$sale->setAffiliatePayout($affpayout);
  		$sale->setNotes($notes);
  		
		if($id)
		{
			$res = $this->db->query("update Stats set signups=signups+1,income=income+!,scale_id=! where id=?", array( $scale->getPricepersignup(), $scale->getId(), $id));	
			
				//print_r($this->db);
		}	
		else
		{
			$res = $this->db->query("insert into Stats (affiliate_id, date, hits, uniques, second_hits,signups, cancels, chargebacks, renewals, scale_id, income, referral_income) values (?, now(), 0, 0,0, 1,0,0,0,?,?,0)", array($affiliate_id, $scale->getId(), $scale->getPricepersignup()));	

		}
		$sale->save();
		
		
		
		return $sale->getId();
			
	}
	/**
	* this is the same as addSale but will not check the hit id
	* instead the information is passed in
	*
	*@see Sale()
	*@access public
	*@param mixed int the affiliate id
	*@param mixed int the transaction id
	*@param mixed date
	*@param mixed time
	*@param mixed amount
	*@return mixed int the sale id
	*/
	function addSaleNoHit($affiliate_id, $mem_id, $siteid, $date, $time, $amount, $sale_type = 'newsale')
	{
		$notes = $affiliate_id;

		//need the affiliate id from the Hit record
		$res = $this->db->query("select id, signups, crosssales, uniques from Stats where affiliate_id=? and date=?", array($affiliate_id, $date));
		list($id, $signups, $crosssales, $uniques) = $res->fetchRow();

		if(!$id)
		{
			$signups = 0;
			($sale_type == 'newsale' ? $signups = 1 : $crosssales=1);
			$uniques = 0;	
		}
		
		//we need to get the scale id to get the affiliate payout
		$scale = new Scale($this->db);
		if( $this->force_scale > 0 ) {
			$scale->getByID( $this->force_scale );
		} else {
			$scale->calculate($affiliate_id, ($sale_type == 'newsale' ? $signups : $crosssales), $uniques, 1);
		}
		
		$sale =& new Sale($this->db);
		/*
		  datetime datetime,
  affiliate_id int,
  ipaddress varchar(15),
  amount float,
  type varchar(32),
  hits_id int,
  affiliate_payout float,
  scale_id int,
  processor_id tinyint,
  */
  		$sale->setAffiliateId($affiliate_id);
  		$sale->setIpaddress('127.0.0.1');
  		$sale->setAmount($amount);
  		$sale->setType($sale_type);
  		$sale->setHitsId(0);
  		$sale->setTransactionID($vars['order_id']);
  		$sale->setProcessorId(1);
  		$sale->setDatetime("$date $time");
  		$sale->setSiteId($siteid);
  		$sale->setNotes($notes);
  		$sale->setMemberId($mem_id);
  		
  		$sale->setScaleId($scale->getId());
  		$sale->setAffiliatePayout($scale->getPricepersignup());
  		
  		
  		
  		
  		
		if($id)
		{
			if($sale_type == 'newsale')
				$res = $this->db->query("update Stats set signups=signups+1,income=income+!,scale_id=! where id=?", array( $scale->getPricepersignup(), $scale->getId(), $id));	
			else
				$res = $this->db->query("update Stats set crosssales=crosssales+1,income=income+!,scale_id=! where id=?", array( $scale->getPricepersignup(), $scale->getId(), $id));	
			
				print_r($this->db);
		}	
		else
		{
			if($sale_type == 'newsale')
				$res = $this->db->query("insert into Stats (affiliate_id, date, hits, uniques,second_hits signups, crosssales, cancels, chargebacks, renewals, scale_id, income, referral_income) values (?, now(), 0, 0, 0,1,0,0,0,0,?,?,0)", array($affiliate_id, $scale->getId(), $scale->getPricepersignup()));	
			else
				$res = $this->db->query("insert into Stats (affiliate_id, date, hits, uniques, second_his,signups, crosssales, cancels, chargebacks, renewals, scale_id, income, referral_income) values (?, now(), 0, 0, 0,0,1,0,0,0,?,?,0)", array($affiliate_id, $scale->getId(), $scale->getPricepersignup()));	

		}
		$sale->save();
		return $sale->getId();
			
	}
	/**
	* this function does not resemble a single stats object
	* but will encompass a date range of objects for a sum total
	* it will return an assoc array
	*
	*@access public
	*@param mixed date
	*@param mixed date
	*@param mixed id affiliate id optional
	*@return mixed array
	*/
	function getSumTotal($start_date, $end_date, $affiliate_id='')
	{
		$valueArray = array();
		$query = "select sum(hits) as hits, sum(uniques) as uniques, sum(second_hits) as second_hits, sum(signups) as signups, sum(crosssales) as crosssales, sum(cancels) as cancels, sum(chargebacks) as chargebacks, sum(renewals) as renewals, sum(income) as income, sum(referral_income) as referral_income from Stats where ";
		if($affiliate_id)
		{
			$query .= " affiliate_id=? and ";
			array_push($valueArray, $affiliate_id);
		}
		$query .= " date >= ? and date <= ?";
		array_push($valueArray, $start_date);
		array_push($valueArray, $end_date);
		
		$res = $this->db->query($query, $valueArray);
		if(DB::isError($res))
			print_r($res);
		return $res->fetchRow(DB_FETCHMODE_ASSOC);
	}
	/**
	* this function should return an array where the key is affiliate id
	* the value should be an array of hits, uniques, signups, cancels, chargebacks, renewals, income
	*
	*@access public
	*@param mixed date
	*@param mixed date
	*@return mixed array
	*/
	function getDateRangeByAffiliate($start_date, $end_date)
	{
		$return = array();
		$valueArray = array();
		$query = "select affiliate_id, sum(hits) as hits, sum(uniques) as uniques, sum(second_hits) as second_hits, sum(signups) as signups, sum(crosssales) as crosssales, sum(cancels) as cancels, sum(chargebacks) as chargebacks, sum(renewals) as renewals, sum(income) as income, sum(referral_income) as referral_income from Stats where ";
		$query .= " date >= ? and date <= ? group by affiliate_id";
		array_push($valueArray, $start_date . " 0:0:0");
		array_push($valueArray, $end_date . " 23:59:59");
		
		
		$res = $this->db->query($query, $valueArray);
		if(DB::isError($res))
			print_r($res);
			
		while($row = $res->fetchRow(DB_FETCHMODE_ASSOC))
		{
			if( $row['affiliate_id'] == '' )
				$row['affiliate_id'] = 'none';
			$return[$row['affiliate_id']] = $row;
		}
		return $return;
	}	
	/**
	* this function will generate all of the payouts ending on this->getEndDate
	* the return will be an array where the key is affiliate id and the value is the payout
	*
	*@return mixed array
	*/
	function getAllPayouts($end_date)
	{
		$return = array();
		$res = $this->db->query("select affiliate_id, sum(income), sum(referral_income) from Stats where (paid <> 1 or paid is null) and date <=? group by affiliate_id", array($end_date));
		
		while(list($aid, $inc, $ref) = $res->fetchRow())
		{
			$return[$aid] = ($inc + $ref);	
		}
		return $return;
	}
	
	function getPayoutDetail($affiliate_id,$end_date)
	{
		$return = array();
		$res = $this->db->query("select date,signups,crosssales, uniques,hits,scale_id,income,referral_income from Stats where affiliate_id=? and date<=? and (paid<>1 or paid is null)", array( $affiliate_id, $end_date ));
		while( $detail = $res->fetchRow(DB_FETCHMODE_ASSOC) )
		{
			$return[] = $detail;
		}
		
		return $return;
	}
	/**
	* add a cancellation to this record
	*
	*/
	function addCancel()
	{
		if($this->_record_exists)
		{
			$this->setCancels($this->getCancels()+1);
		}
		else 
		{
			$res = $this->db->query("insert into Stats (affiliate_id, date, hits, uniques, second_hits, signups, crosssales, cancels, chargebacks, renewals, scale_id, income, referral_income) values (?, now(), 0, 0, 0,0,0,1,0,0,0,0,0)", array($this->getAffiliateId()));
		}
	}
	/**
	* add a chargeback to this record
	*
	*/
	function addChargeback()
	{
		if($this->_record_exists)
		{
			$this->setChargebacks($this->getChargebacks()+1);
		}
		else 
		{
			$res = $this->db->query("insert into Stats (affiliate_id, date, hits, uniques, second_hits, signups,crosssales, cancels, chargebacks, renewals, scale_id, income, referral_income) values (?, now(), 0,0, 0, 0,0,0,1,0,0,0,0)", array($this->getAffiliateId()));
		}
	}
	/**
	* add a renewal to this record
	*
	*/
	function addRenewal()
	{
		if($this->_record_exists)
		{
			$this->setRenewals($this->getRenewals()+1);
		}
		else 
		{
			$res = $this->db->query("insert into Stats (affiliate_id, date, hits, uniques, second_hits, signups, crosssales, cancels, chargebacks, renewals, scale_id, income, referral_income) values (?, now(), 0, 0, 0,0,0,0,0,1,0,0,0)", array($this->getAffiliateId()));
		}
	}
}


