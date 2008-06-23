<?php
/**
 * Table Definition for wire_info
 */
require_once 'DB/DataObject.php';

class Wire_info extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'wire_info';                       // table name
    var $_database = 'new';                       // database name (used with database_{*} config)
    var $id;                              // int(11)  not_null primary_key auto_increment
    var $webmaster_id;                    // int(11)  not_null multiple_key
    var $Full_Name;                       // string(60)  
    var $Phone_Number;                    // string(20)  
    var $Bank_Name;                       // string(100)  
    var $Bank_City;                       // string(30)  
    var $Bank_Country;                    // string(50)  
    var $Bank_SWIFT;                      // string(30)  
    var $Bank_ABA;                        // string(40)  
    var $Bank_Phone_Number;               // string(20)  
    var $Account_Number;                  // string(40)  
    var $Intermediary_Bank_Name;          // string(100)  
    var $Intermediary_Bank_City;          // string(30)  
    var $Intermediary_Bank_Country;       // string(50)  
    var $Intermediary_Bank_SWIFT;         // string(30)  
    var $Intermediary_Bank_ABA;           // string(40)  
    var $Intermediary_Account_Number;     // string(40)  
    var $Other;                           // blob(65535)  blob

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('Wire_info',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
