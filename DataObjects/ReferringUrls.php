<?php
/**
 * Table Definition for Site
 */
require_once 'DB/DataObject.php';

class ReferringUrls extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'ReferringUrls';                            // table name
    var $_database = 'new';                            // database name (used with database_{*} config)
    var $id;                              // int(11)  not_null primary_key auto_increment
    var $referring_url;                            // string(32)  
    var $isSe;                     // string(128)  
    

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('ReferringUrls',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
