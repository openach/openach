<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

class OAConfirmationReaderCallback extends OAReaderCallback
{
	public function handleRecord( $dataSource, $recordLine, $caller )
	{
return;
// TODO:  process whatever data source that is passed back from the bank config reader...
		// Handle AchFile only when looking at a file header record
		if ( $dataSource instanceof AchFile && substr( $recordLine, 0, 1 ) == '1' )
		{

			// We don't do any processing on the file header record, only check that it exists...

			// Look for the OpenACH file ID
			if ( $dataSource->ach_file_header_reference_code )
			{
				if ( $achFile = AchFile::model()->findByAttributes( array( 'ach_file_header_reference_code' => $dataSource->ach_file_header_reference_code ) ) )
				{
					$dataSource = $achFile;
				}
				else
				{
					throw new Exception( 'Unable to find the ach_file record with reference code ' . $dataSource->ach_file_header_reference_code );
				}
			}
			else
			{
				throw new Exception( 'Unable to load the ach_file record.  No reference code provided.' );
			}
			
		}
		// We don't do any processing for file control, batch header, or batch control records
		// We don't have to check for the record indicator, as AchEntry will have parsed the 6 and all 7 records and therefore contains a combined record of the entry
		elseif ( $dataSource instanceof AchEntry )
		{
			if ( $dataSource->ach_entry_detail_individual_id_number )
			{
				if ( ! $achEntry = AchEntry::model()->findByAttributes( array( 'ach_entry_detail_individual_id_number' => $dataSource->ach_entry_detail_individual_id_number ) ) )
				{
					throw new Exception( 'Unable to load the ach_entry with individual ID ' . $dataSource->ach_entry_detail_individual_id_number );
				}
				
				// Just for sanity, check that the amount is the same in the file as it is in the database.
				if ( ! $achEntry->ach_entry_detail_amount != $dataSource->ach_entry_detail_amount )
				{
					throw new Exception( 'Amount mismatch on ach_entry record with ID ' . $achEntry->ach_entry_id . ' (individual id of ' . $dataSource->ach_entry_detail_individual_id_number . ').  Amount expected was ' . $achFile->ach_entry_detail_amount . ' but found amount ' . $dataSource->ach_entry_detail_amount );
				}
				
				// Check to see that there is not already a comparable return/change in the system for this record
				if ( $achEntryReturn = AchEntry::model()->findByAttributes( array( 
							'ach_entry_return_ach_entry_id' => $achEntry->ach_entry_id,
							'ach_entry_return_return_reason_code' => $achEntry->ach_entry_return_return_reason_code,
							'ach_entry_return_change_code' => $achEntry->ach_entry_return_change_code,
						) ) )
				{
					throw new Exception( 'An ach_entry_return record already exists for ach_entry ' . $achEntry->ach_entry_id 
							. ', return reason "' . $achEntry->ach_entry_return_return_reason_code . '", and change code "' . $achEntry->ach_entry_return_change_code . '"' );
				}
				
				$dbTransaction = Yii::app()->db->beginTransaction();
				
				try
				{
					// Create a new ach_entry_return record for this return/change
					$achEntryReturn = AchEntryReturn::model()->createFromEntry( $achEntry );
					if ( ! $achEntryReturn->save() )
					{
						throw new Exception( 'Unable to save ach_entry_return for the ach_entry record with ID ' . $achEntry->ach_entry_id . ' (individual id of ' . $dataSource->ach_entry_detail_individual_id_number . ').' );
					}

					// If this is a return, update the status of the original ach_entry					
					if ( $achEntryReturn->ach_entry_return_return_reason_code )
					{
						if ( ! $achEntry->updateStatusReturned() )
						{
							throw new Exception( 'Unable to update status of ach_entry ' . $achEntry->ach_entry_id . ' to "returned".' );
						}
					}
					
					$dbTransaction->commit();
				}
				catch ( Exception $e )
				{
					$dbTransaction->rollback();
					throw $e;
				}			
				
			}
			else
			{
				throw new Exception( 'Unable to load the ach_entry record.  No individual ID number provided.' );
			}
		}
			
	}

}
