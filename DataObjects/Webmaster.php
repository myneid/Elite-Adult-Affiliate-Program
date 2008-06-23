<?php
/**
 * Table Definition for Webmaster
 */
require_once 'DB/DataObject.php';

class Webmaster extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'Webmaster';                       // table name
    var $_database = 'new';                       // database name (used with database_{*} config)
    var $id;                              // int(11)  not_null primary_key auto_increment
    var $firstname;                       // string(32)  
    var $lastname;                        // string(64)  
    var $ssn_taxid;                       // string(15)  
    var $street_address;                  // string(128)  
    var $postal_code;                     // string(16)  
    var $city;                            // string(64)  
    var $state;                           // string(64)  
    var $country;                         // string(3)  
    var $email;                           // string(128)  
    var $referred_webmaster_id;           // int(11)  multiple_key
    var $aim;                             // string(16)  
    var $icq;                             // string(16)  
    var $company;                         // string(64)  
    var $pay_to;                          // string(64)  
    var $minimum_payout;                  // real(12)  
    var $payment_method;                  // string(16)  
    var $notes;                           // blob(65535)  blob
    var $referral_percent;                // int(11)  
    var $total_signups;                   // int(11)  
    var $udf1;                            // string(255)  

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('Webmaster',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
