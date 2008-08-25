<?php

require_once 'PEAR.php';
require_once 'classAffiliateProgramDB.inc.php';
/**
 * this object will contain one hit from the database as each specific hit is tracked
 *
 * long description of class
 *
 * @author Tanguy de Courson <tanguy@0x7a69.net>
 * @author Derek Volker <dvolker@0x7a69.net>
 * @version .9b
 * @access public
 * @package AffiliateProgram
*/
class Hit extends PEAR
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
	* hit_type is something for you to set. could be firstclicks, secondclicks
	*@var string
	*/
	var $hit_type;
	/**
	* description of ipaddress
	*@var string
	*/
	var $ipaddress;
	/**
	* description of browser
	*@var string
	*/
	var $browser_id;
	/**
	* referring url
	*@var string
	*/
	var $referringurl_id;
	/**
	* unique, bool value
	*@var bool
	*/
	var $unique;
	/**
	* site id
	*@var int
	*/
	var $site_id;
	/**
	* program_id
	*@var int
	*/
	var $program_id;
	/**
	 * sub_id
	 * @var string
	 */
	var $sub_id;

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
	function Hit($db = false)
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
	function _Hit()
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
	function setDateTime($datetime)
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
	function setAffiliateId($affiliate_id)
	{
		$this->_modified = true;
		$this->affiliate_id = $affiliate_id;
	}
	/**
	* Acessor function to set the hit_type variable
	*
	*@param mixed
	*@access public
	*/
	function setHitType($hit_type)
	{
		$this->_modified = true;
		$this->hit_type = $hit_type;
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
	* Acessor function to set the browser variable
	*
	*@param mixed
	*@access public
	*/
	function setBrowser_id($browser)
	{
		$this->_modified = true;
		$this->browser_id = $browser;
	}
	/**
	* Acessor function to set the referring_url variable
	*
	*@param mixed
	*@access public
	*/
	function setReferringUrl_id($referring_url)
	{
		if($referring_url != $this->referring_url)
		{
			$this->_modified = true;
			$this->referringurl_id = $referring_url;
	
		}
	}
	/**
	* Acessor function to set the referring_url variable
	*
	*@param mixed
	*@access public
	*/
	function setUnique($unique)
	{
		if($unique != $this->unique)
		{
			$this->_modified = true;
			$this->unique = $unique;
	
		}
	}
	/**
	* Acessor function to set the site id variable
	*
	*@param mixed
	*@access public
	*/
	function setSiteId($site_id)
	{
		if($site_id != $this->site_id)
		{
			$this->_modified = true;
			$this->site_id = $site_id;
	
		}
	}
	/**
	* Acessor function to set the program_id variable
	*
	*@param mixed
	*@access public
	*/
	function setProgramId($program_id)
	{
		if($program_id != $this->program_id)
		{
			$this->_modified = true;
			$this->program_id = $program_id;
	
		}
	}
	/**
	* Acessor function to set the sub_id variable
	*
	*@param mixed
	*@access public
	*/
	function setSubId($sub_id)
	{
		if($sub_id != $this->sub_id)
		{
			$this->_modified = true;
			$this->sub_id = $sub_id;
	
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
	* Acessor function to get the datetime variable
	*
	*@access public
	*@return mixed
	*/
	function getDateTime()
	{
		return $this->datetime;
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
	* Acessor function to get the hit_type variable
	*
	*@access public
	*@return mixed
	*/
	function getHitType()
	{
		return $this->hit_type;
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
	* Acessor function to get the browser variable
	*
	*@access public
	*@return mixed
	*/
	function getBrowser_id()
	{
		return $this->browser_id;
	}
	/**
	* Acessor function to get the referring_url variable
	*
	*@access public
	*@return mixed
	*/
	function getReferringURL_id()
	{
		return $this->referringurl_id;
	}
	/**
	* Acessor function to get the unique variable
	*
	*@access public
	*@return mixed
	*/
	function getUnique()
	{
		return $this->unique;
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
	* Acessor function to get the program_id variable
	*
	*@access public
	*@return mixed
	*/
	function getProgramID()
	{
		return $this->program_id;
	}
	/**
	* Acessor function to get the sub_id variable
	*
	*@access public
	*@return mixed
	*/
	function getSubId()
	{
		return $this->sub_id;
	}
	/**
	*this function will update or insert into the database as needed
	*
	*@access private
	*/
	function _update()
	{
		//in the table the field uniq is actually unique. you cannot name a field unique though
		$query = '';
		$valueArray = array();
		if($this->_record_exists)
		{
			//update
			$query = "update Hit set datetime=?,affiliate_id=?,hit_type=?,ipaddress=?,browser_id=?,referringurl_id=?,site_id=?,uniq=?,program_id=?,sub_id=? where id=?";
			$valueArray = array($this->getDateTime(),$this->getAffiliateId(),$this->getHitType(),$this->getIpaddress(),$this->getBrowser_id(),$this->getReferringURL_id(),$this->getSiteId(),$this->getUnique(),$this->getProgramID(), $this->getSubid(), $this->getId());
		}
		else
		{
			//insert
			if($this->getId() == '')
				$this->setId($this->_generateNextId());

			$query = "insert into Hit (id,datetime,affiliate_id,hit_type,ipaddress,browser_id,referringurl_id,site_id,uniq,program_id, sub_id) values (?,?,?,?,?,?,?,?,?,?,?)";
			$valueArray = array($this->getId(),$this->getDateTime(),$this->getAffiliateId(),$this->getHitType(),$this->getIpaddress(),$this->getBrowser_id(),$this->getReferringURL_id(),$this->getSiteId(),$this->getUnique(),$this->getProgramID(),$this->getSubId());
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
	*this function will get the record by its id
	*
	*@access public
	*/
	function getById($id = '')
	{
		if($id == '')
			$id = $this->getId();
		if(!$id)
			trigger_error("you must set id to get by it", E_USER_ERROR);

		$query = "select * from Hit where id=?";
		$sth = $this->db->prepare($query);
		$res = $this->db->execute($sth, array($id));

		$row = $res->fetchRow(DB_FETCHMODE_ASSOC);

		$this->setId($row['id']);
		$this->setDateTime($row['datetime']);
		$this->setAffiliateId($row['affiliate_id']);
		$this->setHitType($row['hit_type']);
		$this->setIpaddress($row['ipaddress']);
		$this->setBrowser_id($row['browser_id']);
		$this->setReferringUrl_id($row['referringurl_id']);
		$this->setSiteId($row['site_id']);
		$this->setUnique($row['uniq']);
		$this->setProgramId($row['program_id']);
		$this->setSubId($row['sub_id']);
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
		return $this->db->nextId("Hit", true);
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
	/**
	* ok, well i made a call to this function but dont remember
	* exactly what it should do
	* it seems that it will return an array
	* where the key is the site id
	* and the value is an array where the key is 'hits', 'uniques' and the values are the corresponding values
	*
	*@access public
	*@param mixed date
	*@param mixed date
	*@param mixed int
	*@return mixed array
	*/
	function getTotalBySite($begin_date, $end_date, $affiliate_id='')
	{
		$query = "select site_id, hit_type, count(*) from Hit where datetime >= ? and datetime <= ?";
		$valueArray = array("$begin_date 0:0:0", "$end_date 23:59:59");
		if($affiliate_id)
		{
			$query .= " and affiliate_id=?";
			array_push($valueArray, $affiliate_id);
		}
		
		
		
		$res = $this->db->query("$query group by site_id, hit_type", $valueArray);
		if(DB::isError($res))
			print_r($res);
		$return = array();
		while(list($siteid, $type, $count) = $res->fetchRow())
		{
			if($type == 'second')
			$return[$siteid]['second_hits'] = $count;
			else
			$return[$siteid]['hits'] = $count;
		}
		$res = $this->db->query("$query and uniq=1 group by site_id", $valueArray);
		
		while(list($siteid, $count) = $res->fetchRow())
		{
			$return[$siteid]['uniques'] = $count;
		}
		
		return $return;
	}

	/**
	* same as before, for all affiliates and sites
	*@access public
	*@param mixed date
	*@param mixed date
	*@param mixed int
	*@return mixed array
	*/
	function getSiteTotalByAff($begin_date, $end_date)
	{
		$query = "select site_id, affiliate_id, count(*) from Hit where datetime >= ? and datetime <= ?";
		$valueArray = array("$begin_date 0:0:0", "$end_date 23:59:59");
		
		$res = $this->db->query("$query group by site_id,affiliate_id", $valueArray);
		if(DB::isError($res))
			print_r($res);
		$return = array();
		while(list($siteid, $aff_id, $count) = $res->fetchRow())
		{
			$return[$siteid][$aff_id]['hits'] = $count;
		}
		$res = $this->db->query("$query and uniq=1 group by site_id,affiliate_id", $valueArray);
		
		while(list($siteid, $aff_id, $count) = $res->fetchRow())
		{
			$return[$siteid][$aff_id]['uniques'] = $count;
		}
		
		return $return;
	}
}


