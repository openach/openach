<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

return array(
	'AchEntry' => array(
		'Status' => array (
			'pending' => 'Pending',
			'processing' => 'Processing',
			'posted' => 'Posted',
			'returned' => 'Returned',
			'error' => 'Error',
		),
		'TransactionCode' => array(
			'22' => 'Checking Credit',
			'23' => 'Checking Credit Prenote',
			'24' => 'Zero-Dollar Checking Credit',
			'27' => 'Checking Debit',
			'28' => 'Checking Debit Prenote',
			'29' => 'Zero-Dollar Checking Debit',
			'32' => 'Savings Credit',
			'33' => 'Savings Credit Prenote',
			'34' => 'Zero-Dollar Savings Credit',
			'37' => 'Savings Debit',
			'38' => 'Savings Debit Prenote',
			'39' => 'Zero-dollar Savings Credit',
		),
		'TransactionCodes' => array(
			'Debit' => array ( 27, 28, 29, 37, 38, 39 ),
			'Credit' => array ( 22, 23, 24, 32, 33, 34 ),
		),
		'DfiIdQulifiers' => array(
			'01' => 'ABA Routing Number',
			'02' => 'SWIFT Bank Identifier',
		),

	),
	'AchBatch' => array(
		'ServiceClassCode' => array(
			'200' => 'Mixed Debits and Credits',
			'220' => 'ACH Credits Only',
			'225' => 'ACH Debits Only',
		),
		// Number of days lead time for pulling/delivering payments
		// WARNING!!! Changing this mid-stream may have unwanted consequences!
		// Also, this works in conjunction with Settlement LeadTime
		'LeadTime' => array(
			'credit' => 3,
			'debit' => 3,
		),
	),
	'AchFile' => array(
		'ConfStatus' => array(
			'pending' => 'Pending',
			'processing' => 'Processing',
			'success' => 'Success',
			'error' => 'Error',
		),
		'Status' => array(
			'pending' => 'Pending',
			'processing' => 'Processing',
			'built' => 'Built',
			'transferred' => 'Transferred',
			'confirmed' => 'Confirmed',
			'error' => 'Error',
		),
		// EnableFileTransfers specifies whether or not the sysetm should attempt to send the built files via the transfer agent
		'EnableFileTransfers' => true,
		//'EnableFileTransfers' => false,
		// SaveLocalCopy specifies whether or not to save a local copy of the sent file to a temp folder for debugging purposes
		'SaveLocalCopy' => true,
		// UpdateStatusAfterTransfer specifies whether the file status should be updated to the after transfer state (disabling is useful for repeatedly building files during testing). If not debugging, this should be set to true 
		'UpdateStatusAfterTransfer' => true,
		//'UpdateStatusAfterTransfer' => false,
			
	),
	'Settlement' => array(
		'TransactionType' => array(
			'credit' => 'Credit',
			'debit' => 'Debit',
		),
		// Number of days to advance/delay settlement of funds to/from customer
		// Debit ADVANCES the ach_batch_effective_entry_date of settlement for the processed batch by N number of days from the date on the original batch
		// Credit DELAYS the ach_batch_effective_entry_date of the settlement for the processed batch by N number of days from the date of the original batch
		'LeadTime' => array(
			'credit' => 3,
			'debit' => 3, 
		),
	),
	'PaymentSchedule' => array(
		// SkipMissedSchedules specifies how missed schedules catch up to current processing. If set to false, each successive payment scheduler run
		// will continue to process missed schedules, incrementing to the next date with each scheduler run until they are caught up. If set to true,
		// any missed payments will be skipped, only a single payment will be processed, and the next schedule date will be set to whatever the next 
		// scheduled future date would have been.
		// Note that this has HUGE implications for how payments are scheduled and processed!  For instance, if the payment scheduler were to 
		// fail to run for 7 days, and there are daily payment schedules, the setting would dictate that the scheduler create 7 catch-up payments 
		// (if set to false), or only 1 catch-up payment (if set to true). Also, it is important to note that if set to true, completely catching
		// up with the current processing requires the payment scheduler to run once for every day that was missed, or at a minimum until all schedules 
		// have next process dates that are in the future.
		'SkipMissedSchedules' => true,
	),
);
