<?php
/**
 * Table Definition for Site
 */
require_once 'DB/DataObject.php';

class Site extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'Site';                            // table name
    var $_database = 'new';                            // database name (used with database_{*} config)
    var $id;                              // int(11)  not_null primary_key auto_increment
    var $name;                            // string(32)  
    var $description;                     // string(128)  
    var $mainurl;                         // string(128)  
    var $membersurl;                      // string(128)  
    var $joinurl;                         // string(128)  
    var $ext_siteid;                 // int(9)  

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('Site',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
