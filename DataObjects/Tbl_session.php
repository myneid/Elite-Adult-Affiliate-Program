<?php
/**
 * Table Definition for tbl_session
 */
require_once 'DB/DataObject.php';

class Tbl_session extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'tbl_session';                     // table name
    var $_database = 'old';                     // database name (used with database_{*} config)
    var $session;                         // string(8)  not_null primary_key
    var $LastAction;                      // datetime(19)  binary
    var $username;                        // string(100)  
    var $password;                        // string(100)  

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('Tbl_session',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
