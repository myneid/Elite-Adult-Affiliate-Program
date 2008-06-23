<?php
/**
*
* QB IIF Payout Object
* Christopher Shepherd <cshepher@ieee.org> for 0x7a69.net
*
*/

class Payout_Quickbooks {

	var	$payout_data;	// array of Payout_Item objects
	var	$program_id;	// id of program being paid
	var	$start_date;	// start of payout period (unixtime int)
	var	$end_date;	// end of payout period (unixtime int)
	var	$filename_format = 'payout_%PID%_%START%-%END%.iif';

	function render( $http_download=false ) {

		// send necessary HTTP headers for download or viewing
		if( $http_download ) {
			$filename = str_replace( '%PID%', $this->program_id, $this->filename_format );
			$filename = str_replace( '%START%', date('Ymd', $this->start_date), $filename );
			$filename = str_replace( '%END%', date('Ymd', $this->end_date), $filename );

			header( 'Content-type: application/vnd.quickbooks' );
			header( 'Content-disposition: inline; filename='.$filename );
		} else {
			echo "<pre>\n";
		}

		if( !is_array( $this->payout_data )) {
			echo "No Data";
			return;
		}

		// do IIF header and VEND header
		$hdr = "!CLASS	NAME																														\n";
		$hdr.= "CLASS	class																														\n";
		$hdr .= "!VEND	NAME	PRINTAS	ADDR1	ADDR2	ADDR3	ADDR4	ADDR5	VTYPE	CONT1	CONT2	PHONE1	PHONE2	FAXNUM	EMAIL	NOTE	TAXID	LIMIT	TERMS	NOTEPAD	SALUTATION	COMPANYNAME	FIRSTNAME	MIDINIT	LASTNAME							\n";
		echo $hdr;

/*
VEND	Vendor		Jon Vendor	555 Street St	"Anywhere, AZ 85730"	USA			Jon Vendor		5555555555											Jon		Vendor	
*/

		$range = date('M-d-y', $this->start_date ).' thru ';
		$range.= date('M-d-y', $this->end_date );

		$docnumrange = date('m/d', $this->start_date).'-';
		$docnumrange.= date('d/y', $this->end_date);

		// output VEND lines
		reset( $this->payout_data );
		foreach( $this->payout_data as $datum ) {

			$line = array(	'VEND',
					$datum->payableto,
					'',
					$datum->payableto,
					$datum->address,
					'"'.$datum->city.', '.$datum->state.' '.$datum->postal.'"',
					$datum->country,
					'',
					'',
					$datum->payableto,
					'',
					$datum->phone,
					'',
					'',	// fax
					'',	// email
					'',	// note
					'',	// taxid
					'',	// limit
					'',	// terms
					'',	// notepad
					'',	// salutation
					'',	// company
					'',	// firstname
					'',	// midinit
					'',	// lastname
					'',
					'',
					'',
					'',
					'',
					'',
					''
				);

			echo implode( "\t", $line )."\n";
		}

		// TRNS and SPL headers
		$hdr = "!TRNS	TRNSID	TRNSTYPE	DATE	ACCNT	NAME	CLASS	AMOUNT	DOCNUM	MEMO	CLEAR	TOPRINT	ADDR5	DUEDATE	TERMS																	\n";
		$hdr .= "!SPL	SPLID	TRNSTYPE	DATE	ACCNT	NAME	CLASS	AMOUNT	DOCNUM	MEMO	CLEAR	QNTY	REIMBEXP	SERVICEDATE	OTHER2																	\n";
		$hdr .= "!ENDTRNS																															\n";
		echo $hdr;

		// TRNS and SPL lines
		reset( $this->payout_data );
		foreach( $this->payout_data as $datum ) {

			$line1 = array(	'TRNS',
					'',
					'BILL',
					date("n/j/Y"),
					'Accounts Payable', 	// ACCNT
					$datum->payableto,	// NAME
					'class',		// CLASS
					'-'.number_format($datum->total,2),	// AMOUNT (negative number to denote payment due
					'',			// DOCNUM
					$range . " Ref:".$datum->affid,	// MEMO 
					'N',			// CLEAR "Y/N"
					'N',			// TOPPRINT "Y/N"
					'',			// ADDR5
					date("n/j/Y"),		// DUE DATE
					'Net 30',		// TERMS
					'',
					'',
					'',
					'',
					'',
					'',
					'',
					'',
					'',
					'',
					'',
					'',
					'',
					'',
					'',
					'',
					''
				);

			$line2 = array(	'SPL',
					'',
					'BILL',
					date("n/j/Y"),
					'Cost of Goods Sold:Commission',   // ACCNT
					$datum->payableto, // NAME
					'class',		// CLASS
					number_format($datum->total,2),		// AMOUNT
					'',		// DOCNUM
					'',			// MEMO
					'N',			// CLEAR
					'',			// QNTY (Y/N in sample for some reason)
					'NOTHING',		// REIMBEXP
					"0/0/0",		// SERVICEDATE
					'',			// OTHER
					'',
					'',
					'',
					'',
					'',
					'',
					'',
					'',
					'',
					'',
					'',
					'',
					'',
					'',
					'',
					'',
					''
				);

			echo implode("\t",$line1)."\n";
			echo implode("\t",$line2)."\nENDTRNS\n";
		}
	}
}

?>
