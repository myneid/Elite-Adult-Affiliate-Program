<?php
/**
*
* Payout_Item object - data about an individual payout item or check
*
*/

class Payout_Item {

      var	$payableto;	// Payable To:
      var	$address;	// Street Address
      var	$city;		// City
      var	$stats;		// State
      var	$postal;	// ZIP code/etc
      var	$country;	// Full name of Country
      var	$phone;		// Telephone Number
      var	$affid;		// Affiliate ID
      var	$total;		// Amount of Check
      
      function fromArray( $input ) {
      
          $output =& new Payout_Item;
          
          $output->payableto	= $input['payableto'];
          $output->address	= $input['address'];
          $output->city		= $input['city'];
          $output->state	= $input['state'];
          $output->postal	= $input['postal'];
          $output->country	= $input['country'];
          $output->phone	= $input['phone'];
          $output->affid	= $input['affid'];
          $output->total	= $input['total'];
          
          return $output;
      }

}