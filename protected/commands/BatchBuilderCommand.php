<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

/**
 * BatchBuilderCommand class file.
 *
 * @author Steven Brendtro <steven.brendtro@gmail.com>
 * @link http://www.openach.com/
 * @copyright Copyright &copy; 2011 Imagine Solutions, Ltd
 * @license http://www.openach.com/license/
 */

class BatchBuilderCommand extends CConsoleCommand
{

	public function actionRun()
	{

		/* This needs to build the ACH Batches and ACH Files as follows:
		 * 1.  The users need to set up search criteria for building files (at originator level), assigning criteria per originator_info.
		 * 2.  Using some sort of user-defined search criteria per originator_info, load all matching ach_entry records, joined from originator_info.
		 * 3.  Create a new ACH File record and a ACH Batch record(s) to populate with the ach_entry records we find.
		 */ 
		
		echo 'Building Batches and Files...' . PHP_EOL;
		$originatorInfoIds = AchEntry::model()->getOriginatorInfoForAllUnbatchedQuery()->queryAll();

		foreach( $originatorInfoIds as $originatorInfoRow )
		{
			try
			{
				$dbTrans = Yii::app()->db->beginTransaction();
	
				//$paymentType = PaymentType::model()->findByPk( $paymentTypeRow['payment_type_id'] );
				$originatorInfo = OriginatorInfo::model()->findByPk( $originatorInfoRow['originator_info_id'] );
				if ( ! $originatorInfo )
				{
					throw new Exception( 'Unable to load the originator info.' );
				}

				if ( ! $originatorInfo->odfi_branch )
				{
					// There is no ODFI Branch through which to process, so there is no point in continuing with this originator_info
					continue;
				}

				if ( ! $originatorInfo->payment_types )
				{
					// There are no payment types, so there is no point continuing building batches for this originator_info
					continue;
				}

				// NOTE:  This is actually checking for unbatched entries belonging to BOTH the ODFI Branch and Originator Info
				if ( ! $entryCount = AchEntry::model()->existsUnbatchedForOriginatorInfo( $originatorInfo ) )
				{
					// There are somehow no unbatched entries at this point... 
					// TODO:  This check might be redundant, as our getOriginatorInfoForallUnbatchedQuery might actually cover this.
					continue;
				}

				// Reinitialize the fileLineCount - Each file will start off with 2 lines ( 1 header + 1 control )
				$fileLineCount = 2;

				$achFile = new AchFile();
				$achFile->createFromOdfiBranch( $originatorInfo->odfi_branch );
				if ( ! $achFile->save() )
				{
					throw new Exception( 'Unable to save the ACH file. ' . var_export( $achFile->getErrors() ) );
				}

				echo '---------------------' . PHP_EOL;
				echo 'Saved ACH File Record ' . $achFile->ach_file_id . PHP_EOL;

				// Get the country list specific to this originator (determined by IAT capability)
				if ( $originatorInfo->originator->user->hasIatRole() )
				{
					$countryList = Yii::app()->params['Country']['Payment'];
				}
				else
				{
					$countryList = array( 'US'=>'United States' );
				}

				$batchNumber = 1;

				// Look through each payment type and country combination to see if there are any entries to batch
				foreach ( $originatorInfo->payment_types as $paymentType )
				{
					foreach ( $countryList as $countryCode => $countryName )
					{

						// If no unbatched entries exist for this payment type/country combo, we can skip to the next combo
						if ( ! $entryCount = AchEntry::model()->existsUnbatchedForPaymentType( $paymentType, $countryCode ) )
						{
							continue;
						}

						if ( $countryCode == 'US' )
						{
							$achBatch = new AchBatchPPD();
						}
						else
						{
							$achBatch = new AchBatchIAT();
						}

						$achBatch->createFromPaymentType( $paymentType );

						// Get the lead time for this transaction type (for advanced processing)
						$leadTime = Yii::app()->params['AchBatch']['LeadTime'][ $paymentType->payment_type_transaction_type ];
						$batchDate = new DateTime();
						$batchDate->add( new DateInterval( 'P' . $leadTime . 'D' ) );

						// Initialize the batch effective and descriptive dates
						$achBatch->setDates( $batchDate );

						// Set the file id
						$achBatch->ach_batch_ach_file_id = $achFile->ach_file_id;

						if ( ! $achBatch->save() )
						{
							var_dump( $achBatch->ach_batch_header_originating_dfi_id );
							throw new Exception( 'Unable to save the ACH batch. ' . var_export( $achBatch->getErrors() ) );
						}

						$updateCount = $achBatch->addUnbatchedEntriesByPaymentType( $paymentType, $countryCode );

						if ( ! $updateCount )
						{
							throw new Exception( 'Unable to add unbatched ACH entry records by payment type on this batch.' );
						}
						if ( $updateCount != $entryCount )
						{
							throw new Exception( 'Added more entries to the batch than were originally found. Originally found ' . $entryCount . ' entries but updated ' . $updateCount . ' entries.');
						}

						// Update all the entry trace numbers for this batch
						$achBatch->setEntryTraceNumbersForBatch();

						// Increment the counts for the file
						$achFile->ach_file_control_entry_addenda_count += $updateCount;
						$achFile->ach_file_control_batch_count++;

						if ( $achBatch->ach_batch_header_standard_entry_class == 'IAT' )
						{
							// Each IAT entry has 8 lines (1 detail + 7 addenda)
							$fileLineCount += $updateCount * 8;
						}
						else
						{
							// Each PPD entry has 1 line
							$fileLineCount += $updateCount;
						}

						// Add 2 lines for the batch ( 1 header + 1 control )
						$fileLineCount += 2;
			
						// Calculate totals for this batch
						$achBatch->calculateTotals();
						$achBatch->calculateEntryHash();

						$achBatch->ach_batch_header_batch_number = $batchNumber;
						$achBatch->ach_batch_control_entry_addenda_count = $updateCount;

						if ( ! $achBatch->save() )
						{
							throw new Exception( 'Unable to save batch after recalculating totals.' );
						}
						// Increment the batch number to prepare for the next time through the loop
						$batchNumber++;
					}
				}

				// Calculate totals for the file
				$achFile->calculateTotals();
				$achFile->calculateEntryHash();

				// Update the status to processing
				$achFile->ach_file_status = 'processing';

				// Use the total lines in the file to calculate the block count
				$odfiBranch = OdfiBranch::model()->findByPk( $achFile->ach_file_odfi_branch_id );
				
				$achFile->ach_file_control_block_count = ceil( $fileLineCount / $odfiBranch->getBankConfig()->getBlockingFactor() );

				if ( ! $achFile->save() )
				{
					throw new Exception( 'Unable to save file after recalculating totals.' );
				}

				$dbTrans->commit();
			}
			catch ( Exception $e )
			{
				$dbTrans->rollback();
				// TODO: Log the exception and continue
				// continue;
				// for now, we'll rethrow, which will break the processing for all remaining files and batches
				throw $e;
			}
		}

		$recordCount = 0;

		// for now, simply return.  Remove this when it is working
		return;

		// Each time through the while loop the schedules are updated to their next date
		// Any schedules that are out of date will continue to update until they are current
		while ( $schedules = PaymentSchedule::model()->findAll( $criteria ) )
		{
			foreach ( $schedules as $schedule )
			{
				$schedule->run();
				$recordCount++;
			}
		}
		echo '[' . $recordCount . ']' . PHP_EOL;
	}

}
