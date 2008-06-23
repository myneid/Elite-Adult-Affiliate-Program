<?php
/**
 * Table Definition for APConfig
 */
require_once 'DB/DataObject.php';

class APConfig extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'APConfig';                        // table name
    var $_database = 'new';                        // database name (used with database_{*} config)
    var $id;                              // int(11)  not_null primary_key auto_increment
    var $name;                            // string(64)  
    var $value;                           // string(255)  
    var $description;                     // string(255)  

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('APConfig',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
