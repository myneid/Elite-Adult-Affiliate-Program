<?php
/**
 * Table Definition for mpa3_transactions
 */
require_once 'DB/DataObject.php';

class Mpa3_transactions extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'mpa3_transactions';               // table name
    public $_database = 'old';               // database name (used with database_{*} config)
    public $id;                              // int(20)  not_null primary_key auto_increment
    public $transaction_id;                  // int(20)  multiple_key
    public $subscription_id;                 // string(40)  multiple_key
    public $member;                          // string(30)  
    public $trn_date;                        // date(10)  multiple_key binary
    public $processor;                       // string(25)  
    public $program;                         // int(4)  
    public $site;                            // int(11)  
    public $master_site;                     // int(11)  
    public $product;                         // int(11)  
    public $webmaster;                       // int(11)  
    public $webmaster_2tier;                 // int(20)  
    public $referrer;                        // string(127)  
    public $amount;                          // real(8)  
    public $free_trial;                      // int(4)  
    public $trial;                           // int(4)  
    public $full_price;                      // int(4)  
    public $conversion;                      // int(4)  
    public $rebill;                          // int(4)  
    public $chargeback;                      // int(4)  
    public $credit;                          // int(4)  not_null multiple_key
    public $partner_p;                       // real(6)  
    public $partner_2tier;                   // real(8)  
    public $signup_p;                        // real(8)  
    public $signup_2tier;                    // real(8)  
    public $active_ft_p;                     // real(8)  
    public $active_t_p;                      // real(8)  not_null
    public $active_fp_p;                     // real(8)  not_null
    public $active_c_p;                      // real(8)  not_null
    public $active_2tier;                    // real(8)  
    public $pppcard_p;                       // real(8)  
    public $pppcard_pp;                      // real(8)  
    public $fm;                              // int(4)  
    public $campaign;                        // int(20)  not_null
    public $tour;                            // int(20)  not_null
    public $processed;                       // int(4)  
    public $rw_processed;                    // int(1)  not_null

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('Mpa3_transactions',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
