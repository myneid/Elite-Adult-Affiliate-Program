<?php
/**
 * Table Definition for AffiliateLogin
 */
require_once 'DB/DataObject.php';

class AffiliateLogin extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'AffiliateLogin';                  // table name
    var $_database = 'new';                  // database name (used with database_{*} config)
    var $id;                              // int(11)  not_null primary_key auto_increment
    var $username;                        // string(32)  multiple_key
    var $password;                        // string(32)  
    var $affiliate_id;                    // int(11)  
    var $session_id;                      // string(128)  multiple_key

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('AffiliateLogin',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
