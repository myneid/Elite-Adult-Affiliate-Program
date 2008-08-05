<?php

require_once 'PEAR.php';
require_once 'classAffiliateProgramDB.inc.php';
require_once('classAffiliate.inc.php');
/**
 * this is the webmasters information. one webmaster can technically have multiple accounts (multiple affiliates)
 * but keep this same information
 *
 * long description of class
 *
 * @author Tanguy de Courson <tanguy@0x7a69.net>
 * @author Derek Volker <dvolker@0x7a69.net>
 * @version .9b
 * @access public
 * @package AffiliateProgram
*/
class Webmaster extends PEAR
{
	/**
	* description of id
	*@var int
	*/
	var $id;
	/**
	* description of firstname
	*@var string
	*/
	var $firstname;
	/**
	* description of lastname
	*@var string
	*/
	var $lastname;
	/**
	* description of ssn_taxid
	*@var string
	*/
	var $ssn_taxid;
	/**
	* description of street_address
	*@var string
	*/
	var $street_address;
	/**
	* description of postal_code
	*@var string
	*/
	var $postal_code;
	/**
	* description of city
	*@var string
	*/
	var $city;
	/**
	* description of state
	*@var string
	*/
	var $state;
	/**
	* description of country
	*@var string
	*/
	var $country;
	/**
	* description of email
	*@var string
	*/
	var $email;
	/**
	* description of referred_webmaster_id
	*@var string
	*/
	var $referred_webmaster_id;

	/**
	* description of aim
	*@var string
	*/
	var $aim;
	/**
	* description of icq
	*@var string
	*/
	var $icq;
	/**
	* description of company
	*@var string
	*/
	var $company;
	/**
	* description of pay_to
	*@var string
	*/
	var $pay_to;
	/**
	* description of minimum_payout
	*@var string
	*/
	var $minimum_payout;
	/**
	* description of payment_method
	*@var string
	*/
	var $payment_method;
	/**
	* description of notes
	*@var string
	*/
	var $notes;
	/**
	* the referral % that webmasters this guy refers he should make this % of their payout
	*@var string
	*/
	var $referral_percent;
	/**
	* the total number of signups this webmaster has sent total
	*@var string
	*/
	var $total_signups;
	/**
	* user defined field
	*@var string
	*/
	var $udf1;
	var $skype;
	var $phone;
	var $referral_amount;
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
	function Webmaster($db = false)
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
	function _Webmaster()
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
	* Acessor function to set the firstname variable
	*
	*@param mixed
	*@access public
	*/
	function setFirstname($firstname)
	{
		$this->_modified = true;
		$this->firstname = $firstname;
	}
	/**
	* Acessor function to set the lastname variable
	*
	*@param mixed
	*@access public
	*/
	function setLastname($lastname)
	{
		$this->_modified = true;
		$this->lastname = $lastname;
	}
	/**
	* Acessor function to set the ssn_taxid variable
	*
	*@param mixed
	*@access public
	*/
	function setSsnTaxid($ssn_taxid)
	{
		$this->_modified = true;
		$this->ssn_taxid = $ssn_taxid;
	}
	/**
	* Acessor function to set the street_address variable
	*
	*@param mixed
	*@access public
	*/
	function setStreetAddress($street_address)
	{
		$this->_modified = true;
		$this->street_address = $street_address;
	}
	/**
	* Acessor function to set the postal_code variable
	*
	*@param mixed
	*@access public
	*/
	function setPostalCode($postal_code)
	{
		$this->_modified = true;
		$this->postal_code = $postal_code;
	}
	/**
	* Acessor function to set the city variable
	*
	*@param mixed
	*@access public
	*/
	function setCity($city)
	{
		$this->_modified = true;
		$this->city = $city;
	}
	/**
	* Acessor function to set the state variable
	*
	*@param mixed
	*@access public
	*/
	function setState($state)
	{
		$this->_modified = true;
		$this->state = $state;
	}
	/**
	* Acessor function to set the country variable
	*
	*@param mixed
	*@access public
	*/
	function setCountry($country)
	{
		$this->_modified = true;
		$this->country = $country;
	}
	/**
	* Acessor function to set the email variable
	*
	*@param mixed
	*@access public
	*/
	function setEmail($email)
	{
		if($email != $this->email)
		{
			$this->_modified = true;
			$this->email = $email;
		}
	}
	/**
	* Acessor function to set the referred_webmaster_id variable
	*
	*@param mixed
	*@access public
	*/
	function setReferredWebmasterId($referred_webmaster_id)
	{
		if($this->referred_webmaster_id != $referred_webmaster_id)
		{
			$this->_modified = true;
			$this->referred_webmaster_id = $referred_webmaster_id;
		}
	}
	/**
	* Acessor function to set the aim variable
	*
	*@param mixed
	*@access public
	*/
	function setAim($aim)
	{
		if($this->aim != $aim)
		{
			$this->_modified = true;
			$this->aim = $aim;
		}
	}
	/**
	* Acessor function to set the icq variable
	*
	*@param mixed
	*@access public
	*/
	function setIcq($icq)
	{
		if($this->icq != $icq)
		{
			$this->_modified = true;
			$this->icq = $icq;
		}
	}
	/**
	* Acessor function to set the comapny variable
	*
	*@param mixed
	*@access public
	*/
	function setCompany($company)
	{
		if($this->company != $company)
		{
			$this->_modified = true;
			$this->company = $company;
		}
	}
	/**
	* Acessor function to set the pay_to variable
	*
	*@param mixed
	*@access public
	*/
	function setPayTo($pay_to)
	{
		if($this->pay_to != $pay_to)
		{
			$this->_modified = true;
			$this->pay_to = $pay_to;
		}
	}
	/**
	* Acessor function to set the minimum_payout variable
	*
	*@param mixed
	*@access public
	*/
	function setMinimumPayout($minimum_payout)
	{
		if($this->minimum_payout != $minimum_payout)
		{
			$this->_modified = true;
			$this->minimum_payout = $minimum_payout;
		}
	}
	/**
	* Acessor function to set the payment_method variable
	*
	*@param mixed
	*@access public
	*/
	function setPaymentMethod($payment_method)
	{
		if($this->payment_method != $payment_method)
		{
			$this->_modified = true;
			$this->payment_method = $payment_method;
		}
	}
	/**
	* Acessor function to set the notes variable
	*
	*@param mixed
	*@access public
	*/
	function setNotes($notes)
	{
		if($this->notes != $notes)
		{
			$this->_modified = true;
			$this->notes = $notes;
		}
	}
	/**
	* Acessor function to set the referral_percent variable
	*
	*@param mixed
	*@access public
	*/
	function setReferralPercent($referral_percent)
	{
		if($this->referral_percent != $referral_percent)
		{
			$this->_modified = true;
			$this->referral_percent = $referral_percent;
		}
	}
	/**
	* Acessor function to set the total_signups variable
	*
	*@param mixed
	*@access public
	*/
	function setTotalSignups($total_signups)
	{
		if($this->total_signups != $total_signups)
		{
			$this->_modified = true;
			$this->total_signups = $total_signups;
		}
	}
	/**
	* Acessor function to set the udf1 variable
	*
	*@param mixed
	*@access public
	*/
	function setUdf1($udf1)
	{
		if($this->udf1 != $udf1)
		{
			$this->_modified = true;
			$this->udf1 = $udf1;
		}
	}

	function setSkype($skype)
	{
		if($this->skype != $skype)
		{
			$this->_modified = true;
			$this->skype = $skype;
		}
	}

	function setPhone($phone)
	{
		if($this->phone != $phone)
		{
			$this->_modified = true;
			$this->phone = $phone;
		}
	}
	function setReferralAmount($referral_amount)
	{
		if($this->referral_amount != $referral_amount)
		{
			$this->_modified = true;
			$this->referral_amount = $referral_amount;
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
	* Acessor function to get the firstname variable
	*
	*@access public
	*@return mixed
	*/
	function getFirstname()
	{
		return $this->firstname;
	}
	/**
	* Acessor function to get the lastname variable
	*
	*@access public
	*@return mixed
	*/
	function getLastname()
	{
		return $this->lastname;
	}
	/**
	* Acessor function to get the ssn_taxid variable
	*
	*@access public
	*@return mixed
	*/
	function getSsnTaxid()
	{
		return $this->ssn_taxid;
	}
	/**
	* Acessor function to get the street_address variable
	*
	*@access public
	*@return mixed
	*/
	function getStreetAddress()
	{
		return $this->street_address;
	}
	/**
	* Acessor function to get the postal_code variable
	*
	*@access public
	*@return mixed
	*/
	function getPostalCode()
	{
		return $this->postal_code;
	}
	/**
	* Acessor function to get the city variable
	*
	*@access public
	*@return mixed
	*/
	function getCity()
	{
		return $this->city;
	}
	/**
	* Acessor function to get the state variable
	*
	*@access public
	*@return mixed
	*/
	function getState()
	{
		return $this->state;
	}
	/**
	* Acessor function to get the country variable
	*
	*@access public
	*@return mixed
	*/
	function getCountry()
	{
		return $this->country;
	}
	/**
	* Acessor function to get the email variable
	*
	*@access public
	*@return mixed
	*/
	function getEmail()
	{
		return $this->email;
	}
	/**
	* Acessor function to get the $referred_webmaster_id variable
	*
	*@access public
	*@return mixed
	*/
	function getReferredWebmasterId()
	{
		return $this->referred_webmaster_id;
	}
	/**
	* Acessor function to get the aim variable
	*
	*@access public
	*@return mixed
	*/
	function getAim()
	{
		return $this->aim;
	}
	/**
	* Acessor function to get the icq variable
	*
	*@access public
	*@return mixed
	*/
	function getIcq()
	{
		return $this->icq;
	}
	/**
	* Acessor function to get the company variable
	*
	*@access public
	*@return mixed
	*/
	function getCompany()
	{
		return $this->company;
	}
	/**
	* Acessor function to get the pay_to variable
	*
	*@access public
	*@return mixed
	*/
	function getPayTo()
	{
		return $this->pay_to;
	}
	/**
	* Acessor function to get the payment_method variable
	*
	*@access public
	*@return mixed
	*/
	function getPaymentMethod()
	{
		return $this->payment_method;
	}
	/**
	* Acessor function to get the minimum_payout variable
	*
	*@access public
	*@return mixed
	*/
	function getMinimumPayout()
	{
		return $this->minimum_payout;
	}
	/**
	* Acessor function to get the notes variable
	*
	*@access public
	*@return mixed
	*/
	function getNotes()
	{
		return $this->notes;
	}
	/**
	* Acessor function to get the referral_percent variable
	*
	*@access public
	*@return mixed
	*/
	function getReferralPercent()
	{
		return $this->referral_percent;
	}
	/**
	* Acessor function to get the total_signups variable
	*
	*@access public
	*@return mixed
	*/
	function getTotalSignups()
	{
		return $this->total_signups;
	}
	/**
	* Acessor function to get the udf1 variable
	*
	*@access public
	*@return mixed
	*/
	function getUdf1()
	{
		return $this->udf1;
	}

	function getSkype()
	{
		return $this->skype;
	}

	function getPhone()
	{
		return $this->phone;
	}
	function getReferralAmount()
	{
		return $this->referral_amount;
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
			$query = "update Webmaster set firstname=?,lastname=?,ssn_taxid=?,street_address=?,postal_code=?,city=?,state=?,country=?,email=?,referred_webmaster_id=?,aim=?,icq=?,company=?,pay_to=?,payment_method=?,minimum_payout=?,notes=?,referral_percent=?,total_signups=?,udf1=?,skype=?,phone=?,referral_amount=? where id=?";
			$valueArray = array($this->getFirstname(),$this->getLastname(),$this->getSsnTaxid(),$this->getStreetAddress(),$this->getPostalCode(),$this->getCity(),$this->getState(),$this->getCountry(),$this->getEmail(),$this->getReferredWebmasterId(),$this->getAim(), $this->getIcq(), $this->getCompany(), $this->getPayTo(),$this->getPaymentMethod(),$this->getMinimumPayout(),$this->getNotes(),$this->getReferralPercent(), $this->getTotalSignups(), $this->getUdf1(), $this->getSkype(), $this->getPhone(), $this->getReferralAmount(), $this->getId());
		}
		else
		{
			//insert
			if($this->getId() == '')
				$this->setId($this->_generateNextId());

			$query = "insert into Webmaster (id,firstname,lastname,ssn_taxid,street_address,postal_code,city,state,country,email,referred_webmaster_id,aim,icq,company,pay_to,payment_method,minimum_payout,notes,referral_percent,total_signups,udf1,skype,phone,referral_amount) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
			$valueArray = array($this->getId(),$this->getFirstname(),$this->getLastname(),$this->getSsnTaxid(),$this->getStreetAddress(),$this->getPostalCode(),$this->getCity(),$this->getState(),$this->getCountry(),$this->getEmail(),$this->getReferredWebmasterId(),$this->getAim(), $this->getIcq(), $this->getCompany(), $this->getPayTo(), $this->getPaymentMethod(), $this->getMinimumPayout(), $this->getNotes(), $this->getReferralPercent(),$this->getTotalSignups(),$this->getUdf1(),$this->getSkype(),$this->getPhone(),$this->getReferralAmount());
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

		$query = "select * from Webmaster where id=?";
		$sth = $this->db->prepare($query);
		$res = $this->db->execute($sth, array($id));

		$row = $res->fetchRow(DB_FETCHMODE_ASSOC);

		$this->setId($row['id']);
		$this->setFirstname($row['firstname']);
		$this->setLastname($row['lastname']);
		$this->setSsnTaxid($row['ssn_taxid']);
		$this->setStreetAddress($row['street_address']);
		$this->setPostalCode($row['postal_code']);
		$this->setCity($row['city']);
		$this->setState($row['state']);
		$this->setCountry($row['country']);
		$this->setEmail($row['email']);
		$this->setReferredWebmasterId($row['referred_webmaster_id']);
	
		$this->setAim($row['aim']);
		$this->setIcq($row['icq']);
		$this->setCompany($row['company']);
		$this->setPayTo($row['pay_to']);
		$this->setPaymentMethod($row['payment_method']);
		$this->setMinimumPayout($row['minimum_payout']);
		$this->setNotes($row['notes']);
		$this->setReferralPercent($row['referral_percent']);
		$this->setReferralAmount($row['referral_amount']);
		$this->setUdf1($row['udf1']);
		$this->setSkype($row['skype']);
		$this->setPhone($row['phone']);
		$this->setTotalSignups($row['total_signups']);
		$this->_record_exists = true;
		$this->_modified = false;
	}

	function getByProgram( $programid )
	{
		$query = "select * from Affiliate where program_id=?";
		$sth = $this->db->prepare( $query );
		$res = $this->db->execute($sth,array($programid));
		while( $row = $res->fetchRow(DB_FETCHMODE_ASSOC )) {
			$webmaster = new Webmaster;
			$webmaster->getByID( $row['webmaster_id'] );
			$ret[] = $webmaster;
		}

		return $ret;
	}

	function getAll()
	{
		$query = "select id from Webmaster";
		$sth = $this->db->prepare( $query );
		$res = $this->db->execute( $sth, array() );
		while( $row = $res->fetchRow( DB_FETCHMODE_ASSOC )) {
			$webmaster = new Webmaster;
			$webmaster->getByID( $row['id'] );
			$ret[] = $webmaster;
		}

		return $ret;
	}

	/*
	*this function will generate the next id
	*
	*@access private
	*/
	function _generateNextId()
	{
		return $this->db->nextId("Webmaster", true);
	}
	
	/**
	* check if the form submitted fields passed in are a current webmaster
	* check ssn-taxid
	* check email address
	* return '' if no errors, or return the string
	*
	*@param mixed array $_request 
	*@return mixed string
	*/
	function checkExistance($vars)
	{
		$error = '';
//		$res = $this->db->query("select id from Webmaster where ssn_taxid=?", array($vars['ssn_taxid']));
//		list($id) = $res->fetchRow();
//		if($id)
//			$error .= "SSN/Tax Id already exists ";	

// cshepher - 20070118 this function is duplicated in the affiliatelogin
//            checkExists method
//		if( $vars['username'] != '' ) {
//			$res = $this->db->query("select id from AffiliateLogin where username='".$vars['username']."'");
//			list($id) = $res->fetchRow();
//			if( $id )
//				$error .= "Affiliate Username already exists ";
//		}

// cshepher - 20070118 removed this check per matth			
//		$res = $this->db->query("select id from Webmaster where email=?", array($vars['email']));
//		list($id) = $res->fetchRow();
//		if($id)
//			$error .= ", Email already exists ";
			
		return $error;
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
	* this function will accept an array of affiliate id as the key and amount of payout as the value (from class Stats)
	* it will remove all 0 values, 
	* then it will get the webmaster info
	* if it is below the minimum_payout field it will ignore it
	* then it will create a new array where each value of the array is an assoc array with webmaster info
	*
	*@access public
	*@param mixed array
	*@return mixed array
	*/
	function getPayoutInfo($income)
	{
		$return = array();
		$affiliate = new Affiliate($this->db);
		foreach($income as $affiliate_id => $income_info)
		{
			$income = $income_info['total'];
			if($income <= 0)
				continue;
			if(!$affiliate_id)
				continue;
			$affiliate->getById($affiliate_id);
			
			if(!$affiliate->getWebmasterID())
				continue;
			
			$this->getById($affiliate->getWebmasterId());
			
			if(!$this->getMinimumPayout() || $this->getMinimumPayout() <= $income)
			{
				$t = array();
				$t['income'] = $income;
				$t['current_income'] = $income_info['current'];
				$t['rollover_income'] = $income_info['rollover'];
				$t['affiliate_id'] = $affiliate_id;
				$t['firstname'] = $this->getFirstName();
				$t['lastname'] = $this->getLastname();
				$t['pay_to'] = $this->getPayTo();
				$t['street_address'] = $this->getStreetAddress();
				$t['city'] = $this->getCity();
				$t['state'] = $this->getState();
				$t['country'] = $this->getCountry();
				$t['postal_code'] = $this->getPostalCode();
				$t['company'] = $this->getCompany();
				$t['payout_method'] = $this->getPaymentMethod();
				$t['notes'] = $this->getNotes();
				$t['udf1'] = $this->getUDF1();
				$t['skype'] = $this->getSkype();
				$t['phone'] = $this->getPhone();
				array_push($return, $t);	
			}
		}
		
		return $return;
	}
	/**
	* this function will read from the Affiliate table to find all the ids
	* with this webmasters ID
	*
	*@return mixed array of affiliate ids
	*/
	function getAffiliateIDS()
	{
		$res = $this->db->query("select id from Affiliate where webmaster_id=?", array($this->getId()));
		$return = array();
		while(list($id) = $res->fetchRow())
		{
			array_push($return, $id);
		}	
		return $return;
	}
	/**
	* this function will add 1 to total_signups without having to update the whole record
	*
	*@access public
	*/
	function add_signup()
	{
		if(!$this->getId())
			trigger_error("this webmaster object has nto been set", E_USER_ERROR);
			
		$res = $this->db->query("update Webmaster set total_signups=total_signups+1 where id=?", array($this->getId()));
	}
}

