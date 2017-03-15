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

class AltBatchBuilderCommand extends CConsoleCommand
{

	public function actionRun()
	{

		/* This needs to build the ACH Batches and ACH Files as follows:
		 * 1.  The users need to set up search criteria for building files (at originator level), assigning criteria per originator_info.
		 * 2.  Using some sort of user-defined search criteria per originator_info, load all matching ach_entry records, joined from originator_info.
		 * 3.  Create a new ACH File record and a ACH Batch record(s) to populate with the ach_entry records we find.
		 */ 
		
		echo 'Building Batches and Files...' . PHP_EOL;

		$command = AchEntry::model()->getAllUnbatchedQuery();
		$command->selectDistinct( 'odfi_branch.odfi_branch_id' );
		$odfiBranches = $command->queryAll();

		// Each Odfi Branch will have its own file
		foreach ( $odfiBranches as $odfiBranchRow )
		{

			// Load the Odfi Branch and use it to create a new Ach File
			$odfiBranch = OdfiBranch::model()->findByPk( $odfiBranchRow['odfi_branch_id'] );
			$achFile = new AchFile();
			$achFile->createFromOdfiBranch( $odfiBranch );

			// Initialize the batch numbering
			$batchNumber = 0;

			// Reinitialize the fileLineCount - Each file will start off with 2 lines ( 1 header + 1 control )
			$fileLineCount = 2;

			if ( ! $achFile->save() )
			{
				throw new Exception( 'Unable to save ACH File.' );
			}

			// Find all the originator info ids for this branch that have unbatched Ach Entries
			$criteria = new CDbCriteria();
			$criteria->addCondition( 'odfi_branch_id = :odfi_branch_id' );
			$criteria->params = array( ':odfi_branch_id' => $odfiBranchRow['odfi_branch_id'] );

			$command = AchEntry::model()->getAllUnbatchedQuery( $criteria );

			$originatorInfoIds = $command->selectDistinct( 'originator_info_id' )->queryAll();

			try
			{

				$dbTrans = Yii::app()->db->beginTransaction();

				foreach( $originatorInfoIds as $originatorInfoRow )
				{
	
					$originatorInfo = OriginatorInfo::model()->findByPk( $originatorInfoRow['originator_info_id'] );
					if ( ! $originatorInfo )
					{
						throw new Exception( 'Unable to load the originator info.' );
					}

					if ( ! $originatorInfo->payment_types )
					{
						// There are no payment types, so there is no point continuing building batches for this originator_info
						$dbTrans->rollback();
						continue;
					}

					if ( ! $entryCount = AchEntry::model()->existsUnbatchedForOriginatorInfo( $originatorInfo ) )
					{
						// There are somehow no unbatched entries at this point... 
						// TODO:  This check is redundant, as our getAllUnbatchedQuery might actually cover this.
						$dbTrans->rollback();
						continue;
					}

					// Get the country list specific to this originator (determined by IAT capability)
					if ( $originatorInfo->originator->user->hasIatRole() )
					{
						$countryList = Yii::app()->params['Country']['Payment'];
					}
					else
					{
						$countryList = array( 'US'=>'United States' );
					}

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

							// Increment batch number
							$batchNumber++;

							$achBatch->createFromPaymentType( $paymentType );

							// Assign the Ach File ID
							$achBatch->ach_batch_ach_file_id = $achFile->ach_file_id;

							// Get the lead time for this transaction type (for advanced processing)
							$leadTime = Yii::app()->params['AchBatch']['LeadTime'][ $paymentType->payment_type_transaction_type ];
							$batchDate = new DateTime();
							$batchDate->add( new DateInterval( 'P' . $leadTime . 'D' ) );

							// Initialize the batch effective and descriptive dates
							$achBatch->setDates( $batchDate );

							if ( ! $achBatch->save() )
							{
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

							if ( $achBatch->ach_batch_header_standard_entry_class == 'IAT' )
							{
								// Each IAT entry has 8 lines (1 detail + 7 addenda)
								$batchEntryAddendaCount = $updateCount * 8;
							}
							else
							{
								// Each PPD entry has 1 line
								$batchEntryAddendaCount = $updateCount;
							}

							$fileLineCount += $batchEntryAddendaCount;

							// Add 2 lines for the batch ( 1 header + 1 control )
							$fileLineCount += 2;

							// Update all the entry trace numbers for this batch
							$achBatch->setEntryTraceNumbersForBatch();

							// Calculate totals for this batch
							$achBatch->calculateTotals();
							$achBatch->calculateEntryHash();

							$achBatch->ach_batch_header_batch_number = $batchNumber;
							$achBatch->ach_batch_control_entry_addenda_count = $batchEntryAddendaCount;

							// Increment the batch count on the file
							$achFile->ach_file_control_batch_count++;
							// Add the total entries/addenda from this batch to the file totals
							$achFile->ach_file_control_entry_addenda_count += $batchEntryAddendaCount;


							$odfiBranch->getBankConfig()->beforeRecordSave( $achBatch );
							if ( ! $achBatch->save() )
							{
								throw new Exception( 'Unable to save batch after recalculating totals.' );
							}

							// Refresh the ActiveRecord so the relations will work properly
							$achBatch->refresh();

							// If there is a settlement account on the payment type, we can create a settlement entry for this batch
							if ( $achBatch->payment_type && $achBatch->payment_type->external_account )
							{
								echo 'Creating a settlement record for the ACH Batch ' . $achBatch->ach_batch_id . ' using payment type ' . $achBatch->payment_type->payment_type_id . '.' . PHP_EOL;

								// Create a settlement record
								$settlement = new Settlement();
								// This creates and saves the AchEntry as well
								$settlement->createFromAchBatch( $achBatch );
								if ( ! $settlement->save() )
								{
									throw new Exception( 'Unable to save the settlement record for this batch.' );
								}
							}
						}
					}

				}

				// Calculate totals for the file
				$achFile->calculateTotals();
				$achFile->calculateEntryHash();

				// Update the status to processing
				$achFile->ach_file_status = 'processing';

				// Use the total lines in the file to calculate the block count
				$achFile->ach_file_control_block_count = ceil( $fileLineCount / $odfiBranch->getBankConfig()->getBlockingFactor() );

				echo 'Saving AchFile [' . $achFile->ach_file_id . '] with ' . $achFile->ach_file_control_entry_addenda_count . ' entries and ' . $achFile->ach_file_control_batch_count . ' batches.' . PHP_EOL;

				$odfiBranch->getBankConfig()->beforeRecordSave( $achFile );
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

	}

}
