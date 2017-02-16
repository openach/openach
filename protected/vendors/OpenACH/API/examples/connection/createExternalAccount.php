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

	// Pretty much everything requires a Payment Profile; optionally retrieve the PaymentProfile to ensure it still exists.
        //$payment_profile_id ='535fee85-3fbe-4873-8bb0-82dac008e979';
	$payment_profile_id = '3f65a649-7666-4209-9b55-b1c307e01aaf';
	$paymentProfile = $oaConn->getPaymentProfile($payment_profile_id, OAConnection::IDTYPE_API );
	if (! isset( $paymentProfile->payment_profile_id ) ) exit("Failed to retrieve payment profile.");


	// Now create a new External Bank Account for this Payment Profile
	print "Creating new External Account for this Payment Profile..." . PHP_EOL;
	// Create a new External Account
		//external_account_id =
		//external_account_payment_profile_id =
		//external_account_type =
		//external_account_name =
		//external_account_bank =
		//external_account_holder =
		//external_account_country_code =
		//external_account_dfi_id =
		//external_account_number =
		//external_account_billing_address = 
		//external_account_billing_city = 
		//external_account_billing_state_province = 
		//external_account_billing_postal_code = 
		//external_account_billing_country = 
		//external_account_business = 
		//external_account_verification_status =
		//external_account_status =

	// Create a new object by getting a blank External Account; will likely turn this into a new call
	$newExternalAccount = $oaConn->getExternalAccount('');
	$newExternalAccount->external_account_payment_profile_id = $paymentProfile->payment_profile_id;
	$newExternalAccount->external_account_name = "Jane Eyre's Savings Account at Jane Eyre's Bank";
	$newExternalAccount->external_account_type = "savings";
	$newExternalAccount->external_account_bank = "Jane Eyre's Bank";
	$newExternalAccount->external_account_holder = "Jane Eyre";
	$newExternalAccount->external_account_dfi_id = '101000187';
	$newExternalAccount->external_account_number = rand( 1000000, 9999999 );

	print "Saving External Account..." . PHP_EOL;
	printObj($newExternalAccount, 1);
	$externalAccount = $oaConn->saveExternalAccount( $newExternalAccount );

	if ( isset( $externalAccount->external_account_id ) ) {
		// The reponse from saveExternalAccount was successful;
		// we retrieve it here separately just to demonstrate it worked.
		print "Retrieving external account to confirm save..." . PHP_EOL;
		$response = $oaConn->getExternalAccount($externalAccount->external_account_id);
		printObj($response, 1);
		print "Succesfully retrieved External Account:" . PHP_EOL;
	} else {
		print "Failed to create External Account:" . PHP_EOL;
		printobj($response, 1);
	}

	if ( $connected ) {
		print "Disconnecting ";
		$res = $oaConn->disconnect();
		printObj( $res );
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

