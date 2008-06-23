<?php

require_once 'PEAR.php';
require_once 'classAffiliateProgramDB.inc.php';
/**
 * this is used for the affiiate logging in. it has username and password.
 *
 * long description of class
 *
 * @author Tanguy de Courson <tanguy@0x7a69.net>
 * @author Derek Volker <dvolker@0x7a69.net>
 * @version .9b
 * @access public
 * @package AffiliateProgram
*/
class AffiliateLogin extends PEAR
{
	/**
	* description of id
	*@var int
	*/
	var $id;
	/**
	* description of username
	*@var string
	*/
	var $username;
	/**
	* description of password
	*@var string
	*/
	var $password;
	/**
	* description of affiliate_id
	*@var int
	*/
	var $affiliate_id;
	/**
	* session_id
	*@var string
	*/
	var $session_id;

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
	*@param mixed DB
	*@param mixed bool if this is false that means do not perform the authentication
	* @access public
	*/
	function AffiliateLogin($db = false, $do_login = true)
	{
		$this->PEAR();

		if(!$db)
		{
			$mdb = new AffiliateProgramDB();
			$db = $mdb->connect_to_db();
		}
		
		$this->db = $db;
		if($do_login)
		{
			session_start();
			$this->session_id = session_id();
			
			if($username = $this->getSessionUsername())
			{
				$this->username = $username;
			}
			else if(isset($_SERVER['PHP_AUTH_USER']))
			{
				
				$this->username = $_SERVER['PHP_AUTH_USER'];
				$this->password = $_SERVER['PHP_AUTH_PW'];
				$this->login();
				
			}
			else if($_REQUEST['username'])
			{
				$this->username = $_REQUEST['username'];
				$this->password = $_REQUEST['password'];
				//header('WWW-Authenticate: Basic realm="Affilaite Login"');
				//header("Location: http://" . $this->username . ":" . $this->password . "@" . $_SERVER['SERVER_NAME'] . $_SERVER['SCRIPT_URL']);
				$this->login();
			}
			else
			{
				$this->unauth();
			}
		}
	}
	/**
	* Destructor
	*Descructor: this will call the _update function upon unset to tie changes into the database
	*
	* @access private
	*/
	function _AffiliateLogin()
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
	* Acessor function to set the username variable
	*
	*@param mixed
	*@access public
	*/
	function setUsername($username)
	{
		if($username != $this->username)
		{
			$this->_modified = true;
			$this->username = $username;
		}
	}
	/**
	* Acessor function to set the password variable
	*
	*@param mixed
	*@access public
	*/
	function setPassword($password)
	{
		if($password != $this->password)
		{
			$this->_modified = true;
			$this->password = $password;
		}
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
	* Acessor function to set the session_id variable
	*
	*@param mixed
	*@access public
	*/
	function setSessionId($session_id)
	{
		if($session_id != $this->session_id)
		{
			$this->_modified = true;
			$this->session_id = $session_id;
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
	* Acessor function to get the username variable
	*
	*@access public
	*@return mixed
	*/
	function getUsername()
	{
		return $this->username;
	}
	/**
	* Acessor function to get the password variable
	*
	*@access public
	*@return mixed
	*/
	function getPassword()
	{
		return $this->password;
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
	* Acessor function to get the session_id variable
	*
	*@access public
	*@return mixed
	*/
	function getSessionId()
	{
		return $this->session_id;
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
			$query = "update AffiliateLogin set username=?,password=?,affiliate_id=? where id=?";
			$valueArray = array($this->getUsername(),$this->getPassword(),$this->getAffiliateId(),$this->getId());
		}
		else
		{
			//insert
			if($this->getId() == '')
				$this->setId($this->_generateNextId());

			$query = "insert into AffiliateLogin (id,username,password,affiliate_id) values (?,?,?,?)";
			$valueArray = array($this->getId(),$this->getUsername(),$this->getPassword(),$this->getAffiliateId());
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

		$query = "select * from AffiliateLogin where id=?";
		$sth = $this->db->prepare($query);
		$res = $this->db->execute($sth, array($id));

		$row = $res->fetchRow(DB_FETCHMODE_ASSOC);

		$this->setId($row['id']);
		$this->setUsername($row['username']);
		$this->setPassword($row['password']);
		$this->setAffiliateId($row['affiliate_id']);
		$this->_record_exists = true;
		$this->_modified = false;
	}
	/**
	this function will get the record by its affilaiteid
	*
	*@access public
	*/
	function getByAffiliateId($id = '')
	{
		if($id == '')
			$id = $this->getId();
		if(!$id)
			trigger_error("you must set id to get by it", E_USER_ERROR);

		$query = "select * from AffiliateLogin where affiliate_id=?";
		$sth = $this->db->prepare($query);
		$res = $this->db->execute($sth, array($id));

		$row = $res->fetchRow(DB_FETCHMODE_ASSOC);

		$this->setId($row['id']);
		$this->setUsername($row['username']);
		$this->setPassword($row['password']);
		$this->setAffiliateId($row['affiliate_id']);
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
		return $this->db->nextId("AffiliateLogin", true);
	}
	function getSessionUsername()
	{
		$sth = $this->db->prepare("select username, affiliate_id from AffiliateLogin where session_id=?");
		$res = $this->db->execute($sth, array($this->session_id));
		list($user, $affiliate_id) = $res->fetchRow();
		if(!$user)
			return false;
		else
		{
			$this->affiliate_id = $affiliate_id;
			return $user;
		}
	}
	function login()
	{
		$sth = $this->db->prepare("select username, affiliate_id from AffiliateLogin where username=? and password=?");
		$res = $this->db->execute($sth, array($this->username, $this->password));
		list($user, $affiliate_id) = $res->fetchRow();
		if(!$user)
			$this->unauth();
		else
		{
			$sth = $this->db->prepare("update AffiliateLogin set session_id=? where username=?");
			$res = $this->db->execute($sth, array($this->session_id, $this->username));
			$this->affiliate_id = $affiliate_id;
		}
	}
	function unauth()
	{
		header('HTTP/1.0 401 Unauthorized');
		header('WWW-Authenticate: Basic realm="Affiliate Login"');
		echo 'You are not authorized';
		exit;
	}
	/**
	* this function will return a string of username taken if the username is taken
	*
	*@param mixed string username
	*@return mixed string error message
	*/
	function checkUsername($username)
	{
		$return = '';
		$res = $this->db->query("select id from AffiliateLogin where username=?", array($username));
		list($id) = $res->fetchRow();
		if($id)
			$return = 'Username Taken';
		
		return $return;
	}
	
	function logout()
	{
		header('HTTP/1.0 401 Unauthorized');
		header('WWW-Authenticate: Basic realm="Affiliate Login"');
		$sth = $this->db->prepare("update AffiliateLogin set session_id=? where username=?");
		$res = $this->db->execute($sth, array('***loggedout', $this->username));
	}	
}


