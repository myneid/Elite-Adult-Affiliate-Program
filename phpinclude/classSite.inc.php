<?php

require_once 'PEAR.php';
require_once 'classAffiliateProgramDB.inc.php';
/**
 * Each site that you create should get a new record. Each tour can be considered its own site.
 *
 * long description of class
 *
 * @author Tanguy de Courson <tanguy@0x7a69.net>
 * @author Derek Volker <dvolker@0x7a69.net>
 * @version .9b
 * @access public
 * @package AffiliateProgram
*/
class Site extends PEAR
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
	* description of mainurl
	*@var string
	*/
	var $mainurl;
	/**
	* description of joinurl
	*@var string
	*/
	var $joinurl;
	/**
	* description of membersurl
	*@var string
	*/
	var $membersurl;
	var $ext_siteid;
	var $status;

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
	function Site($db = false)
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
	function _Site()
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
	* Acessor function to set the mainurl variable
	*
	*@param mixed
	*@access public
	*/
	function setMainurl($mainurl)
	{
		$this->_modified = true;
		$this->mainurl = $mainurl;
	}
	/**
	* Acessor function to set the joinurl variable
	*
	*@param mixed
	*@access public
	*/
	function setJoinurl($joinurl)
	{
		$this->_modified = true;
		$this->joinurl = $joinurl;
	}
	/**
	* Acessor function to set the membersurl variable
	*
	*@param mixed
	*@access public
	*/
	function setMembersurl($membersurl)
	{
		$this->_modified = true;
		$this->membersurl = $membersurl;
	}

	/**
	* Acessor function to set the membersurl variable
	*
	*@param mixed
	*@access public
	*/
	function setExtSiteid($ext_siteid)
	{
		$this->_modified = true;
		$this->ext_siteid = $ext_siteid;
	}
	function setStatus($status)
	{
		if($status != $this->status)
		{
			$this->_modified = true;
			$this->status = $status;
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
	* Acessor function to get the mainurl variable
	*
	*@access public
	*@return mixed
	*/
	function getMainurl()
	{
		return $this->mainurl;
	}
	/**
	* Acessor function to get the joinurl variable
	*
	*@access public
	*@return mixed
	*/
	function getJoinurl()
	{
		return $this->joinurl;
	}
	/**
	* Acessor function to get the membersurl variable
	*
	*@access public
	*@return mixed
	*/
	function getMembersurl()
	{
		return $this->membersurl;
	}
	/**
	* Acessor function to get the membersurl variable
	*
	*@access public
	*@return mixed
	*/
	function getExtSiteid()
	{
		return $this->ext_siteid;
	}
	function getStatus()
	{
		return $this->status;
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
			$query = "update Site set name=?,description=?,mainurl=?,joinurl=?,membersurl=?, ext_siteid=?,status=? where id=?";
			$valueArray = array($this->getName(),$this->getDescription(),$this->getMainurl(),$this->getJoinurl(),$this->getMembersurl(),$this->getExtSiteid(), $this->getStatus(), $this->getId());
		}
		else
		{
			//insert
			if($this->getId() == '')
				$this->setId($this->_generateNextId());

			$query = "insert into Site (id,name,description,mainurl,joinurl,membersurl,ext_siteid,status) values (?,?,?,?,?,?,?,?)";
			$valueArray = array($this->getId(),$this->getName(),$this->getDescription(),$this->getMainurl(),$this->getJoinurl(),$this->getMembersurl(), $this->getExtSiteid(), $this->getStatus());
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

		$query = "select * from Site where id=?";
		$sth = $this->db->prepare($query);
		$res = $this->db->execute($sth, array($id));

		$row = $res->fetchRow(DB_FETCHMODE_ASSOC);

		$this->setId($row['id']);
		$this->setName($row['name']);
		$this->setDescription($row['description']);
		$this->setMainurl($row['mainurl']);
		$this->setJoinurl($row['joinurl']);
		$this->setMembersurl($row['membersurl']);
		$this->setExtSiteid($row['ext_siteid']);
		$this->setStatus($row['status']);
		$this->_record_exists = true;
		$this->_modified = false;
	}
	/**
	this function will get the record by its domain name, not perfect but it will have to do
	*
	*@access public
	*/
	function getByDomain($domain = '')
	{
		
		if(!$domain)
			trigger_error("you must set domain to get by it", E_USER_ERROR);

		$query = "select * from Site where mainurl like '%!%'";
		$sth = $this->db->prepare($query);
		$res = $this->db->execute($sth, array($domain));
		$row = $res->fetchRow(DB_FETCHMODE_ASSOC);

		$this->setId($row['id']);
		$this->setName($row['name']);
		$this->setDescription($row['description']);
		$this->setMainurl($row['mainurl']);
		$this->setJoinurl($row['joinurl']);
		$this->setMembersurl($row['membersurl']);
		$this->setExtSiteid($row['ext_siteid']);
		$this->setStatus($row['status']);
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
		return $this->db->nextId("Site", true);
	}
	/**
	* this will get all of the sites in the table
	* into an array of type site
	*
	*@access public
	*/
	function getAll()
	{
		$return = array();
		$res = $this->db->query("select * from Site where status != 'deleted' order by name");
		while($row = $res->fetchRow(DB_FETCHMODE_ASSOC))
		{
			$t = $this;
			$t->setId($row['id']);
			$t->setName($row['name']);
			$t->setDescription($row['description']);
			$t->setMainurl($row['mainurl']);
			$t->setJoinurl($row['joinurl']);
			$t->setMembersurl($row['membersurl']);
			$t->setExtSiteid($row['ext_siteid']);
			$t->setStatus($row['status']);
			$t->_record_exists = true;
			$t->_modified = false;

			array_push($return, $t);
		}

		return $return;
	}
	/**
	* return ana rray where key is site id and value is site name
	*
	*@access public
	*@return mixed array
	*/
	function getNames()
	{
		$res = $this->db->query("select id, name from Site");
		$return = array();
		while(list($id,$name) = $res->fetchRow())
		{
			$return[$id] = $name;
		}
		return $return;
	}
}

?>
