<?php
/**
 * Table Definition for mpa3_payout
 */
require_once 'DB/DataObject.php';

class Mpa3_payout extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'mpa3_payout';                     // table name
    public $_database = 'old';                     // database name (used with database_{*} config)
    public $id;                              // int(10)  not_null primary_key auto_increment
    public $check_id;                        // int(10)  
    public $webmaster;                       // int(10)  not_null
    public $first_date;                      // date(10)  not_null binary
    public $start_date;                      // date(10)  not_null binary
    public $end_date;                        // date(10)  not_null binary
    public $payout;                          // real(8)  not_null
    public $payment_method;                  // string(12)  not_null
    public $min_payout;                      // int(5)  not_null

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('Mpa3_payout',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
