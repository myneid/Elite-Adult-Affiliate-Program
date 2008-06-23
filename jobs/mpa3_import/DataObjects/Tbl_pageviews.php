<?php
/**
 * Table Definition for tbl_pageviews
 */
require_once 'DB/DataObject.php';

class Tbl_pageviews extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'tbl_pageviews';                   // table name
    var $_database = 'old';                   // database name (used with database_{*} config)
    var $pv_page;                         // string(100)  not_null primary_key
    var $pv_count;                        // int(11)  
    var $pv_date;                         // date(10)  not_null primary_key binary
    var $affiliate_id;                    // int(11)  not_null primary_key
    var $store_id;                        // int(4)  not_null primary_key

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('Tbl_pageviews',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
