<?php
/**
 * Table Definition for MemberCancelStats
 */
require_once 'DB/DataObject.php';

class MemberCancelStats extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'MemberCancelStats';               // table name
    var $_database = 'new';               // database name (used with database_{*} config)
    var $mcs_or_idx;                      // int(11)  not_null primary_key
    var $mcs_canceldate;                  // datetime(19)  multiple_key binary
    var $mcs_signupdate;                  // datetime(19)  multiple_key binary
    var $mcs_cocode;                      // string(16)  not_null
    var $mcs_picode;                      // string(32)  not_null
    var $mcs_reseller;                    // string(32)  
    var $mcs_reason;                      // string(64)  
    var $mcs_memberstype;                 // string(1)  
    var $mcs_username;                    // string(32)  
    var $mcs_email;                       // string(64)  
    var $mcs_passwordremovaldate;         // datetime(19)  multiple_key binary

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('MemberCancelStats',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
