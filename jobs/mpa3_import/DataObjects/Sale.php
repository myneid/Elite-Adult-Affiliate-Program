<?php
/**
 * Table Definition for Sale
 */
require_once 'DB/DataObject.php';

class Sale extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'Sale';                            // table name
    var $_database = 'new';                            // database name (used with database_{*} config)
    var $id;                              // int(11)  not_null primary_key auto_increment
    var $datetime;                        // datetime(19)  multiple_key binary
    var $affiliate_id;                    // int(11)  multiple_key
    var $ipaddress;                       // string(15)  
    var $amount;                          // real(12)  
    var $type;                            // string(32)  
    var $hits_id;                         // int(11)  
    var $affiliate_payout;                // real(12)  
    var $scale_id;                        // int(11)  
    var $processor_id;                    // int(4)  
    var $site_id;                         // int(11)  
    var $transaction_id;                  // string(32)  
    var $member_id;                       // int(11)  
    var $notes;                           // int(11)  

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('Sale',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
