<?php
/**
 * Table Definition for tbl_paid_cards
 */
require_once 'DB/DataObject.php';

class Tbl_paid_cards extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'tbl_paid_cards';                  // table name
    var $_database = 'old';                  // database name (used with database_{*} config)
    var $card;                            // string(25)  

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('Tbl_paid_cards',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
