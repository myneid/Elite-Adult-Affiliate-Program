<?php
/**
 * Table Definition for tbl_auto_reply
 */
require_once 'DB/DataObject.php';

class Tbl_auto_reply extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'tbl_auto_reply';                  // table name
    var $_database = 'old';                  // database name (used with database_{*} config)
    var $auto_reply_id;                   // int(11)  not_null primary_key auto_increment
    var $auto_reply_subject;              // string(200)  
    var $auto_reply_message_text;         // blob(65535)  blob
    var $auto_reply_message_html;         // blob(65535)  blob

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('Tbl_auto_reply',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
