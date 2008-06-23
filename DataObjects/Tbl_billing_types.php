<?php
/**
 * Table Definition for tbl_billing_types
 */
require_once 'DB/DataObject.php';

class Tbl_billing_types extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'tbl_billing_types';               // table name
    var $_database = 'old';               // database name (used with database_{*} config)
    var $Billing_type_id;                 // int(11)  not_null primary_key auto_increment
    var $Description;                     // string(200)  
    var $ShortDescription;                // string(100)  

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('Tbl_billing_types',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
