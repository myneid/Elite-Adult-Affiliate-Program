<?php
/**
 * Table Definition for tbl_consoles
 */
require_once 'DB/DataObject.php';

class Tbl_consoles extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'tbl_consoles';                    // table name
    var $_database = 'old';                    // database name (used with database_{*} config)
    var $console_id;                      // int(11)  not_null primary_key auto_increment
    var $console_name;                    // string(100)  
    var $console_url;                     // string(100)  
    var $console_delay;                   // real(22)  
    var $console_width;                   // int(11)  
    var $console_height;                  // int(11)  
    var $scrollbars;                      // int(4)  
    var $resizable;                       // int(4)  

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('Tbl_consoles',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
