<?php
/**
 * Table Definition for tbl_temp
 */
require_once 'DB/DataObject.php';

class Tbl_temp extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'tbl_temp';                        // table name
    var $_database = 'old';                        // database name (used with database_{*} config)
    var $id;                              // int(11)  not_null primary_key auto_increment
    var $query;                           // blob(65535)  blob

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('Tbl_temp',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
