<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

// API Test for OpenACH

// Load the OpenACH SDK
require_once( '../../lib/OpenACHSdk.php' );

// First create a Connection object.
// The OAConnection constructor takes a ClientConfig instance to get the APIKey and APIToken references.
// A default class that uses an INI file is provided.
// The default directory is the API installation directory.
// The default filename is ./conf/connection.ini (which ought to be chmod 400 and owned by the application daemon user)
// We override that by submitting ".." as the configruation directory (a filename could also be provided if needed).

echo "Creating a new OAConnection Object" . PHP_EOL;
$oaConn = new OAConnection( new OAClientConfigIni('../..') );

// Here's an example showing an INI Config file stored in the /etc/myapp/oaconf/local_connection.ini file
//$oaConn = new OAConnection( new OAClientConfigIni('/etc/myapp', '/conf/local_connection.ini') );


// Now that we've got the connection, connect to the server and create the ExternalAccount.
echo "Connecting to server..." . PHP_EOL;
$connected = '';
$attempts = 3;
try {
	while ( !$connected and $attempts > 0)
	{
		echo "Connecting: $attempts remaining" . PHP_EOL;
		$oaConn->connect();
		$connected = $oaConn->isConnected();
		if ($connected) {
			echo "Successfully connected!" . PHP_EOL;
		}


	$attempts = $attempts - 1;
	}
	if (!$connected) exit("Failed to establish a connection with the OpenACH server.");


        // A Payment Schedule requires an external account (to pull/push the money from/to; and a payment type (credir or debit)
	// Should get external account and payment_type from the system, this could easily break....
        //$external_account_id = '3c073d1b-1406-491d-aa0c-f1dae70ac457';
        $external_account_id = '1fb35cf7-9668-4f42-b93d-289d7d71b5d1';
        //$payment_type_id = '5eb129ad-8f44-41b7-8fba-18d06223fd8d';
        $payment_type_id = 'dd28cae1-2ed0-4479-83a5-0572aba27936';

	// Now let's create a new Payment Schedule for this External Account / Payment Type
	print "Creating a new Payment Schedule: " . PHP_EOL;
	// An ExternalAccountID is required as is a payment_type_id;
	// Here are all the paymentSchedule fields:
               	//payment_schedule_id =
               	//payment_schedule_external_account_id =
               	//payment_schedule_payment_type_id =
               	//payment_schedule_amount =
               	//payment_schedule_currency_code =
               	//payment_schedule_next_date =
               	//payment_schedule_frequency =
               	//payment_schedule_end_date =
               	//payment_schedule_remaining_occurrences = 
               	//payment_schedule_status =
	
	// First call getPaymentSchedule passing in '' as the schedule id.
	// That will initialize a payment_schedule web object with frequency "once"; end_date "today";
	// It will stub in all the fields with empty values making it very easy to inspect.
	// (Likely to be replaced with a $oaCon->createNewPaymentSchedule( $ext_acct_id, $pay_type_id, $amt, $frequency, $end_date, $currency ) call.)

	$paymentSchedule = $oaConn->getPaymentSchedule('');
	$paymentSchedule->payment_schedule_external_account_id = $external_account_id;
	$paymentSchedule->payment_schedule_payment_type_id = $payment_type_id;
	$paymentSchedule->payment_schedule_amount = rand( 10000, 99999 ) / 100;
	printObj($paymentSchedule, 1);
	print "Saving Payment Schedule..." . PHP_EOL;
	$paymentSchedule = $oaConn->savePaymentSchedule( $paymentSchedule );

	if ( isset( $paymentSchedule->payment_schedule_id ) ) {
		// The reponse from savePaymentSchedule was actually the new Payment Schedule;
		// we retrieve it here separately just to demonstrate it worked.
		print "Retrieving payment schedule to confirm save..." . PHP_EOL;
		$response = $oaConn->getPaymentSchedule($paymentSchedule->payment_schedule_id);
		printObj($response, 1);
		print "Succesfully retrieved new Payment Schedule!" . PHP_EOL;
	} else {
		printobj($paymentSchedule, 1);
	}


} catch (Exception $e) {
	//echo $response->error . PHP_EOL;
	echo $e->getMessage() . PHP_EOL;
}

function printObj ( $obj, $depth=0 ) {
	foreach ( $obj as $key => $value )
	{
		print str_repeat("\t", $depth) . "$key = $value" . PHP_EOL;
	}
	print PHP_EOL;
}

