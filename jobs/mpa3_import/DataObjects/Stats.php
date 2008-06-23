<?php
/**
 * Table Definition for Stats
 */
require_once 'DB/DataObject.php';

class Stats extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'Stats';                           // table name
    var $_database = 'new';                           // database name (used with database_{*} config)
    var $id;                              // int(11)  not_null primary_key auto_increment
    var $affiliate_id;                    // int(11)  multiple_key
    var $date;                            // date(10)  binary
    var $hits;                            // int(11)  
    var $uniques;                         // int(11)  
    var $signups;                         // int(11)  
    var $cancels;                         // int(11)  
    var $chargebacks;                     // int(11)  
    var $renewals;                        // int(11)  
    var $scale_id;                        // int(11)  
    var $income;                          // real(12)  
    var $referral_income;                 // real(12)  
    var $paid;                            // int(1)  
    var $payout_date;                     // date(10)  binary

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('Stats',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
