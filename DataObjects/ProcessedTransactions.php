<?php
/**
 * Table Definition for ProcessedTransactions
 */
require_once 'DB/DataObject.php';

class ProcessedTransactions extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'ProcessedTransactions';           // table name
    var $_database = 'new';           // database name (used with database_{*} config)
    var $id;                              // int(11)  not_null multiple_key auto_increment
    var $transaction_id;                  // int(11)  not_null primary_key
    var $date_time;                       // datetime(19)  binary
    var $type;                            // string(16)  
    var $modified_timestamp;              // timestamp(19)  not_null unsigned zerofill binary timestamp

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('ProcessedTransactions',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
