<?php
/**
 * Table Definition for tbl_categories
 */
require_once 'DB/DataObject.php';

class Tbl_categories extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'tbl_categories';                  // table name
    var $_database = 'old';                  // database name (used with database_{*} config)
    var $category_id;                     // int(11)  not_null primary_key auto_increment
    var $category_name;                   // string(100)  
    var $active;                          // int(4)  not_null primary_key

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('Tbl_categories',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
