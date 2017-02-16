<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/


/**
 * This is the fixture generator for table "ach_entry".
 */

$fixtures = array();

$savingsTransactionCodes = array( '22','27' );
$checkingTransactionCodes = array( '32','37' );

$achOdfiBranchId = '17d75ec4-bd49-11e0-b684-00163e4c6b77';
$externalAccountId = '96698fb8-bd4a-11e0-b684-00163e4c6b77';
$debitPaymentScheduleId = 'ad73d360-1d32-11e1-8fb7-91434d450a4a';
$creditPaymentScheduleId = '146164c0-1d38-11e1-950f-05bfe60aed0e';
$externalAccountDfiId = '12345678';
$externalAccountDfiIdCheck = '9';
$externalAccountNumber = '11235813';
$externalAccountHolder = 'John Doe';
$externalAccountType = 'checking';

for ( $i = 1; $i < 10; $i++ )
{

	$entryAmount = rand( 101, 99999 );
	

	if ( $externalAccountType == 'checking' )
	{
		$transactionCode = $checkingTransactionCodes[array_rand( $checkingTransactionCodes )];
	}
	else 
	{
		$transactionCode = $savingsTransactionCodes[array_rand( $savingsTransactionCodes )];
	}

	if ( in_array( $transactionCode, Yii::app()->params['AchEntry']['TransactionCodes']['Debit'] ) )
	{
		$isDebit = true;
	}
	else
	{
		$isDebit = false;
	}
	$fixtures[ 'ACHEntry_' . $i ] = array(
 
	 	'ach_entry_id'	=>	UUID::mint()->string,
	 	// 'ach_entry_datetime'	=>	'', // Defaults to now
	 	// 'ach_entry_status'	=>	'', // Defaults to pending
	 	'ach_entry_ach_batch_id'	=>	'', // Leave blank until batched
	 	'ach_entry_odfi_branch_id'	=>	$achOdfiBranchId,
	 	'ach_entry_external_account_id'	=>	$externalAccountId,
		'ach_entry_payment_schedule_id' =>	( $isDebit ? $debitPaymentScheduleId : $creditPaymentScheduleId ),
	 	'ach_entry_detail_transaction_code'	=>	$transactionCode,
	 	'ach_entry_detail_receiving_dfi_id'	=>	$externalAccountDfiId,
	 	'ach_entry_detail_receiving_dfi_id_check_digit'	=>	$externalAccountDfiIdCheck,
	 	'ach_entry_detail_dfi_account_number'	=>	$externalAccountNumber,
	 	'ach_entry_detail_amount'	=>	$entryAmount,
	 	'ach_entry_detail_individual_id_number'	=>	EntityIndex::getNextId( 'ach_entry_detail_individual_id_number' ),
	 	'ach_entry_detail_individual_name'	=>	$externalAccountHolder,
	 	'ach_entry_detail_discretionary_data'	=>	'',
	 	'ach_entry_detail_addenda_record_indicator'	=>	'0',
	 	'ach_entry_detail_trace_number'	=>	0,
	 	'ach_entry_addenda_type_code'	=>	'',
	 	'ach_entry_addenda_payment_info'	=>	'',
	 	'ach_entry_iat_go_receiving_dfi_id'	=>	'',
	 	'ach_entry_iat_go_receiving_dfi_id_check_digit'	=>	'',
	 	'ach_entry_iat_ofac_screening_indicator'	=>	'',
	 	'ach_entry_iat_secondary_ofac_screening_indicator'	=>	'',
	 	'ach_entry_iat_transaction_type_code'	=>	'',
	 	'ach_entry_iat_foreign_trace_number'	=>	'',
	 	'ach_entry_iat_originator_name'	=>	'',
	 	'ach_entry_iat_originator_street_addr'	=>	'',
	 	'ach_entry_iat_originator_city'	=>	'',
	 	'ach_entry_iat_originator_state_province'	=>	'',
	 	'ach_entry_iat_originator_postal_code'	=>	'',
	 	'ach_entry_iat_originator_country'	=>	'',
	 	'ach_entry_iat_originating_dfi_name'	=>	'',
	 	'ach_entry_iat_originating_dfi_id'	=>	'',
	 	'ach_entry_iat_originating_dfi_id_qualifier'	=>	'',
	 	'ach_entry_iat_originating_dfi_country_code'	=>	'',
	 	'ach_entry_iat_receiving_dfi_name'	=>	'',
	 	'ach_entry_iat_receiving_dfi_id'	=>	'',
	 	'ach_entry_iat_receiving_dfi_id_qualifier'	=>	'',
	 	'ach_entry_iat_receiving_dfi_country_code'	=>	'',
	 	'ach_entry_iat_receiver_street_addr'	=>	'',
	 	'ach_entry_iat_receiver_city'	=>	'',
	 	'ach_entry_iat_receiver_state_province'	=>	'',
	 	'ach_entry_iat_receiver_postal_code'	=>	'',
	 	'ach_entry_iat_receiver_country'	=>	'',

	);
}

return $fixtures;

