<?php
/**
 * Table Definition for tbl_summary
 */
require_once 'DB/DataObject.php';

class Tbl_summary extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'tbl_summary';                     // table name
    var $_database = 'old';                     // database name (used with database_{*} config)
    var $summary_date;                    // date(10)  not_null primary_key binary
    var $unique_visitor;                  // int(11)  
    var $t1_payout;                       // real(13)  
    var $t2_payout;                       // real(13)  
    var $t1_sales;                        // int(11)  
    var $t2_sales;                        // int(11)  
    var $joins;                           // int(11)  
    var $affiliate_id;                    // int(11)  not_null primary_key
    var $store_id;                        // int(11)  not_null primary_key
    var $projected;                       // int(11)  

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('Tbl_summary',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
