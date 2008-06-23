<?php
/**
 * Table Definition for netbillingrawcc
 */
require_once 'DB/DataObject.php';

class Netbillingrawcc extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'netbillingrawcc';                 // table name
    var $_database = 'old';                 // database name (used with database_{*} config)
    var $ISSUE_DATE;                      // datetime(19)  multiple_key binary
    var $TRANS_ID;                        // string(50)  multiple_key
    var $MEMBER_ID;                       // string(50)  multiple_key
    var $USER_NAME;                       // string(50)  
    var $ORIGIN;                          // string(50)  
    var $STATUS;                          // string(50)  
    var $CARD;                            // string(50)  
    var $EXPIRATION;                      // string(50)  
    var $DESCRIPTION;                     // string(50)  
    var $AMOUNT;                          // string(50)  
    var $FORCE_CODE;                      // string(50)  
    var $MISC_INFO;                       // string(50)  
    var $AVS;                             // string(50)  
    var $CVV2;                            // string(50)  
    var $ACI;                             // string(50)  
    var $FIRST_NAME;                      // string(50)  
    var $LAST_NAME;                       // string(50)  
    var $STREET;                          // string(50)  
    var $CITY;                            // string(50)  
    var $STATE;                           // string(50)  
    var $ZIP;                             // string(50)  
    var $COUNTRY;                         // string(50)  
    var $PHONE;                           // string(50)  
    var $EMAIL;                           // string(50)  
    var $IP_ADDRESS;                      // string(50)  
    var $HOST;                            // string(50)  
    var $USER_DATA;                       // string(50)  
    var $SITE;                            // string(50)  
    var $ISSUER;                          // string(50)  
    var $PASSWORD;                        // string(50)  
    var $SIGNUP;                          // string(50)  
    var $ID;                              // int(20)  not_null primary_key auto_increment

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('Netbillingrawcc',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
