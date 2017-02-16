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
require_once( dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR . 'OpenACHSdk.php' );

echo "Creating a new OAConnection Object" . PHP_EOL;
$oaConn = new OAConnection( new OAClientConfigIni( '..' ) );
//var_dump($oaConn);

// The OAConnection takes a ClientConfig instance to get the APIKey and APIToken references.
// A default class that uses an INI file is provided.
// The default directory for the filename is the API installation folder
// The default filename is ./conf/connection.ini (which ought to be chmod 400 and owned by the application daemon user)

// Here's an example showing an INI Config file stored in the /etc/myapp/oaconf/connection_local.ini file
//$oaConn = new OAConnection( new OAClientConfigIni('/etc/myapp', '/conf/connection_local.ini') );

// Using this file requires no parameters to be passed in though it does 

//$oaConn->setDebuglevel( 2 );

echo "Connecting to server..." . PHP_EOL;
$connected = '';
$attempts = 3;
while ( !$connected and $attempts > 0)
{
	try {
		echo "Connecting (" . $oaConn->endpointUrl() . "): $attempts remaining" . PHP_EOL;
		$oaConn->connect();
		$connected = $oaConn->isConnected();
		if ($connected) {
			echo "Successfully connected!" . PHP_EOL;
		}

	} catch (Exception $e) {
		//echo $response->error . PHP_EOL;
		echo $e->getMessage() . PHP_EOL;
	}

	$attempts = $attempts - 1;
}
if (!$connected) exit("Failed to establish a connection with the OpenACH server.");


try {
	// Load payment profile using either an external_account_id or a payment_profile_id
	// Make sure you pick an ID that actually exists in your account!
	// NOTE:  To find one, log into your OpenACH account, and find a payment profile by clicking on:
	//   Your originator -> Your Bank -> Your Origination Account -> Payment Profiles
	// A very common use case is for end users to have a 1:1 correlation with payment profiles

	// echo "Retrieving Payment Profile ID from a custom defined app identifier" . PHP_EOL;
	$stored_user_profile_id = '106-profilesim';  // This could be the user's internal userid, email, or whatever 
	$stored_user_profile_id = 'dbeecdd4118c153ecfef8b8bd6d40f85489582e663';  // This could be the user's internal userid, email, or whatever 

	$paymentProfile = $oaConn->getPaymentProfile( $stored_user_profile_id, OAConnection::IDTYPE_APP );
	printObj( $paymentProfile, 1 );

	if (! isset( $paymentProfile->payment_profile_id ) ) {
		// The external_account_id lookup failed, for this demo, use this hard coded payment_profile_id
		// NOTE:  You will want to update this with a valid payment profile id
		$paymentProfile = $oaConn->getPaymentProfile('6ed8cab4-9f66-47fb-9774-e1eeb49f5612', OAConnection::IDTYPE_API );
		//$oaConn->setPaymentProfileId('789937d2-429f-426d-9508-1efb61ac41fb', OAConnection::IDTYPE_API );
		//$oaConn->getPaymentProfile();

	}

	if ( isset( $paymentProfile->payment_profile_id ) ) {
		// Now that we have the PaymentProfile we can set the API Payment Profile ID so it can be used by default on other calls
		echo "Setting the default Payment Profile ID for the connection" . PHP_EOL;
		$oaConn->setPaymentProfileId( $paymentProfile->payment_profile_id,  OAConnection::IDTYPE_API );

		// External accounts represent the user's bank accounts
		// Retrieve the external accounts on this profile
		echo "\tGetting External Accounts..." . PHP_EOL;
		$externalAccounts = $oaConn->getExternalAccountsSummary();
		foreach ( $externalAccounts as $extAcct )
		{
			print "\tExternal Account: (" . $extAcct->external_account_id . ") " . $extAcct->external_account_bank . " - " . $extAcct->external_account_name . PHP_EOL;
			printObj ( $extAcct, 2 );

			// Just like with payment profiles we can set this as the default external account for subsequent commands
			$oaConn->setExternalAccountId( $extAcct->external_account_id );

			// To modify the external account retrieving the whole account is required.
			$externalAccount = $oaConn->getExternalAccount( $extAcct->external_account_id );
			if ( isset( $externalAccount->external_account_id ) ) {
				print "Retrieved External Account: '" . $externalAccount->external_account_id  . "' name is: '" . $externalAccount->external_account_holder . "'" . PHP_EOL;

				echo "Modifying External Account..." . PHP_EOL;

				// Let's reverse the name of the account holder every time this demo is run
				$nameBefore = $externalAccount->external_account_holder;
				print "Changing name to: '" . strrev($nameBefore) . PHP_EOL;
				$externalAccount->external_account_holder = strrev($nameBefore);
				printObj( $externalAccount, 3 );
				$response = $oaConn->saveExternalAccount( $externalAccount );
				if ( isset( $response->external_account_id ) ) {
					print "Updated External Account: was-'" . $nameBefore  . "' is now-'" . $response->external_account_holder . "'" . PHP_EOL;
				}
			}
		}


		// Retrieve all currently active paymentSchedules associated to this external account.
		// Useful to view / modify / discontinue / disable payments
		echo "\tGetting Payment Schedules..." . PHP_EOL;
		#$paymentSchedules = $oaConn->getPaymentSchedulesSummary( $extAcct->external_account_id);
		$paymentSchedules = $oaConn->getPaymentSchedulesSummary();
		foreach ( $paymentSchedules as $paySched )
		{
			print "\tPayment Schedule: " . $paySched->payment_schedule_id . PHP_EOL;
			printObj ( $paySched, 2 );

			// // Modify the Payment Schedule and Save it back
			print "Modifying Payment Schedule: " . $paySched->payment_schedule_id . PHP_EOL;
			$paymentSchedule = $oaConn->getPaymentSchedule( $paySched->payment_schedule_id );
			$payment_schedule_amount = $paymentSchedule->payment_schedule_amount;
			$paymentSchedule->payment_schedule_amount = $payment_schedule_amount + 100.00;
			$response = $oaConn->savePaymentSchedule( $paymentSchedule );
			if ( isset( $response->payment_schedule_id ) ) {
				print "Updated Payment Schedule: was-'" . $payment_schedule_amount  . "' is now-'" . $response->payment_schedule_amount . "'" . PHP_EOL;
			}
		}


		// Modifying this Payment Profile - make some changes and save them back
		// Here we'll add a number 0 through 10 (incrementing each time this demo is run) to their last name
		echo "Modifying the Payment Profile..." . PHP_EOL;
		$lname = $paymentProfile->payment_profile_last_name;
		$paymentProfile->payment_profile_last_name = substr($lname, 0, 4) . strval(intval(substr($lname, -1, 1)) + 1);
		print("Setting the last name to: " . $paymentProfile->payment_profile_last_name . PHP_EOL);
		$response = $oaConn->savePaymentProfile( $paymentProfile );
		print "Updated Payment Profile: was-'" . $lname  . "' is now-'" . $response->payment_profile_last_name . "'" . PHP_EOL;
		print PHP_EOL;

	}


	// Let's look at the available Payment Types
	// Payment types are specific to your organization; make them up as you need
	// These control the descriptions that end users see on their statements 
	// and set a default organization account the money is credited/debited to/from
	echo "Getting Payment Types..." . PHP_EOL;
	$paymentTypes = $oaConn->getPaymentTypes();
	$payment_type_id = '';
	foreach ( $paymentTypes as $paymentType )
	{
		print "Payment Type: " . $paymentType->payment_type_name . PHP_EOL;
		printObj ( $paymentType, 1 );
		if ( $paymentType->payment_type_transaction_type == 'debit' )
		{
			$payment_type_id = $paymentType->payment_type_id;
		}
	}
	print PHP_EOL;

	// Demonstrate retrieving an external schedule
	//$paymentSchedule = $oaConn->getPaymentSchedule('6d21907a-a362-47c0-84b5-30ae219dbc78');
	//print "Payment Schedule: " . $paymentSchedule->payment_schedule_id . PHP_EOL;
	//printObj ( $paymentSchedule, 1 );


	// Demonstrate adding a new Payment Profile
	print "Creating new Payment Profile..." . PHP_EOL;
	// Create a new Payment Profile
        	//payment_profile_id = 			//Should leave these blank for a brand new Profile
        	//payment_profile_external_id =		//Should put something here to retrieve later 
        	//payment_profile_first_name = 'James'
        	//payment_profile_last_name = 'Bond'
        	//payment_profile_email_address = agent007@mi6.uk.gov
        	//payment_profile_password = Shaken not stirred
        	//payment_profile_security_question_1 = 
        	//payment_profile_security_question_2 = 
        	//payment_profile_security_question_3 = 
        	//payment_profile_security_answer_1 = 
        	//payment_profile_security_answer_2 = 
        	//payment_profile_security_answer_3 = 
        	//payment_profile_status = enabled

	$oaConn->setPaymentProfileId('');
	$newPaymentProfile = $oaConn->getPaymentProfile('', OAConnection::IDTYPE_API);
       	$newPaymentProfile->payment_profile_first_name = 'Jane' . rand();
	$newPaymentProfile->payment_profile_last_name = 'Eyre' . rand();
	$newPaymentProfile->payment_profile_email_address = 'janeeyre' . rand() . '@thornfield.hall';
	$newPaymentProfile->payment_profile_password = 'Mr. Rochester';
	#$newPaymentProfile->payment_profile_external_id = $newPaymentProfile->payment_profile_first_name;
	$newPaymentProfile->payment_profile_external_id = $newPaymentProfile->payment_profile_email_address;

	print "Saving Payment Profile..." . PHP_EOL;
	printObj($newPaymentProfile, 1);
	// $paymentProfile = $oaConn->savePaymentProfile( $newPaymentProfile );
	$response = $oaConn->savePaymentProfile( $newPaymentProfile );

	if ( isset($response->payment_profile_id) ) {
		print "Retrieving profile to confirm save and setting as the default profile on the connection..." . PHP_EOL;
		// The reponse from savePaymentProfile was actually the new Profile;
		// we retrieve it here separately just to demonstrate it worked.
		$paymentProfile = $oaConn->getPaymentProfile( $newPaymentProfile->payment_profile_external_id, OAConnection::IDTYPE_APP );
		printObj($paymentProfile, 1);
		$oaConn->setPaymentProfileId( $paymentProfile->payment_profile_id );
	} else {
		printObj($response, 1);
	}

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
echo "======================="; echo var_dump($newExternalAccount); echo "==========================";
	$newExternalAccount->external_account_payment_profile_id = $paymentProfile->payment_profile_id;
	$newExternalAccount->external_account_name = "Jane Eyre's Savings Account at Jane Eyre's Bank";
	$newExternalAccount->external_account_type = "savings";
	$newExternalAccount->external_account_bank = "Jane Eyre's Bank";
	$newExternalAccount->external_account_holder = "Jane Eyre";
	$newExternalAccount->external_account_dfi_id = '101000187';
	$newExternalAccount->external_account_number = rand( 1000000, 9999999 );
	// printObj($newExternalAccount, 1);

	print "Saving External Account..." . PHP_EOL;
	printObj($newExternalAccount, 1);
	// $externalAccount = $oaConn->saveExternalAccount( $newExternalAccount );
	$response = $oaConn->saveExternalAccount( $newExternalAccount );

	if ( isset( $response->external_account_id ) ) {
		// The reponse from saveExternalAccount was actually the new External Account;
		// we retrieve it here separately just to demonstrate it worked.
		print "Retrieving external account to confirm save..." . PHP_EOL;
		$externalAccount = $oaConn->getExternalAccount($response->external_account_id);
		printObj($externalAccount, 1);
		$oaConn->setExternalAccountId($externalAccount->external_account_id);
		print "Succesfully retrieved External Account:" . PHP_EOL;
	} else {
		printobj($response, 1);
	}

	// Now let's create a new Payment Schedule for this new Profile
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
	// And stub in all the fields making it very easy to inspect.
	// (Likely to be replaced with a $oaCon->createNewPaymentSchedule( $ext_acct_id, $pay_type_id, $amt, $frequency, $end_date, $currency ) call.)

	$paymentSchedule = $oaConn->getPaymentSchedule('');
	$paymentSchedule->payment_schedule_external_account_id = $externalAccount->external_account_id;
	$paymentSchedule->payment_schedule_payment_type_id = $payment_type_id;
	$paymentSchedule->payment_schedule_amount = rand( 10000, 99999 ) / 100;
	printObj($paymentSchedule, 1);
	print "Saving Payment Schedule..." . PHP_EOL;
	$response = $oaConn->savePaymentSchedule( $paymentSchedule );

	if ( isset( $response->payment_schedule_id ) ) {
		// The reponse from savePaymentSchedule was actually the new Payment Schedule;
		// we retrieve it here separately just to demonstrate it worked.
		print "Retrieving payment schedule to confirm save..." . PHP_EOL;
		$paymentSchedule = $oaConn->getPaymentSchedule($response->payment_schedule_id);
		printObj($paymentSchedule, 1);
		print "Succesfully retrieved Payment Schedule!" . PHP_EOL;
	} else {
		printobj($response, 1);
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

