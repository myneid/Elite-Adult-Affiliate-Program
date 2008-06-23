<?php
/**
 * Table Definition for tbl_mailer_emails
 */
require_once 'DB/DataObject.php';

class Tbl_mailer_emails extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'tbl_mailer_emails';               // table name
    var $_database = 'old';               // database name (used with database_{*} config)
    var $mailer_id;                       // int(11)  not_null primary_key auto_increment
    var $mailer_name;                     // string(100)  
    var $mailer_type;                     // string(25)  
    var $mailer_text;                     // blob(65535)  blob
    var $mailer_image_path;               // string(25)  
    var $store_id;                        // int(11)  
    var $active;                          // int(4)  

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('Tbl_mailer_emails',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
