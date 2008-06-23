<?php
/**
 * Table Definition for EpochTransStats
 */
require_once 'DB/DataObject.php';

class EpochTransStats extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'EpochTransStats';                 // table name
    var $_database = 'new';                 // database name (used with database_{*} config)
    var $ets_transaction_id;              // int(11)  not_null primary_key
    var $ets_member_idx;                  // int(11)  not_null
    var $ets_transaction_date;            // datetime(19)  multiple_key binary
    var $ets_transaction_type;            // string(1)  not_null multiple_key
    var $ets_co_code;                     // string(6)  not_null
    var $ets_pi_code;                     // string(32)  not_null multiple_key
    var $ets_reseller_code;               // string(64)  multiple_key
    var $ets_transaction_amount;          // real(12)  not_null
    var $ets_payment_type;                // string(1)  
    var $ets_username;                    // string(32)  
    var $ets_password;                    // string(32)  
    var $ets_email;                       // string(64)  
    var $ets_ref_trans_ids;               // int(11)  
    var $ets_password_expire;             // string(20)  

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('EpochTransStats',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
