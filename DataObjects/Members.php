<?php
/**
 * Table Definition for members
 */
require_once 'DB/DataObject.php';

class Members extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'members';                         // table name
    var $_database = 'new';                         // database name (used with database_{*} config)
    var $ID;                              // int(11)  not_null primary_key auto_increment
    var $Username;                        // string(32)  multiple_key
    var $Password;                        // string(32)  
    var $Full_Name;                       // string(32)  
    var $Email;                           // string(30)  
    var $Address;                         // string(50)  
    var $City;                            // string(30)  
    var $Zip;                             // string(10)  
    var $State;                           // string(30)  
    var $Country;                         // string(50)  
    var $Date;                            // date(10)  binary
    var $Exp_date;                        // date(10)  binary
    var $Status;                          // string(15)  
    var $SiteID;                          // int(11)  multiple_key
    var $Referred_by;                     // string(12)  
    var $mx_record;                       // string(255)  
    var $mailer_status;                   // int(11)  not_null
    var $mx_retrieved_at;                 // datetime(19)  binary
    var $customer_id;                     // int(11)  
    var $ip_address;                      // string(15)  
    var $sale_id;                         // int(11)  

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('Members',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
