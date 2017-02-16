<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

class OAReturnChangeReaderCallback
{
	public $odfi_branch_id = '';

	public function handleRecord( $dataSource, $recordLine, $caller )
	{
		if ( ! $this->odfi_branch_id )
		{
			throw new Exception( 'The odfi_branch_id must be set to properly handle return/change records.' );
		}
		/*
		// Handle AchFile only when looking at a file header record
		if ( $dataSource instanceof AchFile && substr( $recordLine, 0, 1 ) == '1' )
		{

			// We don't do any processing on the file header record, only check that it exists...

			// Look for the OpenACH file ID
			if ( $dataSource->ach_file_header_reference_code )
			{
				if ( $achFile = AchFile::model()->findByAttributes( 
					array( 
						'ach_file_header_reference_code' => $dataSource->ach_file_header_reference_code,
						'ach_file_odfi_branch_id' => $this->odfi_branch_id
					) ) )
				{
					$dataSource = $achFile;
				}
				else
				{
					throw new Exception( 'Unable to find the ach_file record for odfi branch ' . $this->odfi_branch_id . ' with reference code ' . $dataSource->ach_file_header_reference_code );
				}
			}
			else
			{
				throw new Exception( 'Unable to load the ach_file record.  No reference code provided.' );
			}
			
		}
		*/
		// We don't do any processing for file control, batch header, or batch control records
		// We don't have to check for the record indicator, as AchEntry will have parsed the 6 and all 7 records and therefore contains a combined record of the entry
		if ( $dataSource instanceof AchEntry )
		{
			if ( $dataSource->ach_entry_detail_individual_id_number )
			{
				if ( ! $achEntry = AchEntry::model()->findByAttributes( 
					array( 
						'ach_entry_detail_individual_id_number' => $dataSource->ach_entry_detail_individual_id_number,
						'ach_entry_odfi_branch_id' => $this->odfi_branch_id
					) ) )
				{
					throw new Exception( 'Unable to load the ach_entry for odfi branch ' . $this->odfi_branch_id . ' with individual ID number ' . $dataSource->ach_entry_detail_individual_id_number );
				}
			
				// Just for sanity, check that the amount is the same in the file as it is in the database.
				// Note that we check first that the amount is set, as COR(change) records may leave it set to zero
				if ( $dataSource->ach_entry_detail_amount && $achEntry->ach_entry_detail_amount != $dataSource->ach_entry_detail_amount )
				{
					throw new Exception( 'Amount mismatch on ach_entry record with ID ' . $achEntry->ach_entry_id . ' (individual id number of ' . $dataSource->ach_entry_detail_individual_id_number . ').  Amount expected was ' . $achEntry->ach_entry_detail_amount . ' but found amount ' . $dataSource->ach_entry_detail_amount );
				}
				
				// Check to see that there is not already a comparable return/change in the system for this record
				if ( $achEntryReturn = AchEntryReturn::model()->findByAttributes( array( 
							'ach_entry_return_ach_entry_id' => $achEntry->ach_entry_id,
							'ach_entry_return_return_reason_code' => $achEntry->ach_entry_return_return_reason_code,
							'ach_entry_return_change_code' => $achEntry->ach_entry_return_change_code,
						) ) )
				{
					throw new Exception( 'An ach_entry_return record already exists for ach_entry ' . $achEntry->ach_entry_id 
							. ', return reason "' . $dataSource->ach_entry_return_return_reason_code . '", or change code "' . $dataSource->ach_entry_return_change_code . '"' );
				}
				
				$dbTransaction = Yii::app()->db->beginTransaction();
				
				try
				{
					// Merge the entry return with the entry from the database
					$achEntry->merge( $dataSource );

					// Create a new ach_entry_return record for this return/change
					$achEntryReturn = new AchEntryReturn();
					$achEntryReturn->createFromEntry( $achEntry );
					if ( ! $achEntryReturn->save() )
					{
						throw new Exception( 'Unable to save ach_entry_return for the ach_entry record with ID ' . $achEntry->ach_entry_id . ' (individual id of ' . $achEntry->ach_entry_detail_individual_id_number . ').' );
					}

					// If this is a return, update the status of the original ach_entry					
					if ( $achEntryReturn->ach_entry_return_return_reason_code )
					{
						if ( ! $achEntry->updateStatusReturned() )
						{
							throw new Exception( 'Unable to update status of ach_entry ' . $achEntry->ach_entry_id . ' to "returned".' );
						}
					}

					// If this is a change, update the changed information
					if ( $achEntryReturn->ach_entry_return_change_code )
					{
						switch ( $achEntryReturn->ach_entry_return_change_code )
						{
							// Incorrect Bank Account Number
							case 'C01':
								break;
							default:
								break;
						}
					}
					
					$dbTransaction->commit();
				}
				catch ( Exception $e )
				{
					$dbTransaction->rollback();
					//throw $e;
				}			
				
			}
			else
			{
				throw new Exception( 'Unable to load the ach_entry record.  No individual ID number provided.' );
			}
		}
			
	}
}
