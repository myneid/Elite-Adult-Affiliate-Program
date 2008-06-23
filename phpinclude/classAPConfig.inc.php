<?php
require_once 'PEAR.php';
require_once 'classAffiliateProgramDB.inc.php';
/**
 * this is the global config file
 *
 * long description of class
 *
 * @author Tanguy de Courson <tanguy@0x7a69.net>
 * @author Derek Volker <dvolker@0x7a69.net>
 * @version .9b
 * @access public
 * @package Affiliate Program
*/
class APConfig extends PEAR
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
	* description of value
	*@var string
	*/
	var $value;
	/**
	* description of description
	*@var string
	*/
	var $description;
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
	function APConfig($db = false)
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
	function _APConfig()
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
		if($id != $this->id)
		{
			$this->_modified = true;
			$this->id = $id;
		}
	}
	/**
	* Acessor function to set the name variable
	*
	*@param mixed
	*@access public
	*/
	function setName($name)
	{
		if($name != $this->name)
		{
			$this->_modified = true;
			$this->name = $name;
		}
	}
	/**
	* Acessor function to set the value variable
	*
	*@param mixed
	*@access public
	*/
	function setValue($value)
	{
		if($value != $this->value)
		{
			$this->_modified = true;
			$this->value = $value;
		}
	}
	/**
	* Acessor function to set the description variable
	*
	*@param mixed
	*@access public
	*/
	function setDescription($description)
	{
		if($description != $this->description)
		{
			$this->_modified = true;
			$this->description = $description;
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
	* Acessor function to get the value variable
	*
	*@access public
	*@return mixed
	*/
	function getValue()
	{
		return $this->value;
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
			$query = "update APConfig set name=?,value=?,description=? where id=?";
			$valueArray = array($this->getName(),$this->getValue(),$this->getDescription(),$this->getId());
		}
		else
		{
			//insert
			if($this->getId() == '')
				$this->setId($this->_generateNextId());

			$query = "insert into APConfig (id,name,value,description) values (?,?,?,?)";
			$valueArray = array($this->getId(),$this->getName(),$this->getValue(),$this->getDescription());
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

		$query = "select * from APConfig where id=?";
		$sth = $this->db->prepare($query);
		$res = $this->db->execute($sth, array($id));

		$row = $res->fetchRow(DB_FETCHMODE_ASSOC);

		$this->setId($row['id']);
		$this->setName($row['name']);
		$this->setValue($row['value']);
		$this->setDescription($row['description']);
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
		return $this->db->nextId("APConfig", true);
	}
	/**
	* this will get all of the config vars in the table
	* into an array of type apconfig
	*
	*@access public
	*/
	function getAll()
	{
		$return = array();
		$res = $this->db->query("select * from APConfig");
		while($row = $res->fetchRow(DB_FETCHMODE_ASSOC))
		{
			$t = $this;
			$t->setId($row['id']);
			$t->setName($row['name']);
			$t->setValue($row['value']);
			$t->setDescription($row['description']);
			$t->_record_exists = true;
			$t->_modified = false;
			
			array_push($return, $t);
		}
		
		return $return;
	}
	/**
	* this function will return the assoc array
	* of all the fields in the APConfig table
	*
	*@access public
	*@return mixed array
	*/
	function get_all_vars()
	{
		$res = $this->db->query("select * from APConfig");
		$return = array();
		while(list($id, $name, $value, $desc) = $res->fetchRow())
		{
			$return[$name] = $value;	
		}
		return $return;
	}
	
	
}
?>