<?php
/**
 * Table Definition for tbl_payouts
 */
require_once 'DB/DataObject.php';

class Tbl_payouts extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'tbl_payouts';                     // table name
    var $_database = 'old';                     // database name (used with database_{*} config)
    var $payout_id;                       // int(11)  not_null primary_key auto_increment
    var $affiliate_id;                    // int(11)  
    var $amount;                          // real(13)  
    var $payout_date;                     // date(10)  binary

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('Tbl_payouts',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
