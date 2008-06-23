<?php
/**
 * Table Definition for Affiliate
 */
require_once 'DB/DataObject.php';

class Affiliate extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'Affiliate';                       // table name
    var $_database = 'new';                       // database name (used with database_{*} config)
    var $id;                              // int(11)  not_null primary_key auto_increment
    var $webmaster_id;                    // int(11)  multiple_key
    var $program_id;                      // int(11)  
    var $status;                          // string(13)  enum

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('Affiliate',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
