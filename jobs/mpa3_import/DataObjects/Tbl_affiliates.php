<?php
/**
 * Table Definition for tbl_affiliates
 */
require_once 'DB/DataObject.php';

class Tbl_affiliates extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'tbl_affiliates';                  // table name
    var $_database = 'old';                  // database name (used with database_{*} config)
    var $affiliate_id;                    // int(11)  not_null primary_key auto_increment
    var $start_date;                      // date(10)  binary
    var $parent_id;                       // int(11)  
    var $checkname;                       // string(100)  
    var $first_name;                      // string(100)  
    var $last_name;                       // string(100)  
    var $address1;                        // string(100)  
    var $address2;                        // string(100)  
    var $city;                            // string(100)  
    var $state;                           // string(100)  
    var $zip;                             // string(100)  
    var $country;                         // int(11)  
    var $phone;                           // string(100)  
    var $email;                           // string(100)  
    var $site_url;                        // string(100)  
    var $ssn;                             // string(100)  
    var $password;                        // string(100)  
    var $username;                        // string(100)  
    var $traffic_opt;                     // int(4)  
    var $join_opt;                        // int(4)  
    var $active;                          // int(4)  multiple_key
    var $mode;                            // int(4)  
    var $t1_dollars;                      // int(11)  
    var $t2_percent;                      // int(11)  
    var $no_exit_sale;                    // int(11)  
    var $allow_t2_mailer_join;            // int(4)  
    var $last_referral;                   // date(10)  binary
    var $last_check;                      // real(13)  
    var $exits_off;                       // int(4)  
    var $last_program_change;             // date(10)  binary
    var $newsletter;                      // int(4)  
    var $pay_method;                      // string(100)  
    var $bank_name;                       // string(100)  
    var $acct_number;                     // string(100)  
    var $routing_number;                  // string(100)  
    var $mailer;                          // int(4)  
    var $item_percent;                    // real(13)  
    var $item_2_percent;                  // real(13)  

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('Tbl_affiliates',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
