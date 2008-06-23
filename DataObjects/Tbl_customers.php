<?php
/**
 * Table Definition for tbl_customers
 */
require_once 'DB/DataObject.php';

class Tbl_customers extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'tbl_customers';                   // table name
    var $_database = 'old';                   // database name (used with database_{*} config)
    var $email;                           // string(100)  not_null primary_key

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('Tbl_customers',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
