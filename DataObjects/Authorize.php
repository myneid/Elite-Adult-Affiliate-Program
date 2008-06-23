<?php
/**
 * Table Definition for authorize
 */
require_once 'DB/DataObject.php';

class Authorize extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'authorize';                       // table name
    var $_database = 'new';                       // database name (used with database_{*} config)
    var $Date;                            // datetime(19)  binary
    var $Username;                        // string(12)  multiple_key
    var $IP;                              // string(16)  
    var $Status;                          // int(1)  
    var $hits;                            // int(11)  

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('Authorize',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
