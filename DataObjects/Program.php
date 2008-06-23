<?php
/**
 * Table Definition for Program
 */
require_once 'DB/DataObject.php';

class Program extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'Program';                         // table name
    var $_database = 'new';                         // database name (used with database_{*} config)
    var $id;                              // int(11)  not_null primary_key auto_increment
    var $name;                            // string(32)  
    var $description;                     // string(128)  
    var $scale_affiliate_id;              // int(11)  

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('Program',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
