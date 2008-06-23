<?php

require_once 'PEAR.php';
require_once 'classAffiliateProgramDB.inc.php';
/**
 * this will contain one sale object.
 *
 * long description of class
 *
 * @author Tanguy de Courson <tanguy@0x7a69.net>
 * @author Derek Volker <dvolker@0x7a69.net>
 * @version .9b
 * @access public
 * @package AffiliateProgram
*/
class Sale extends PEAR
{
	/**
	* description of id
	*@var int
	*/
	var $id;
	/**
	* description of datetime
	*@var datetime
	*/
	var $datetime;
	/**
	* description of affiliate_id
	*@var int
	*/
	var $affiliate_id;
	/**
	* description of type
	*@var string
	*/
	var $type;
	/**
	* description of ipaddress
	*@var string
	*/
	var $ipaddress;
	/**
	* description of amount
	*@var float
	*/
	var $amount;
	/**
	* description of hits_id
	*@var int
	*/
	var $hits_id;
	/**
	* description of affiliate_payout
	*@var float
	*/
	var $affiliate_payout;
	/**
	* description of scale_id
	*@var int
	*/
	var $scale_id;
	/**
	* description of processor_id
	*@var int
	*/
	var $processor_id;
	/**
	* description of site_id
	*@var int
	*/
	var $site_id;
	/**
	* description of transaction_id
	*@var int
	*/
	var $transaction_id;
	var $member_id;
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
	var $notes;
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
	function Sale($db = false)
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
	function _Sale()
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
	* Acessor function to set the datetime variable
	*
	*@param mixed
	*@access public
	*/
	function setDatetime($datetime)
	{
		$this->_modified = true;
		$this->datetime = $datetime;
	}
	/**
	* Acessor function to set the affiliate_id variable
	*
	*@param mixed
	*@access public
	*/
	function setNotes($notes)
	{
		$this->_modified = true;
		$this->notes = $notes;
	}
	function setAffiliateId($affiliate_id)
	{
		$this->_modified = true;
		$this->affiliate_id = $affiliate_id;
	}
	/**
	* Acessor function to set the type variable
	*
	*@param mixed
	*@access public
	*/
	function setType($type)
	{
		$this->_modified = true;
		$this->type = $type;
	}
	/**
	* Acessor function to set the ipaddress variable
	*
	*@param mixed
	*@access public
	*/
	function setIpaddress($ipaddress)
	{
		$this->_modified = true;
		$this->ipaddress = $ipaddress;
	}
	/**
	* Acessor function to set the amount variable
	*
	*@param mixed
	*@access public
	*/
	function setAmount($amount)
	{
		$this->_modified = true;
		$this->amount = $amount;
	}
	/**
	* Acessor function to set the hits_id variable
	*
	*@param mixed
	*@access public
	*/
	function setHitsID($hits_id)
	{
		$this->_modified = true;
		$this->hits_id = $hits_id;
	}
	/**
	* Acessor function to set the amount variable
	*
	*@param mixed
	*@access public
	*/
	function setAffiliatePayout($affiliate_payout)
	{
		$this->_modified = true;
		$this->affiliate_payout = $affiliate_payout;
	}
	/**
	* Acessor function to set the scale_id variable
	*
	*@param mixed
	*@access public
	*/
	function setScaleID($scale_id)
	{
		$this->_modified = true;
		$this->scale_id = $scale_id;
	}
	/**
	* Acessor function to set the processor_id variable
	*
	*@param mixed
	*@access public
	*/
	function setProcessorId($processor_id)
	{
		$this->_modified = true;
		$this->processor_id = $processor_id;
	}
	/**
	* Acessor function to set the site_id variable
	*
	*@param mixed
	*@access public
	*/
	function setSiteId($site_id)
	{
		$this->_modified = true;
		$this->site_id = $site_id;
	}
	/**
	* Acessor function to set the transaction_id variable
	*
	*@param mixed
	*@access public
	*/
	function setTransactionID($transaction_id)
	{
		$this->_modified = true;
		$this->transaction_id = $transaction_id;
	}
	/**
	* Acessor function to set the member_id variable
	*
	*@param mixed
	*@access public
	*/
	function setMemberId($member_id)
	{
		$this->_modified = true;
		$this->member_id = $member_id;
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
	* Acessor function to get the datetime variable
	*
	*@access public
	*@return mixed
	*/
	function getDatetime()
	{
		return $this->datetime;
	}
	/**
	* Acessor function to get the affiliate_id variable
	*
	*@access public
	*@return mixed
	*/
	function getNotes()
	{
		return $this->notes;
	}
	function getAffiliateId()
	{
		return $this->affiliate_id;
	}
	/**
	* Acessor function to get the type variable
	*
	*@access public
	*@return mixed
	*/
	function getType()
	{
		return $this->type;
	}
	/**
	* Acessor function to get the ipaddress variable
	*
	*@access public
	*@return mixed
	*/
	function getIpaddress()
	{
		return $this->ipaddress;
	}
	/**
	* Acessor function to get the amount variable
	*
	*@access public
	*@return mixed
	*/
	function getAmount()
	{
		return $this->amount;
	}
	/**
	* Acessor function to get the hits_id variable
	*
	*@access public
	*@return mixed
	*/
	function getHitsId()
	{
		return $this->hits_id;
	}
	/**
	* Acessor function to get the affiliate_payout variable
	*
	*@access public
	*@return mixed
	*/
	function getAffiliatePayout()
	{
		return $this->affiliate_payout;
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
	* Acessor function to get the processor di variable
	*
	*@access public
	*@return mixed
	*/
	function getProcessorID()
	{
		return $this->processor_id;
	}
	/**
	* Acessor function to get the site_id variable
	*
	*@access public
	*@return mixed
	*/
	function getSiteId()
	{
		return $this->site_id;
	}
	/**
	* Acessor function to get the transaction_id variable
	*
	*@access public
	*@return mixed
	*/
	function getTransactionID()
	{
		return $this->transaction_id;
	}
	/**
	* Acessor function to get the member_id variable
	*
	*@access public
	*@return mixed
	*/
	function getMemberId()
	{
		return $this->member_id;
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
			$query = "update Sale set datetime=?,affiliate_id=?,notes=?,type=?,ipaddress=?,amount=?,hits_id=?,affiliate_payout=?,scale_id=?,processor_id=?,site_id=?,transaction_id=?,member_id=? where id=?";
			$valueArray = array($this->getDatetime(),$this->getAffiliateId(),$this->getNotes(),$this->getType(),$this->getIpaddress(),$this->getAmount(),$this->getHitsId(), $this->getAffiliatePayout(), $this->getScaleId(), $this->getProcessorID(), $this->getSiteId(),$this->getTransactionID(),$this->getMemberId(), $this->getId());
		}
		else
		{
			//insert
			if($this->getId() == '')
				$this->setId($this->_generateNextId());

			$query = "insert into Sale (id,datetime,affiliate_id,notes,type,ipaddress,amount,hits_id,affiliate_payout,scale_id,processor_id,site_id,transaction_id,member_id) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
			$valueArray = array($this->getId(),$this->getDatetime(),$this->getAffiliateId(),$this->getNotes(),$this->getType(),$this->getIpaddress(),$this->getAmount(),$this->getHitsId(), $this->getAffiliatePayout(), $this->getScaleId(), $this->getProcessorID(), $this->getSiteId(),$this->getTransactionID(),$this->getMemberId());
		}
		$sth = $this->db->prepare($query);
		$res = $this->db->execute($sth, $valueArray);
		if(DB::isError($res))
		{
			print_r($res);
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

		$query = "select * from Sale where id=?";
		$sth = $this->db->prepare($query);
		$res = $this->db->execute($sth, array($id));

		$row = $res->fetchRow(DB_FETCHMODE_ASSOC);

		$this->setId($row['id']);
		$this->setDatetime($row['datetime']);
		$this->setAffiliateId($row['affiliate_id']);
		$this->setNotes($row['notes']);
		$this->setType($row['type']);
		$this->setIpaddress($row['ipaddress']);
		$this->setAmount($row['amount']);
		$this->setHitsid($row['hits_id']);
		$this->setAffiliatePayout($row['affiliate_payout']);
		$this->setScaleId($row['scale_id']);
		$this->setProcessorID($row['processor_id']);
		$this->setSiteId($row['site_id']);
		$this->setTransactionID($row['transaction']);
		$this->setMemberId($row['member_id']);
		$this->_record_exists = true;
		$this->_modified = false;
	}
	/**
	this function will get the record by its order id
	*
	*@access public
	*/
	function getByTransactionId($id = '')
	{
		if($id == '')
			$id = $this->getId();
		if(!$id)
			trigger_error("you must set id to get by it", E_USER_ERROR);

		$query = "select * from Sale where transaction_id=?";
		$sth = $this->db->prepare($query);
		$res = $this->db->execute($sth, array($id));

		$row = $res->fetchRow(DB_FETCHMODE_ASSOC);

		$this->setId($row['id']);
		$this->setDatetime($row['datetime']);
		$this->setAffiliateId($row['affiliate_id']);
		$this->setNotes($row['notes']);
		$this->setType($row['type']);
		$this->setIpaddress($row['ipaddress']);
		$this->setAmount($row['amount']);
		$this->setHitsid($row['hits_id']);
		$this->setAffiliatePayout($row['affiliate_payout']);
		$this->setScaleId($row['scale_id']);
		$this->setProcessorID($row['processor_id']);
		$this->setSiteId($row['site_id']);
		$this->setTransactionID($row['transaction']);
		$this->setMemberId($row['member_id']);
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
		return $this->db->nextId("Sale", true);
	}
	/**
	* ok, well i made a call to this function but dont remember
	* exactly what it should do
	* it seems that it will return an array
	* where the key is the site id
	* and the value is an array where the key is 'sales', 'income' and the values are the corresponding values
	*
	*@access public
	*@param mixed date
	*@param mixed date
	*@param mixed int
	*@return mixed array
	*/
	function getTotalBySite($begin_date, $end_date, $affiliate_id='')
	{
		$query = "select site_id, count(*), sum(affiliate_payout) from Sale where type='newsale' and datetime >= ? and datetime <=?";
		$valueArray = array("$begin_date 0:0:0", "$end_date 23:59:59");
		if($affiliate_id)
		{
			$query .= " and affiliate_id=?";
			array_push($valueArray, $affiliate_id);
		}
		$res = $this->db->query("$query group by site_id", $valueArray);
		if(DB::isError($res))
			print_r($res);
		$return = array();
		while(list($siteid, $signups, $income) = $res->fetchRow())
		{
			$return[$siteid]['sales'] = $signups;
			$return[$siteid]['income'] = $income;
		}
		return $return;
	}

	/**
	*@access public
	*@param mixed date
	*@param mixed date
	*@param mixed int
	*@return mixed array
	*/
	function getSiteTotalByAff($begin_date, $end_date)
	{
		$query = "select site_id,affiliate_id,count(*), sum(affiliate_payout) from Sale where type='newsale' and datetime >= ? and datetime <=?";
		$valueArray = array("$begin_date 0:0:0", "$end_date 23:59:59");
		$res = $this->db->query("$query group by site_id,affiliate_id", $valueArray);
		if(DB::isError($res))
			print_r($res);
		$return = array();
		while(list($siteid, $aff_id, $signups, $income) = $res->fetchRow())
		{
			$return[$siteid][$aff_id]['sales'] = $signups;
			$return[$siteid][$aff_id]['income'] = $income;
		}
		return $return;
	}
	/**
	* calls teh descructor
	* for if you cant wait for the object to destroy
	*
	*@access public
	*/
	function save()
	{
		if($this->_modified)
			$this->_update();
	}
	
	
}

?>
