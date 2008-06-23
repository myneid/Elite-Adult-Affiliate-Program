<?php
/**
 * Table Definition for mpa3_webmasters
 */
require_once 'DB/DataObject.php';

class Mpa3_webmasters extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'mpa3_webmasters';                 // table name
    public $_database = 'old';                 // database name (used with database_{*} config)
    public $id;                              // int(11)  not_null primary_key multiple_key auto_increment
    public $username;                        // blob(255)  blob
    public $password;                        // blob(255)  blob
    public $company;                         // blob(255)  blob
    public $website;                         // blob(255)  blob
    public $email;                           // blob(255)  blob
    public $name;                            // blob(255)  blob
    public $fname;                           // blob(255)  blob
    public $lname;                           // blob(255)  blob
    public $phone;                           // blob(255)  blob
    public $icq;                             // string(12)  
    public $program;                         // int(5)  
    public $payto;                           // blob(255)  blob
    public $address;                         // blob(255)  blob
    public $city;                            // blob(255)  blob
    public $state;                           // blob(255)  blob
    public $full_state;                      // blob(255)  blob
    public $zip;                             // blob(255)  blob
    public $country;                         // blob(255)  blob
    public $full_country;                    // blob(255)  blob
    public $payment_method;                  // string(12)  
    public $wm_paypal_email;                 // string(50)  
    public $wm_epassporte_email;             // string(50)  
    public $wm_funds2go_email;               // string(50)  
    public $funds2go_approved;               // int(1)  
    public $wire_account_number;             // string(50)  
    public $wire_swift;                      // string(10)  
    public $wire_aba;                        // string(20)  
    public $wire_bank_name;                  // string(80)  
    public $wire_bank_city;                  // string(50)  
    public $wire_bank_country;               // string(50)  
    public $taxid;                           // blob(255)  blob
    public $minpay;                          // int(5)  
    public $datebirth;                       // date(10)  binary
    public $email_confirmed;                 // int(1)  
    public $approved;                        // int(1)  not_null
    public $active;                          // int(1)  
    public $frozen;                          // int(1)  
    public $disabled;                        // int(1)  
    public $reason;                          // blob(255)  blob
    public $ma;                              // int(11)  
    public $aff_rep;                         // int(11)  
    public $wm_ref_campaign;                 // int(11)  
    public $disable_date;                    // date(10)  binary
    public $dialer;                          // int(1)  
    public $massmail;                        // int(1)  
    public $signup_mails;                    // int(1)  
    public $ch_details;                      // int(1)  
    public $brute_force;                     // int(1)  
    public $date_registered;                 // date(10)  binary
    public $ip;                              // string(15)  
    public $reg_country;                     // string(30)  
    public $notes;                           // blob(65535)  not_null multiple_key blob
    public $allowed_products;                // blob(65535)  not_null blob
    public $consoles;                        // int(1)  not_null
    public $redirect_0;                      // string(255)  
    public $redirect_1;                      // string(255)  
    public $redirect_2;                      // string(255)  
    public $redirect_3;                      // string(255)  
    public $date_edited;                     // timestamp(19)  not_null unsigned zerofill binary
    public $wmid;                            // string(12)  not_null multiple_key
    public $wmuid;                           // int(20)  not_null

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('Mpa3_webmasters',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
