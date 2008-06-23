<?php
/**
 * Table Definition for tbl_banners
 */
require_once 'DB/DataObject.php';

class Tbl_banners extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'tbl_banners';                     // table name
    var $_database = 'old';                     // database name (used with database_{*} config)
    var $banner_id;                       // int(11)  not_null primary_key auto_increment
    var $banner_url;                      // string(100)  
    var $banner_type;                     // int(11)  not_null primary_key multiple_key
    var $banner_status;                   // int(4)  not_null primary_key
    var $store_id;                        // int(11)  not_null primary_key

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('Tbl_banners',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
