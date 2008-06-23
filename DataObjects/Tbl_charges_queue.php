<?php
/**
 * Table Definition for tbl_charges_queue
 */
require_once 'DB/DataObject.php';

class Tbl_charges_queue extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'tbl_charges_queue';               // table name
    var $_database = 'old';               // database name (used with database_{*} config)
    var $Charge_queue_ID;                 // int(20)  not_null primary_key auto_increment
    var $Charge_schedule_ID;              // int(20)  
    var $FLIX_MEMBER_ID;                  // int(20)  
    var $Due_Date;                        // datetime(19)  binary
    var $Amount;                          // real(22)  
    var $Member_ID;                       // int(20)  

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('Tbl_charges_queue',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
