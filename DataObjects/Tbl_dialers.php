<?php
/**
 * Table Definition for tbl_dialers
 */
require_once 'DB/DataObject.php';

class Tbl_dialers extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'tbl_dialers';                     // table name
    var $_database = 'old';                     // database name (used with database_{*} config)
    var $dialer_id;                       // int(11)  not_null primary_key auto_increment
    var $dialer_name;                     // string(100)  
    var $dialer_url;                      // string(100)  

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('Tbl_dialers',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
