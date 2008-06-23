<?php
/**
 * Table Definition for tbl_stores
 */
require_once 'DB/DataObject.php';

class Tbl_stores extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'tbl_stores';                      // table name
    var $_database = 'old';                      // database name (used with database_{*} config)
    var $store_id;                        // int(11)  not_null primary_key
    var $store_name;                      // string(100)  not_null primary_key
    var $store_url;                       // string(100)  
    var $store_slogan;                    // string(100)  
    var $mailer_id;                       // string(20)  
    var $preview_file;                    // string(100)  
    var $mailer_site;                     // int(4)  
    var $biller_id;                       // int(11)  
    var $subjects;                        // blob(65535)  blob
    var $active;                          // int(4)  not_null primary_key
    var $category_ids;                    // string(255)  
    var $site_type;                       // string(50)  
    var $Join_page_background_color;      // string(6)  
    var $Join_form_background_color;      // string(6)  
    var $Join_form_header_background_color;    // string(6)  
    var $Join_submit_button_text;         // string(30)  
    var $Join_form_text_color;            // string(6)  
    var $Join_form_header_text_color;     // string(6)  
    var $Join_header_graphic_file;        // string(100)  
    var $Join_header_include_file;        // string(100)  
    var $Join_form_border_color;          // string(6)  
    var $Join_body_header_file;           // string(100)  
    var $Billing_type_id;                 // int(11)  not_null
    var $Redirect_on_join;                // string(200)  
    var $Join_footer_include_file;        // string(100)  
    var $Join_Template;                   // string(100)  
    var $Join_form_message_text;          // blob(-1)  blob
    var $Join_form_title_text_color;      // string(6)  
    var $Join_page_text_color;            // string(6)  

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('Tbl_stores',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
