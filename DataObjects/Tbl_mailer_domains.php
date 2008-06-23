<?php
/**
 * Table Definition for tbl_mailer_domains
 */
require_once 'DB/DataObject.php';

class Tbl_mailer_domains extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'tbl_mailer_domains';              // table name
    var $_database = 'old';              // database name (used with database_{*} config)
    var $domain_id;                       // int(11)  not_null primary_key auto_increment
    var $domain_url;                      // string(100)  
    var $domain_status;                   // string(100)  
    var $domain_default_document;         // string(100)  
    var $domain_optout_url;               // string(100)  
    var $domain_product_string;           // string(255)  
    var $server_id;                       // int(11)  
    var $active;                          // int(4)  

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('Tbl_mailer_domains',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
