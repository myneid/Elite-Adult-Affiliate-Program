<?php
/**
 * Table Definition for tbl_members_history
 */
require_once 'DB/DataObject.php';

class Tbl_members_history extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'tbl_members_history';             // table name
    var $_database = 'old';             // database name (used with database_{*} config)
    var $ISSUE_DATE;                      // datetime(19)  multiple_key binary
    var $TRANS_ID;                        // string(50)  multiple_key
    var $FLIX_MEMBER_ID;                  // string(50)  
    var $USER_NAME;                       // string(50)  multiple_key
    var $ORIGIN;                          // string(50)  
    var $STATUS;                          // string(50)  
    var $CARD;                            // string(30)  
    var $EXPIRATION;                      // string(10)  
    var $DESCRIPTION;                     // string(200)  
    var $AMOUNT;                          // real(22)  
    var $FORCE_CODE;                      // string(50)  
    var $MISC_INFO;                       // string(50)  
    var $AUTH_CODE;                       // string(10)  
    var $FIRST_NAME;                      // string(50)  
    var $LAST_NAME;                       // string(50)  
    var $STREET;                          // string(100)  
    var $CITY;                            // string(100)  
    var $STATE;                           // string(50)  
    var $ZIP;                             // string(15)  
    var $COUNTRY;                         // string(50)  
    var $PHONE;                           // string(50)  
    var $EMAIL;                           // string(100)  
    var $IP_ADDRESS;                      // string(16)  
    var $HOST;                            // string(100)  
    var $USER_DATA;                       // string(50)  
    var $SITE;                            // string(50)  
    var $ISSUER;                          // string(50)  
    var $PASSWORD;                        // string(50)  
    var $SIGNUP;                          // string(50)  
    var $ID;                              // int(20)  not_null primary_key auto_increment
    var $Sequence_number;                 // int(11)  
    var $AID;                             // int(11)  
    var $Recurring;                       // int(4)  
    var $Transaction_Type;                // int(4)  
    var $Member_ID;                       // int(20)  

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('Tbl_members_history',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
