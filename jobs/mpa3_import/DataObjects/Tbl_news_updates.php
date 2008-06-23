<?php
/**
 * Table Definition for tbl_news_updates
 */
require_once 'DB/DataObject.php';

class Tbl_news_updates extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'tbl_news_updates';                // table name
    var $_database = 'old';                // database name (used with database_{*} config)
    var $news_updates_id;                 // int(11)  not_null primary_key auto_increment
    var $news_updates;                    // blob(65535)  blob

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('Tbl_news_updates',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
