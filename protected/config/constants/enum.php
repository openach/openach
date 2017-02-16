<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

return array(
	'ExternalAccount' => array(
		'DfiIdQualifier' => array(
			'01' => 'ABA',
			'02' => 'SWIFT',
		),
		'Status' => array(
			'enabled' => 'Enabled',
			'frozen' => 'Frozen',
			'closed' => 'Closed',
		),
		'Type' => array(
			'checking' => 'Checking',
			'savings' => 'Savings',
		),
		'VerificationStatus' => array(
			'pending' => 'pending',
			'attempted' => 'attempted',
			'completed' => 'completed',
			'failed' => 'Failed',
		),
	),
	'FileTransfer' => array(
		'Status' => array(
			'pending' => 'Pending',
			'transferring' => 'Transferring',
			'transferred' => 'Transferred',
			'confirmed' => 'Confirmed',
			'processed' => 'Processed',
			'failed' => 'Failed',
		),
	),
	'OdfiBranch' => array(
		'dfi_id_qualifier' => array(
			'01' => 'ABA',
			'02' => 'SWIFT',
		),
		'status' => array(
			'enabled' => 'Enabled',
			'disabled' => 'Disabled',
		),
	),
	'PaymentProfile' => array(
		'status' => array(
			'enabled' => 'Enabled',
			'suspended' => 'Suspended',
		),
	),
	'PaymentSchedule' => array(
		'Frequency' => array(
			'once' => 'Once',
			'daily' => 'Daily',
			'weekly' => 'Weekly',
			'biweekly' => 'Biweekly',
			'monthly' => 'Monthly',
			'bimonthly' => 'Bimonthly',
			'biannually' => 'Biannually',
			'annually' => 'Annually',
			'biennially' => 'Biennially',
		),
		'Status' => array(
			'enabled' => 'Enabled',
			'suspended' => 'Suspended',
		),
	),
	'PaymentType' => array(
		'Status' => array(
			'enabled' => 'Enabled',
			'disabled' => 'Disabled',
		),
		'TransactionType' => array(
			'credit' => 'Credit',
			'debit' => 'Debit',
		),
	),
	'PhoneticData' => array(
		'EncodingMethod' => array(
			'soundex' => 'Soundex',
			'nysiis' => 'NYSIIS',
			'metaphone' => 'Metaphone',
			'metaphone2' => 'Metaphone 2'
		),
	),
	'Plugin' => array(
		'Status' => array(
			'enabled' => 'Enabled',
			'disabled' => 'Disabled',
		),
	),
	'Settlement' => array(
		'TransactionType' => array(
			'credit' => 'Credit',
			'debit' => 'Debit',
		),
	),
	'UserApi' => array(
		'Status' => array(
			'enabled' => 'Enabled',
			'disabled' => 'Disabled',
		),
	),
	'User' => array(
		'Status' => array(
			'enabled' => 'Enabled',
			'disabled' => 'Disabled',
		),
	),


	// NON-DB, but used globally
	'BankPlugins' => array(
		'SagePay' => 'Sage Payments',
		'USBank' => 'US Bank',
		'WellsFargo' => 'Wells Fargo',
		'Manual' => 'Manual Processing',
	),
	'Currency' => array(
		'Code' => array(
			'USD' => 'USD',
			'CAD' => 'CAD',
		),
	),
	// This sets the allowed countries system-wide
	'Country' => array(
		'Payment' => array(
			'US' => 'United States',
			// Canada is temporarily disable until IAT processing is fixed
			//'CA' => 'Canada',
		),
	),
		
);
