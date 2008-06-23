<?php
/**
 * Table Definition for mpa3_active_stats
 */
require_once 'DB/DataObject.php';

class Mpa3_active_stats extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'mpa3_active_stats';                      // table name
    public $_database = 'old';                      // database name (used with database_{*} config)
    public $id;                              // int(11)  not_null primary_key auto_increment
    public $date;
    public $site;
    public $master_site;                     // int(11)  not_null multiple_key
    public $webmaster;
    public $uniques;
    public $free_trials;
    public $trials;
    public $full_price;
    public $conversions;
    public $rebills;
    public $chargebacks;
    public $chargebacks_count;
    public $credits;
    public $credits_count;
    public $payout;
    public $fm;
    public $campaign;

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('Mpa3_active_stats',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
