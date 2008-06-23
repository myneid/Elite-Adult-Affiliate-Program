<?php

require_once 'PEAR.php';
require_once 'classAffiliateProgramDB.inc.php';

/**
 * short description of class
 *
 * long description of class
 *
 * @author Tanguy de Courson <tanguy@0x7a69.net>
 * @author Derek Volker <dvolker@0x7a69.net>
 * @version .9b
 * @access public
 * @package Mailer
*/

class Wire_Info extends PEAR
{
	var $id;
	var $webmaster_id;
	var $full_name;
	var $phone_number;
	var $bank_name;
	var $bank_city;
	var $bank_country;
	var $bank_swift;
	var $bank_aba;
	var $bank_phone_number;
	var $account_number;
	var $intermediary_bank_name;
	var $intermediary_bank_city;
	var $intermediary_bank_country;
	var $intermediary_bank_swift;
	var $intermediary_bank_aba;
	var $intermediary_account_number;
	var $other;
	
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
	function Wire_Info($db = false)
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
	function _Wire_Info()
	{
		if($this->_modified)
			$this->_update();
	}

	function setID($id)
	{
		$this->_modified = true;
		$this->id = $id;
	}
	function setWebmasterID($webmaster_id)
	{
		$this->_modified = true;
		$this->webmaster_id = $webmaster_id;
	}
	function setFullName( $full_name )
	{
		$this->_modified = true;
		$this->full_name = $full_name;
	}
	function setPhoneNumber( $phone_number )
	{
		$this->_modified = true;
		$this->phone_number = $phone_number;
	}
	function setBankName( $bank_name )
	{
		$this->_modified = true;
		$this->bank_name = $bank_name;
	}
	function setBankCity( $bank_city )
	{
		$this->_modified = true;
		$this->bank_city = $bank_city;
	}
	function setBankCountry( $bank_country )
	{
		$this->_modified = true;
		$this->bank_country = $bank_country;
	}
	function setBankSWIFT( $bank_swift )
	{
		$this->_modified = true;
		$this->bank_swift = $bank_swift;
	}
	function setBankABA( $bank_aba )
	{
		$this->_modified = true;
		$this->bank_aba = $bank_aba;
	}
	function setBankPhoneNumber( $bank_phone_number )
	{
		$this->_modified = true;
		$this->bank_phone_number = $bank_phone_number;
	}
	function setAccountNumber( $account_number )
	{
		$this->_modified = true;
		$this->account_number = $account_number;
	}
	function setIntermediaryBankName( $intermediary_bank_name )
	{
		$this->_modified = true;
		$this->intermediary_bank_name = $intermediary_bank_name;
	}
	function setIntermediaryBankCity( $intermediary_bank_city )
	{
		$this->_modified = true;
		$this->intermediary_bank_city = $intermediary_bank_city;
	}
	function setIntermediaryBankCountry( $intermediary_bank_country )
	{
		$this->_modified = true;
		$this->intermediary_bank_country = $intermediary_bank_country;
	}
	function setIntermediaryBankSWIFT( $intermediary_bank_swift )
	{
		$this->_modified = true;
		$this->intermediary_bank_swift = $intermediary_bank_swift;
	}
	function setIntermediaryBankABA( $intermediary_bank_aba )
	{
		$this->_modified = true;
		$this->intermediary_bank_aba = $intermediary_bank_aba;
	}
	function setIntermediaryAccountNumber( $intermediary_account_number )
	{
		$this->_modified = true;
		$this->intermediary_account_number = $intermediary_account_number;
	}
	function setOther( $other )
	{
		$this->_modified = true;
		$this->other = $other;
	}

	function getID()
	{
		return $this->id;
	}
	function getWebmasterID()
	{
		return $this->webmaster_id;
	}
	function getFullName()
	{
		return $this->full_name;
	}
	function getPhoneNumber()
	{
		return $this->phone_number;
	}
	function getBankName()
	{
		return $this->bank_name;
	}
	function getBankCity()
	{
		return $this->bank_city;
	}
	function getBankCountry()
	{
		return $this->bank_country;
	}
	function getBankSWIFT()
	{
		return $this->bank_swift;
	}
	function getBankABA()
	{
		return $this->bank_aba;
	}
	function getBankPhoneNumber()
	{
		return $this->bank_phone_number;
	}
	function getAccountNumber()
	{
		return $this->account_number;
	}
	function getIntermediaryBankName()
	{
		return $this->intermediary_bank_name;
	}
	function getIntermediaryBankCity()
	{
		return $this->intermediary_bank_city;
	}
	function getIntermediaryBankCountry()
	{
		return $this->intermediary_bank_country;
	}
	function getIntermediaryBankSWIFT()
	{
		return $this->intermediary_bank_swift;
	}
	function getIntermediaryBankABA()
	{
		return $this->intermediary_bank_aba;
	}
	function getIntermediaryAccountNumber()
	{
		return $this->intermediary_account_number;
	}
	function getOther()
	{
		return $this->other;
	}

	function _update()
	{
		$query = '';
		$valueArray = array();
		if($this->_record_exists)
		{
			//update
			$query = "update wire_info set webmaster_id=?,Full_Name=?,Phone_Number=?,Bank_Name=?,Bank_City=?,Bank_Country=?,Bank_SWIFT=?,Bank_ABA=?,Bank_Phone_Number=?,Account_Number=?,Intermediary_Bank_Name=?,Intermediary_Bank_City=?,Intermediary_Bank_Country=?,Intermediary_Bank_SWIFT=?,Intermediary_Bank_ABA=?,Intermediary_Account_Number=?,Other=? where id=?";
			$valueArray = array( $this->getWebmasterID(), $this->getFullName(), $this->getPhoneNumber(), $this->getBankName(), $this->getBankCity(), $this->getBankCountry(), $this->getBankSWIFT(), $this->getBankABA(), $this->getBankPhoneNumber(), $this->getAccountNumber(), $this->getIntermediaryBankName(), $this->getIntermediaryBankCity(), $this->getIntermediaryBankCountry(), $this->getIntermediaryBankSWIFT(), $this->getIntermediaryBankABA(), $this->getIntermediaryAccountNumber(), $this->getOther(), $this->getID() );
		}
		else
		{
			// insert
			$query = "insert into wire_info( webmaster_id, Full_Name, Phone_Number, Bank_Name, Bank_City, Bank_Country, Bank_SWIFT, Bank_ABA, Bank_Phone_Number, Account_Number, Intermediary_Bank_Name, Intermediary_Bank_City, Intermediary_Bank_Country, Intermediary_Bank_SWIFT, Intermediary_Bank_ABA, Intermediary_Account_Number, Other ) values( ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
			$valueArray = array( $this->getWebmasterID(), $this->getFullName(), $this->getPhoneNumber(), $this->getBankName(), $this->getBankCity(), $this->getBankCountry(), $this->getBankSWIFT(), $this->getBankABA(), $this->getBankPhoneNumber(), $this->getAccountNumber(), $this->getIntermediaryBankName(), $this->getIntermediaryBankCity(), $this->getIntermediaryBankCountry(), $this->getIntermediaryBankSWIFT(), $this->getIntermediaryBankABA(), $this->getIntermediaryAccountNumber(), $this->getOther() );
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
	function getByWebmasterID( $webmaster_id )
	{
		$query = "select * from wire_info where webmaster_id=?";
		$sth = $this->db->prepare($query);
		$res = $this->db->execute($sth, array( $webmaster_id ));

		if( $row = $res->fetchRow(DB_FETCHMODE_ASSOC)) {

		$this->setID( $row['id'] );
		$this->setWebmasterID( $row['webmaster_id'] );
		$this->setFullName( $row['Full_Name'] );
		$this->setPhoneNumber( $row['Phone_Number'] );
		$this->setBankName( $row['Bank_Name'] );
		$this->setBankCity( $row['Bank_City'] );
		$this->setBankCountry( $row['Bank_Country'] );
		$this->setBankSWIFT( $row['Bank_SWIFT'] );
		$this->setBankABA( $row['Bank_ABA'] );
		$this->setBankPhoneNumber( $row['Bank_Phone_Number'] );
		$this->setAccountNumber( $row['Account_Number'] );
		$this->setIntermediaryBankName( $row['Intermediary_Bank_Name'] );
		$this->setIntermediaryBankCity( $row['Intermediary_Bank_City'] );
		$this->setIntermediaryBankCountry( $row['Intermediary_Bank_Country'] );
		$this->setIntermediaryBankSWIFT( $row['Intermediary_Bank_SWIFT'] );
		$this->setIntermediaryBankABA( $row['Intermediary_Bank_ABA'] );
		$this->setIntermediaryAccountNumber( $row['Intermediary_Account_Number'] );
		$this->setOther( $row['Other'] );
		$this->_record_exists = true;
		$this->_modified = false;
		} else {
			$this->_record_exists = false;
		}
	}
}

?>
