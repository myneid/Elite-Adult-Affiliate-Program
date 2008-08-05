<?php

require_once 'PEAR.php';
require_once 'classAffiliateProgramDB.inc.php';
/**
 * this is the affiliate object, it gets tied in iwth the webmaster object
 *
 * long description of class
 *
 * @author Tanguy de Courson <tanguy@0x7a69.net>
 * @author Derek Volker <dvolker@0x7a69.net>
 * @version .9b
 * @access public
 * @package AffiliateProgram
*/
class Affiliate extends PEAR
{
	/**
	* description of id
	*@var int
	*/
	var $id;
	/**
	* description of webmaster_id
	*@var int
	*/
	var $webmaster_id;
	/**
	* description of program_id
	*@var int
	*/
	var $program_id;
	/**
	* status for this affilati id (ACTIVE, DISABLED, DISABLED-SPAM)
	*@var string
	*/
	var $status;
	var $rating;

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
	function Affiliate($db = false)
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
	function _Affiliate()
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
	* Acessor function to set the webmaster_id variable
	*
	*@param mixed
	*@access public
	*/
	function setWebmasterId($webmaster_id)
	{
		$this->_modified = true;
		$this->webmaster_id = $webmaster_id;
	}
	/**
	* Acessor function to set the program_id variable
	*
	*@param mixed
	*@access public
	*/
	function setProgramId($program_id)
	{
		$this->_modified = true;
		$this->program_id = $program_id;
	}
	/**
	* Acessor function to set the status variable
	*
	*@param mixed
	*@access public
	*/
	function setStatus($status)
	{
		if($this->status != $status)
		{
			$this->_modified = true;
			$this->status = $status;
		}
	}
	function setRating($rating)
	{
		if($this->rating != $rating)
		{
			$this->_modified = true;
			$this->rating = $rating;
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
	* Acessor function to get the webmaster_id variable
	*
	*@access public
	*@return mixed
	*/
	function getWebmasterId()
	{
		return $this->webmaster_id;
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
	* Acessor function to get the status variable
	*
	*@access public
	*@return mixed
	*/
	function getStatus()
	{
		return $this->status;
	}
	function getRating()
	{
		return $this->rating;
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
			$query = "update Affiliate set webmaster_id=?,program_id=?,status=?,rating=? where id=?";
			$valueArray = array($this->getWebmasterId(),$this->getProgramId(),$this->getStatus(),$this->getRating(), $this->getId());
		}
		else
		{
			//insert
			if($this->getId() == '')
				$this->setId($this->_generateNextId());

			$query = "insert into Affiliate (id,webmaster_id,program_id,status,rating) values (?,?,?,?,?)";
			$valueArray = array($this->getId(),$this->getWebmasterId(),$this->getProgramId(),$this->getStatus(),$this->getRating());
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

		$query = "select * from Affiliate where id=?";
		$sth = $this->db->prepare($query);
		$res = $this->db->execute($sth, array($id));

		$row = $res->fetchRow(DB_FETCHMODE_ASSOC);

		$this->setId($row['id']);
		$this->setWebmasterId($row['webmaster_id']);
		$this->setProgramId($row['program_id']);
		$this->setStatus($row['status']);
		$this->setRating($row['rating']);
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
		return $this->db->nextId("Affiliate", true);
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

