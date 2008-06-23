<?php
/**
 * Table Definition for netbillingdata
 */
require_once 'DB/DataObject.php';

class Netbillingdata extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'netbillingdata';                  // table name
    var $_database = 'old';                  // database name (used with database_{*} config)
    var $Ecom_Ezic_AccountAndSitetag;     // string(50)  
    var $Ecom_Ezic_Security_HashValue_MD5;    // string(50)  
    var $Ecom_Ezic_Membership_ID;         // string(15)  not_null primary_key multiple_key
    var $Ecom_Ezic_Payment_AuthorizationType;    // string(15)  
    var $Ecom_Ezic_TransactionId;         // string(15)  multiple_key
    var $Ecom_Ezic_Recurring_Period;      // string(4)  
    var $Ecom_Ezic_ProofOfPurchase_MD5;    // string(20)  
    var $Ecom_Ezic_Security_HashFields;    // string(50)  
    var $Ecom_Ezic_Membership_UserName;    // string(50)  not_null primary_key
    var $Ecom_Ezic_Membership_Period;     // string(3)  
    var $Ecom_Ezic_Recurring_Amount;      // string(9)  
    var $Ecom_Ezic_Membership_PassWord;    // string(50)  
    var $Ecom_Ezic_Recurring_ID;          // string(15)  
    var $Ecom_Ezic_TransactionStatus;     // string(2)  
    var $Ecom_Ezic_Response_IssueDate;    // datetime(19)  binary
    var $Ecom_Ezic_Response_StatusSubCode;    // string(50)  
    var $Ecom_Ezic_Response_AuthCode;     // string(15)  
    var $Ecom_Ezic_Response_TransactionID;    // string(15)  
    var $Ecom_Ezic_Response_StatusCode;    // string(3)  
    var $Ecom_Ezic_Response_Card_VerificationCode;    // string(3)  
    var $Ecom_Ezic_Response_Card_AVSCode;    // string(3)  
    var $Ecom_Ezic_Response_AuthMessage;    // string(50)  
    var $Ecom_BillTo_Postal_StateProv;    // string(3)  
    var $Ecom_BillTo_Online_Email;        // string(75)  
    var $Ecom_BillTo_Postal_PostalCode;    // string(15)  
    var $Ecom_BillTo_Postal_City;         // string(50)  
    var $Ecom_BillTo_Postal_CountryCode;    // string(50)  
    var $Ecom_BillTo_Postal_Name_Last;    // string(50)  
    var $Ecom_BillTo_Postal_Name_First;    // string(50)  
    var $Ecom_BillTo_Postal_Street_Line1;    // string(125)  
    var $Ecom_Cost_Total;                 // string(9)  
    var $Ecom_Receipt_Description;        // string(125)  
    var $Ecom_BillTo_Postal_Street_Line2;    // string(125)  
    var $ID;                              // int(20)  not_null primary_key auto_increment
    var $AID;                             // string(20)  
    var $Store_ID;                        // string(20)  

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('Netbillingdata',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
