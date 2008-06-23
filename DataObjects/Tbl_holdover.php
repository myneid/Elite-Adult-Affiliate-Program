<?php
/**
 * Table Definition for tbl_holdover
 */
require_once 'DB/DataObject.php';

class Tbl_holdover extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'tbl_holdover';                    // table name
    var $_database = 'old';                    // database name (used with database_{*} config)
    var $holdover_id;                     // int(11)  not_null primary_key auto_increment
    var $affiliate_id;                    // int(11)  
    var $holdover_date;                   // date(10)  binary
    var $holdover_total;                  // real(13)  

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('Tbl_holdover',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
