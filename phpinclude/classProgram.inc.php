<?php

require_once 'PEAR.php';
require_once 'classAffiliateProgramDB.inc.php';
/**
 * this is for different programs, such as 'console' or 'noconsole'. or whatever differentiators you want to have for programs
 *
 * long description of class
 *
 * @author Tanguy de Courson <tanguy@0x7a69.net>
 * @author Derek Volker <dvolker@0x7a69.net>
 * @version .9b
 * @access public
 * @package AffiliateProgram
*/
class Program extends PEAR
{
	/**
	* description of id
	*@var int
	*/
	var $id;
	/**
	* description of name
	*@var string
	*/
	var $name;
	/**
	* description of description
	*@var string
	*/
	var $description;
	/**
	* description of scale_affiliate_id
	*@var int
	*/
	var $scale_affiliate_id;

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
	function Program($db = false)
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
	function _Program()
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
	* Acessor function to set the name variable
	*
	*@param mixed
	*@access public
	*/
	function setName($name)
	{
		$this->_modified = true;
		$this->name = $name;
	}
	/**
	* Acessor function to set the description variable
	*
	*@param mixed
	*@access public
	*/
	function setDescription($description)
	{
		$this->_modified = true;
		$this->description = $description;
	}
	/**
	* Acessor function to set the scale_affiliate_id variable
	*
	*@param mixed
	*@access public
	*/
	function setScaleAffiliateId($scale_affiliate_id)
	{
		$this->_modified = true;
		$this->scale_affiliate_id = $scale_affiliate_id;
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
	* Acessor function to get the name variable
	*
	*@access public
	*@return mixed
	*/
	function getName()
	{
		return $this->name;
	}
	/**
	* Acessor function to get the description variable
	*
	*@access public
	*@return mixed
	*/
	function getDescription()
	{
		return $this->description;
	}
	/**
	* Acessor function to get the scale_affiliate_id variable
	*
	*@access public
	*@return mixed
	*/
	function getScaleAffiliateId()
	{
		return $this->scale_affiliate_id;
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
			$query = "update Program set name=?,description=?,scale_affiliate_id=? where id=?";
			$valueArray = array($this->getName(),$this->getDescription(),$this->getScaleAffiliateId(),$this->getId());
		}
		else
		{
			//insert
			if($this->getId() == '')
				$this->setId($this->_generateNextId());

			$query = "insert into Program (id,name,description,scale_affiliate_id) values (?,?,?,?)";
			$valueArray = array($this->getId(),$this->getName(),$this->getDescription(),$this->getScaleAffiliateId());
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

		$query = "select * from Program where id=?";
		$sth = $this->db->prepare($query);
		$res = $this->db->execute($sth, array($id));

		$row = $res->fetchRow(DB_FETCHMODE_ASSOC);

		$this->setId($row['id']);
		$this->setName($row['name']);
		$this->setDescription($row['description']);
		$this->setScaleAffiliateId($row['scale_affiliate_id']);
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
		return $this->db->nextId("Program", true);
	}
	/**
	* return ana rray where key is site id and value is site name
	*
	*@access public
	*@return mixed array
	*/
	function getNames()
	{
		$res = $this->db->query("select id, name from Program");
		$return = array();
		while(list($id,$name) = $res->fetchRow())
		{
			$return[$id] = $name;
		}
		return $return;
	}
}

?>
