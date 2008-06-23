<?php
/**
 * Table Definition for Hit
 */
require_once 'DB/DataObject.php';

class Hit extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'Hit';                             // table name
    var $_database = 'new';                             // database name (used with database_{*} config)
    var $id;                              // int(11)  not_null primary_key auto_increment
    var $datetime;                        // datetime(19)  multiple_key binary
    var $affiliate_id;                    // int(11)  multiple_key
    var $hit_type;                        // string(32)  
    var $ipaddress;                       // string(15)  
    var $browser;                         // string(128)  
    var $referring_url;                   // string(255)  
    var $site_id;                         // int(11)  
    var $uniq;                            // int(1)  
    var $program_id;                      // int(11)  

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('Hit',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
