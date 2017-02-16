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


$client = new OAClient();
$response = $client->connect( 
	'XHwcsHLOvx45mVDF82aMB4g83gvQu5Jap2cJ6ykHjan',	// Api Token
	'Y0wQqlAEOBJ2TKsf5geHgYs7L97kdWiGc6xlc3qIJIG',	// Api Key
	'http://dev.openach.com/api/'
);	// Make sure the endpoint is the server your account is on

/*
$response = $client->connect( 
	'X4vFUA3CU7EC0NGGBvD8FNikflnUdIUhe0PBWdTtaLn',	// Api Token
	'4L6CRThHyx9LiNC0EhQzkvtBqFZ2Xhdh3bFkBNdk5Kc',	// Api Key
	'http://test.openach.com/api/'
);	// Make sure the endpoint is the server your account is on
*/

if ( ! $response->success )
{
	echo $response->error . PHP_EOL;
	exit;
}

$externalAccountsReq = new OAGetExternalAccountsRequest();
$paymentProfileReq = new OAGetPaymentProfileRequest();
$paymentProfileExtIdReq = new OAGetPaymentProfileByExtIdRequest();
$paymentSchedulesReq = new OAGetPaymentSchedulesRequest();

// Load payment profile using external id ( OAGetPaymentProfileByExtIdRequest )
// Make sure you pick an ID that actually exists in your account!
//$paymentProfileExtIdReq->payment_profile_external_id = '17';
//$paymentProfile = $client->sendRequest( $paymentProfileExtIdReq );

// OR Load payment profile using the payment profile id ( OAGetPaymentProfileRequest )
// Make sure you pick an ID that actually exists in your account!
// NOTE:  To find one, log into your OpenACH account, and find a payment profile by clicking on:
//   Your originator -> Your Bank -> Your Origination Account -> Payment Profiles

$paymentProfileReq->payment_profile_id = '535fee85-3fbe-4873-8bb0-82dac008e979';
$paymentProfileReq->payment_profile_id = '3f65a649-7666-4209-9b55-b1c307e01aaf';
$paymentProfile = $client->sendRequest( $paymentProfileReq );

if ( ! $paymentProfile->success )
{
	throw new Exception( $paymentProfile->error );
}

foreach ( $paymentProfile as $key => $value )
{
	print "$key = $value\n";
}

print PHP_EOL;

$externalAccountsReq->payment_profile_id = $paymentProfile->payment_profile_id;
$externalAccounts = $client->sendRequest( $externalAccountsReq );

foreach ( $externalAccounts as $externalAccount )
{

	print $externalAccount->external_account_bank . PHP_EOL;
	
	foreach ( $externalAccount as $key => $value )
	{
		print "$key = $value\n";
	}
}

print PHP_EOL;

$paymentSchedulesReq->payment_profile_id = $paymentProfile->payment_profile_id;
$paymentSchedules = $client->sendRequest( $paymentSchedulesReq );

foreach ( $paymentSchedules as $paymentSchedule )
{

	foreach ( $paymentSchedule as $key => $value )
	{
		print "$key = $value\n";
	}
}



