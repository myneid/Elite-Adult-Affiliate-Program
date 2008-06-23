<?php
/**
 * Table Definition for mpa3_hits
 */
require_once 'DB/DataObject.php';

class Mpa3_hits extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'mpa3_hits';                       // table name
    public $_database = 'old';                       // database name (used with database_{*} config)
    public $id;                              // int(20)  not_null primary_key auto_increment
    public $ip;                              // string(15)  multiple_key
    public $ipv4;                            // int(20)  not_null multiple_key
    public $webmaster;                       // int(20)  not_null multiple_key
    public $site;                            // int(11)  not_null multiple_key
    public $master_site;                     // int(11)  not_null multiple_key
    public $program;                         // int(4)  not_null
    public $referrer;                        // string(255)  
    public $fm;                              // int(4)  not_null
    public $campaign;                        // int(20)  not_null
    public $console;                         // int(10)  not_null
    public $tour;                            // int(11)  not_null
    public $visit_date;                      // datetime(19)  not_null multiple_key binary

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('Mpa3_hits',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
