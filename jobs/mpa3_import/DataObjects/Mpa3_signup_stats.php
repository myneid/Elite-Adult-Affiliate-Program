<?php
/**
 * Table Definition for mpa3_signup_stats
 */
require_once 'DB/DataObject.php';

class Mpa3_signup_stats extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'mpa3_signup_stats';               // table name
    public $_database = 'old';               // database name (used with database_{*} config)
    public $idx;                             // int(20)  not_null primary_key auto_increment
    public $date;                            // date(10)  not_null multiple_key binary
    public $site;                            // int(11)  not_null
    public $master_site;                     // int(11)  not_null multiple_key
    public $webmaster;                       // int(20)  not_null multiple_key
    public $uniques;                         // int(20)  not_null
    public $free_trials;                     // int(11)  not_null
    public $trials;                          // int(11)  not_null
    public $full_price;                      // int(11)  not_null
    public $conversions;                     // int(11)  not_null
    public $rebills;                         // int(11)  not_null
    public $chargebacks;                     // real(12)  not_null
    public $chargebacks_count;               // int(11)  not_null
    public $credits;                         // real(12)  not_null
    public $credits_count;                   // int(11)  not_null
    public $payout;                          // real(12)  not_null
    public $fm;                              // int(4)  not_null
    public $campaign;                        // int(20)  not_null multiple_key

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('Mpa3_signup_stats',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
