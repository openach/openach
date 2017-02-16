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


	// Demonstrate adding a new Payment Profile
	print "Creating new Payment Profile..." . PHP_EOL;
	// Create a new Payment Profile
        	//payment_profile_id = 			//Should leave these blank for a brand new Profile
        	//payment_profile_external_id =		//Should put something here to retrieve later 
        	//payment_profile_first_name = 
        	//payment_profile_last_name = 
        	//payment_profile_email_address = 
        	//payment_profile_password = 
        	//payment_profile_security_question_1 = 
        	//payment_profile_security_question_2 = 
        	//payment_profile_security_question_3 = 
        	//payment_profile_security_answer_1 = 
        	//payment_profile_security_answer_2 = 
        	//payment_profile_security_answer_3 = 
        	//payment_profile_status = enabled

        // First retrieve a Payment Profile without an id field, this will create a new empty Payment Profile; then fill it and save it.
	$newPaymentProfile = $oaConn->getPaymentProfile('', OAConnection::IDTYPE_API);
       	$newPaymentProfile->payment_profile_first_name = 'Jane' . rand();
	$newPaymentProfile->payment_profile_last_name = 'Eyre' . rand();
	$newPaymentProfile->payment_profile_email_address = 'janeeyre' . rand() . '@thornfield.hall';
	$newPaymentProfile->payment_profile_password = 'Mr. Rochester';
	$newPaymentProfile->payment_profile_external_id = $newPaymentProfile->payment_profile_email_address;

	print "Saving Payment Profile..." . PHP_EOL;
	printObj($newPaymentProfile, 1);
	$paymentProfile = $oaConn->savePaymentProfile( $newPaymentProfile );

	if ( isset($paymentProfile->payment_profile_id) ) {
		print "Saved Payment Profile to confirm save retrieve it using an identifier..." . PHP_EOL;
		// The reponse from savePaymentProfile was actually the new Profile;
		// we retrieve it here separately and just to demonstrate it worked let's query using the APP Id (instead of the API ID).
		$response = $oaConn->getPaymentProfile( $paymentProfile->payment_profile_external_id, OAConnection::IDTYPE_APP );

		printObj($response, 1);

	} else {
		printObj($paymentProfile, 1);
	}


} catch(Exception $e) {
	echo $e->getMessage() . PHP_EOL;
} 

if ( $connected ) {
	print "Disconnecting ";
	$res = $oaConn->disconnect();
	printObj( $res );
}

function printObj ( $obj, $depth=0 ) {
	foreach ( $obj as $key => $value )
	{
		print str_repeat("\t", $depth) . "$key = $value" . PHP_EOL;
	}
	print PHP_EOL;
}

