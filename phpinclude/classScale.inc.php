<?php

require_once 'PEAR.php';
require_once 'classAffiliateProgramDB.inc.php';
/**
 * this object is the payout scales. technically this object is one scale but can call up a whole list of the proper scale.
 *
 * long description of class
 *
 * @author Tanguy de Courson <tanguy@0x7a69.net>
 * @author Derek Volker <dvolker@0x7a69.net>
 * @version .9b
 * @access public
 * @package AffiliateProgram
*/
class Scale extends PEAR
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
	* program_id
	*@var int
	*/
	var $program_id;
	/**
	* description of percentage
	*@var int
	*/
	var $percentage;
	/**
	* max signups for scale
	*@var int
	*/
	var $signups;
	/**
	* revshare percent
	*@var int
	*/
	var $revsharepercent;
	/**
	* description of priceperhit
	*@var float
	*/
	var $priceperhit;
	/**
	* description of pricepersignup
	*@var float
	*/
	var $pricepersignup;
	/**
	* description of pricereducedpercancel
	*@var float
	*/
	var $pricereducedpercancel;
	/**
	* description of pricereducedperchargeback
	*@var float
	*/
	var $pricereducedperchargeback;

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
	function Scale($db = false)
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
	function _Scale()
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
		if($affiliate_id != $this->affiliate_id)
		{
			$this->_modified = true;
			$this->affiliate_id = $affiliate_id;
	
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
	* Acessor function to set the percentage variable
	*
	*@param mixed
	*@access public
	*/
	function setPercentage($percentage)
	{
		if($percentage != $this->percentage)
		{
			$this->_modified = true;
			$this->percentage = $percentage;
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
		if($signups != $this->signups)
		{
			$this->_modified = true;
			$this->signups = $signups;
		}
	}
	/**
	* Acessor function to set the revsharepercent variable
	*
	*@param mixed
	*@access public
	*/
	function setRevsharepercent($revsharepercent)
	{
		if($revsharepercent != $this->revsharepercent)
		{
			$this->_modified = true;
			$this->revsharepercent = $revsharepercent;
		}
	}
	/**
	* Acessor function to set the priceperhit variable
	*
	*@param mixed
	*@access public
	*/
	function setPriceperhit($priceperhit)
	{
		if($priceperhit != $this->priceperhit)
		{
			$this->_modified = true;
			$this->priceperhit = $priceperhit;
		}
	}
	/**
	* Acessor function to set the pricepersignup variable
	*
	*@param mixed
	*@access public
	*/
	function setPricepersignup($pricepersignup)
	{
		if($pricepersignup != $this->pricepersignup)
		{
			$this->_modified = true;
			$this->pricepersignup = $pricepersignup;
		}
	}
	/**
	* Acessor function to set the pricereducedpercancel variable
	*
	*@param mixed
	*@access public
	*/
	function setPricereducedpercancel($pricereducedpercancel)
	{
		if($pricereducedpercancel != $this->pricereducedpercancel)
		{
			$this->_modified = true;
			$this->pricereducedpercancel = $pricereducedpercancel;
		}
	}
	/**
	* Acessor function to set the pricereducedperchargeback variable
	*
	*@param mixed
	*@access public
	*/
	function setPricereducedperchargeback($pricereducedperchargeback)
	{
		if($pricereducedperchargeback != $this->pricereducedperchargeback)
		{
			$this->_modified = true;
			$this->pricereducedperchargeback = $pricereducedperchargeback;
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
	* Acessor function to get the program_id variable
	*
	*@access public
	*@return mixed
	*/
	function getProgramId()
	{
		return $this->program_id;
	}
	/**
	* Acessor function to get the percentage variable
	*
	*@access public
	*@return mixed
	*/
	function getPercentage()
	{
		return $this->percentage;
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
	* Acessor function to get the revsharepercent variable
	*
	*@access public
	*@return mixed
	*/
	function getRevsharepercent()
	{
		return $this->revsharepercent;
	}
	/**
	* Acessor function to get the priceperhit variable
	*
	*@access public
	*@return mixed
	*/
	function getPriceperhit()
	{
		return $this->priceperhit;
	}
	/**
	* Acessor function to get the pricepersignup variable
	*
	*@access public
	*@return mixed
	*/
	function getPricepersignup()
	{
		return $this->pricepersignup;
	}
	/**
	* Acessor function to get the pricereducedpercancel variable
	*
	*@access public
	*@return mixed
	*/
	function getPricereducedpercancel()
	{
		return $this->pricereducedpercancel;
	}
	/**
	* Acessor function to get the pricereducedperchargeback variable
	*
	*@access public
	*@return mixed
	*/
	function getPricereducedperchargeback()
	{
		return $this->pricereducedperchargeback;
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
			$query = "update Scale set affiliate_id=?,program_id=?,percentage=?,signups=?,revsharepercent=?,priceperhit=?,pricepersignup=?,pricereducedpercancel=?,pricereducedperchargeback=? where id=?";
			$valueArray = array($this->getAffiliateId(),$this->getProgramId(), $this->getPercentage(),$this->getSignups(),$this->getRevsharepercent(),$this->getPriceperhit(),$this->getPricepersignup(),$this->getPricereducedpercancel(),$this->getPricereducedperchargeback(),$this->getId());
		}
		else
		{
			//insert
			if($this->getId() == '')
				$this->setId($this->_generateNextId());

			$query = "insert into Scale (id,affiliate_id,program_id,percentage,signups,revsharepercent,priceperhit,pricepersignup,pricereducedpercancel,pricereducedperchargeback) values (?,?,?,?,?,?,?,?,?,?)";
			$valueArray = array($this->getId(),$this->getAffiliateId(),$this->getProgramId(),$this->getPercentage(),$this->getSignups(),$this->getRevsharepercent(),$this->getPriceperhit(),$this->getPricepersignup(),$this->getPricereducedpercancel(),$this->getPricereducedperchargeback());
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

		$query = "select * from Scale where id=?";
		$sth = $this->db->prepare($query);
		$res = $this->db->execute($sth, array($id));

		$row = $res->fetchRow(DB_FETCHMODE_ASSOC);

		$this->setId($row['id']);
		$this->setAffiliateId($row['affiliate_id']);
		$this->setProgramID($row['program_id']);
		$this->setPercentage($row['percentage']);
		$this->setSignups($row['signups']);
		$this->setRevsharepercent($row['revsharepercent']);
		$this->setPriceperhit($row['priceperhit']);
		$this->setPricepersignup($row['pricepersignup']);
		$this->setPricereducedpercancel($row['pricereducedpercancel']);
		$this->setPricereducedperchargeback($row['pricereducedperchargeback']);
		$this->_record_exists = true;
		$this->_modified = false;
	}
	/**
	* this function will get the record an array of records of type scale
	* by the affiliate id
	*
	*@access public
	*/
	function getAllByAffiliateId($id = '', $program_id=1)
	{
		if($id == '')
			$id = $this->getAffiliateId();
		if(!$id)
			trigger_error("you must set id to get by it", E_USER_ERROR);

		$query = "select * from Scale where affiliate_id=? and program_id=? order by percentage, signups";
		$sth = $this->db->prepare($query);
		$res = $this->db->execute($sth, array($id, $program_id));

		$return = array();
		while($row = $res->fetchRow(DB_FETCHMODE_ASSOC))
		{
			$t = $this;
			$t->setId($row['id']);
			$t->setAffiliateId($row['affiliate_id']);
			$t->setProgramID($row['program_id']);
			$t->setPercentage($row['percentage']);
			$t->setSignups($row['signups']);
			$t->setRevsharepercent($row['revsharepercent']);
			$t->setPriceperhit($row['priceperhit']);
			$t->setPricepersignup($row['pricepersignup']);
			$t->setPricereducedpercancel($row['pricereducedpercancel']);
			$t->setPricereducedperchargeback($row['pricereducedperchargeback']);
			$t->_record_exists = true;
			$t->_modified = false;
			array_push($return, clone($t));
		}
		return $return;
	}
	
	/*
	*this function will generate the next id
	*
	*@access private
	*/
	function _generateNextId()
	{
		return $this->db->nextId("Scale", true);
	}
	
	/**
	* this is the key to it all
	* we will pass in the affiliate id, signups and hits
	* and set this object based on the values given
	*
	*@access public
	*@param mixed int affiliate id
	*@param mixed int signups
	*@param mixed int hits
	*/
	function calculate($affiliate_id, $signups, $hits=0, $program_id=1)
	{
		//first lets get the scales for this affiliate
		//if none for affiliate then get default
		//from the scales gotten determine if it is by conversion rate by seeing if percent is 0
		//that can be checked on teh first row
		
		$res =& $this->db->query("select * from Scale where affiliate_id=? and program_id=?", array($affiliate_id, $program_id));
		if($res->numRows() == 0)
			$res =& $this->db->query("select * from Scale where affiliate_id=? and program_id=?", array('default', $program_id));
			
		$by_ratio = array();
		$by_signups = array();
		
		//right now we will do this simple, its either one or the other determined by one factor
		$by_signups_flag =false;
		while($row = $res->fetchRow(DB_FETCHMODE_ASSOC))
		{
			if($row['percentage'] == 0)
			{
				$by_signups_flag = true;
				$by_signups[$row['signups']]['id'] = $row['id'];
				$by_signups[$row['signups']]['revsharepercent'] = $row['revsharepercent'];
				$by_signups[$row['signups']]['priceperhit'] = $row['priceperhit'];
				$by_signups[$row['signups']]['pricepersignup'] = $row['pricepersignup'];
				$by_signups[$row['signups']]['pricereducedpercancel'] = $row['pricereducedpercancel'];
				$by_signups[$row['signups']]['pricereducedperchargeback'] = $row['pricereducedperchargeback'];
			}	
			else
			{
				$by_ratio[$row['percentage']]['id'] = $row['id'];
				$by_ratio[$row['percentage']]['revsharepercent'] = $row['revsharepercent'];
				$by_ratio[$row['percentage']]['priceperhit'] = $row['priceperhit'];
				$by_ratio[$row['percentage']]['pricepersignup'] = $row['pricepersignup'];
				$by_ratio[$row['percentage']]['pricereducedpercancel'] = $row['pricereducedpercancel'];
				$by_ratio[$row['percentage']]['pricereducedperchargeback'] = $row['pricereducedperchargeback'];	
			}
		}
		
		//ok now we have two arrays with the ratios we are either gonna use by signpus or by ratio
		//and choose the proper one
		$revsharepercent=0;
		$priceperhit =0;
		$pricepersignups=0;
		$pricereducedpercancel=0;
		$pricereducedperchargeback=0;
		$id = 0;
		
		$check_array = array(); //this will be set to either $by_signups or $by_ratio
		$check_for = ''; //this will be set to eithe rhte number of signups or the ratio %
		if($by_signups_flag)
		{
			$check_array = $by_signups;
			$check_for = $signups;
		}
		else
		{
			$check_array = $by_ratio;
			$check_for = ($hits ? $signups/$hits : 0);
		}
		
		//ok now i need to go through check array and find the key that is larger than $check_for
		//BUT it has to be the lowest possible value
		$curr_key = 0;
		foreach($check_array as $key =>$val_ar)
		{
			if($key > $check_for)
			{
				if($curr_key == 0)
					$curr_key = $key;
				
				if($curr_key >= $key)
				{
					$id = $val_ar['id'];	
					$revsharepercent = $val_ar['revsharepercent'];	
					$priceperhit = $val_ar['priceperhit'];	
					$pricepersignup = $val_ar['pricepersignup'];
					$pricereducedpercancel = $val_ar['pricereducedpercancel'];
					$pricereducedperchargeback = $val_ar['pricereducedperchargeback'];
				}
					
			}	
		}
		
		//ok here our vars should be ready to be set
		$this->id = $id;
		$this->revsharepercent = $revsharepercent;
		$this->priceperhit = $priceperhit;
		$this->pricepersignup = $pricepersignup;
		$this->pricereducedpercancel = $pricereducedpercancel;
		$this->pricereducedperchargeback = $pricereducedperchargeback;
		
		
	}
}

