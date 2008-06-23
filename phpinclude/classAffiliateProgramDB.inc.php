<?php
require_once("DB.php");
/**
* Database object for the PPS
*
*$Id$
* This should be the only place that connections to teh 
* pps database are made
*
* @author Tanguy de Courson <tanguy@0x7a69.net>
* @author Derek Volker <dvolker@0x7a69.net>
* @version .9b
* @access public
* @package AffiliateProgram
*/
class AffiliateProgramDB
{
	/**
	* access determines if this object is read or write or both 'rw' is readwrite, 'r' is read, 'w' is write
	* really comes into use in a master/slave mysql scenario
	*@var string
	*/
	var $access = 'rw';	
	/**
	* the pear db object for the db to write to
	*@var object
	*/
	var $write_db;
	/**
	* the pear db object used for reading
	*
	*@var object
	*/
	var $read_db;
	/**
	* the hostname of the master mysql server
	*
	*@var string
	*/
	var $hostname    = '10.2.2.1'; 
	/**
	* teh hostname of the slave mysql server
	*
	*@var string
	*/
	var $slave_hostname    = 'slave'; 
	/**
	* the mysql port to use, set to 0 for default
	*@var int
	*/
	var $port         = 0;
	/**
	* mysql username
	*@var string
	*/
	var $username     = 'username';
	/**
	* mysql passowrd
	*@var string
	*/
	var $password    = 'password';
	/**
	* the db type, used for the pear db object. 'mysql' for mysql, 'oracle' for oracle (i think, it might be oci8)
	*@var string
	*/
	var $dbtype     = 'mysql';
	/**
	* the database name
	*@var string
	*/
	var $dbname        = 'AffiliateProgram';
	/**
	* if you have a master/slave setup, set this value to true, otherwise leave it at false
	*@var bool
	*/
	var $enable_slave = false;

	/**
	* the DB prepare function returns an index to teh prepared statement
	* so i need to store that index along with which db it is using to run teh execute
	*
	*@var array
	*/
	var $_sths = array();


	function AffiliateProgramDB($access = 'rw')
	{
		$this->access = $access;
	}
	function connect_to_db($access = 'rw')
	{
		if($this->access != $access)
			$this->access = $access;

		if(preg_match("/w/i", $this->access))
			$this->write_db = $this->_connect($this->hostname);
		if($this->enable_slave && preg_match("/r/i", $this->access))
			$this->read_db = $this->_connect($this->slave_hostname);

		return $this;

	}
	function _connect($hostname)
	{
            $dsn         = $this->dbtype . "://" . $this->username . ":" . $this->password . "@$hostname" . ($this->port > 0 ? ":$this->port" : "") . "/" . $this->dbname;

            $db = DB::connect($dsn);

            if(DB::isError($db))
            {
            	//print_r($db);
                die($db->getMessage());
            }
	    return $db;
		
	}
	function query($statement, $array = array())
	{
		if($this->enable_slave && preg_match("/^select /i", $statement))
		{
			return $this->read_db->query($statement, $array);
		}
		else
		{
			return $this->write_db->query($statement, $array);
		}
	}
	function prepare($statement)
	{
		$t = array();
		if($this->enable_slave && preg_match("/^select /i", $statement))
		{
			$sth = $this->read_db->prepare($statement);
			$t = array($sth, 'r');

		}
		else
		{
			$sth = $this->write_db->prepare($statement);
			$t = array($sth, 'w');
		}
		array_push($this->_sths, $t);
		return count($this->_sths)-1;

	}
	function execute($mysth, $valueArray)
	{
		list($sth, $access) = $this->_sths[$mysth];
		if($this->enable_slave && $access == 'r')
			return $this->read_db->execute($sth, $valueArray);
		else
			return $this->write_db->execute($sth, $valueArray);
	}
	function nextId($name, $bool = true)
	{
		return $this->write_db->nextId($name, $bool);	
	}
	function setDatabase($database)
	{
		$this->dbname = $database;	
	}
}
?>
