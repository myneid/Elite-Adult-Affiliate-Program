<?php
/**
 * Table Definition for Webmaster_seq
 */
require_once 'DB/DataObject.php';

class Webmaster_seq extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'Webmaster_seq';                   // table name
    var $_database = 'new';                   // database name (used with database_{*} config)
    var $id;                              // int(10)  not_null primary_key unsigned auto_increment

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('Webmaster_seq',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
