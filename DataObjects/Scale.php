<?php
/**
 * Table Definition for Scale
 */
require_once 'DB/DataObject.php';

class Scale extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'Scale';                           // table name
    var $_database = 'new';                           // database name (used with database_{*} config)
    var $id;                              // int(11)  not_null primary_key auto_increment
    var $affiliate_id;                    // string(32)  multiple_key
    var $program_id;                      // int(11)  
    var $percentage;                      // real(12)  
    var $signups;                         // int(11)  
    var $priceperhit;                     // real(12)  
    var $pricepersignup;                  // real(12)  
    var $pricereducedpercancel;           // real(12)  
    var $pricereducedperchargeback;       // real(12)  

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('Scale',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
