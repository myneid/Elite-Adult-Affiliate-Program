<?php
/**
 * Table Definition for tbl_config
 */
require_once 'DB/DataObject.php';

class Tbl_config extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'tbl_config';                      // table name
    var $_database = 'old';                      // database name (used with database_{*} config)
    var $config_id;                       // int(11)  not_null primary_key auto_increment
    var $main_name;                       // string(100)  
    var $email;                           // string(100)  
    var $default_traffic_opt;             // int(4)  
    var $default_join_opt;                // int(4)  
    var $min_payout;                      // int(11)  
    var $last_query_success;              // datetime(19)  binary
    var $default_t1_dollars;              // int(11)  
    var $default_t2_percent;              // int(11)  
    var $default_no_exit;                 // int(11)  
    var $default_item_percent;            // real(13)  
    var $default_item_2_percent;          // real(13)  
    var $no_exit_sale;                    // int(11)  
    var $mailer_active;                   // int(4)  
    var $quova_on;                        // int(4)  
    var $auto_reply_active;               // int(4)  
    var $topsites;                        // string(100)  
    var $newsites;                        // string(50)  
    var $resources_updated;               // datetime(19)  binary
    var $scrub_updated;                   // datetime(19)  binary
    var $optout_updated;                  // date(10)  binary

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('Tbl_config',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
