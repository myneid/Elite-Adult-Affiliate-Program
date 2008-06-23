<?php
/**
 * Table Definition for tbl_orders
 */
require_once 'DB/DataObject.php';

class Tbl_orders extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'tbl_orders';                      // table name
    var $_database = 'old';                      // database name (used with database_{*} config)
    var $order_timestamp;                 // datetime(19)  not_null primary_key binary
    var $t1_seller;                       // int(11)  not_null primary_key
    var $t2_seller;                       // int(11)  not_null primary_key multiple_key
    var $t1_dollars;                      // int(4)  
    var $t2_percent;                      // int(4)  
    var $store_id;                        // string(6)  not_null primary_key
    var $optimized;                       // int(4)  
    var $subp;                            // string(100)  not_null primary_key
    var $biller;                          // string(100)  
    var $status;                          // string(50)  multiple_key
    var $amount;                          // real(13)  
    var $trans_id;                        // string(20)  not_null primary_key
    var $description;                     // string(255)  
    var $recurr;                          // int(4)  
    var $tempNetBilling;                  // string(3)  

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('Tbl_orders',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
