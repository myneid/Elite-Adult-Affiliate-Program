<?php
/**
 * Table Definition for mpa3_sites
 */
require_once 'DB/DataObject.php';

class Mpa3_sites extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'mpa3_sites';                      // table name
    public $_database = 'old';                      // database name (used with database_{*} config)
    public $id;                              // int(11)  not_null primary_key auto_increment
    public $master_site;                     // int(11)  not_null multiple_key
    public $title;                           // string(100)  
    public $url;                             // string(255)  
    public $hit_url;                         // string(255)  
    public $postback_url;                    // string(255)  
    public $alternate_url;                   // string(255)  
    public $use_alternate;                   // int(4)  not_null
    public $mpush_cid;                       // string(255)  
    public $htpasswd;                        // string(255)  
    public $adp;                             // string(255)  
    public $welcome;                         // string(255)  
    public $deny;                            // string(255)  
    public $check_decline;                   // string(255)  
    public $members;                         // string(255)  
    public $active;                          // int(4)  not_null
    public $visible;                         // int(4)  not_null multiple_key
    public $deleted;                         // int(1)  not_null
    public $trials;                          // int(1)  not_null
    public $owner;                           // int(20)  not_null multiple_key
    public $overhead;                        // int(4)  not_null
    public $payout;                          // int(4)  not_null
    public $nb_access_key;                   // string(255)  
    public $gxb_site_id;                     // string(20)  
    public $netcash_site_id;                 // string(255)  
    public $commercegate_site_id;            // string(50)  
    public $dhd_site_id;                     // string(50)  
    public $localbilling_site_id;            // string(255)  
    public $phoneaccess_content_id;          // string(20)  
    public $pbp_package;                     // string(20)  
    public $pbp_layout;                      // string(20)  
    public $cml_product;                     // string(20)  not_null
    public $cml_banner;                      // string(255)  not_null
    public $niche;                           // int(11)  not_null
    public $default_console;                 // int(10)  not_null

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('Mpa3_sites',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
