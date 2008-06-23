<?php
/**
 * Table Definition for tbl_charge_schedule
 */
require_once 'DB/DataObject.php';

class Tbl_charge_schedule extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'tbl_charge_schedule';             // table name
    var $_database = 'old';             // database name (used with database_{*} config)
    var $Charge_Schedule_ID;              // int(11)  not_null primary_key auto_increment
    var $Billing_type_ID;                 // int(11)  multiple_key
    var $Time_increment_hrs;              // real(22)  
    var $Time_increment_monthly;          // int(11)  
    var $recurring;                       // int(1)  
    var $amount;                          // real(22)  
    var $order_sequence;                  // int(11)  

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('Tbl_charge_schedule',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
