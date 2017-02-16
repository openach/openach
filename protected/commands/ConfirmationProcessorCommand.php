<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

/**
 * ConfirmationProcessorCommand class file.
 *
 * @author Steven Brendtro <steven.brendtro@gmail.com>
 * @link http://www.openach.com/
 * @copyright Copyright &copy; 2011 Imagine Solutions, Ltd
 * @license http://www.openach.com/license/
 */

class ConfirmationProcessorCommand extends CConsoleCommand
{

	public function actionRun()
	{
		// Load all odfi_branches having files with status of 'transferred' within the last 60 days
		// We will attempt to check for return/change files on those bank plugins...

/*
		if ( Yii::app()->db->schema instanceof CMysqlSchema )
		{
			$dateCheck = 'ach_file_datetime <= DATE_SUB( NOW(), INTERVAL :sixtyday DAY )';
			$sixtyDayValue = 60;
		}
		elseif ( Yii::app()->db->schema instanceof CPgsqlSchema )
		{
			$dateCheck = 'ach_file_datetime >= current_date - INTERVAL :sixtyday';
			$sixtyDayValue =  '60 days';
		}
		elseif ( Yii::app()->db->schema instanceof CSqliteSchema )
		{
			$dateCheck = 'ach_file_datetime >= date(\'now\', \'-:sixtyday\')';
			$sixtyDayValue =  '60 days';
		}
		else
		{
			throw new CException( 'Only MySQL, Postgresql, and SQLite are currently supported.' );
		}
*/
		$dateCheck = "payment_schedule_next_date <= :sixtday";
	
		$odfiBranchIds = Yii::app()->db->createCommand()
			->selectDistinct( 'ach_file_odfi_branch_id' )
			->from( 'ach_file' )
			->where(	array(
						'AND',
						'ach_file_status = :file_status_transferred',
						$dateCheck
					),
					array(
						':file_status_transferred' => 'transferred',
						':sixtyday' => date('Y-m-d', strtotime($sixtyDayValue)),
					)
						//':sixtyday' => $sixtyDayValue
				)
			->query();

		foreach ( $odfiBranchIds as $odfiBranchId )
		{
			if ( ! $odfiBranch = OdfiBranch::model()->findByPk( $odfiBranchId['ach_file_odfi_branch_id'] ) )
			{
				continue;
			}

			// check for a confirmation of the file
			$this->checkConfirmation( $odfiBranch );
		}

		return;
	}

	protected function checkConfirmation( $odfiBranch )
	{
		$transferAgent = $odfiBranch->getBankConfig()->getTransferAgent();

		echo 'Checking for confirmation file from ' . $odfiBranch->odfi_branch_name . PHP_EOL;

		if ( $confirmationFile = $transferAgent->getConfirmation() )
		{
			$fileTransfer = FileTransfer::createNewTransfer( $odfiBranch, $odfiBranch->getBankConfig(), $transferAgent, $confirmationFile );

			if ( ! $fileTransfer->save() )
			{
				throw new Exception( 'Unable to save the file transfer.' );
			}

			$this->processConfirmation( $fileTransfer, $odfiBranch );
		}
	}

	protected function processConfirmation( $fileTransfer, $odfiBranch )
	{
		$config = OABank::factory( $odfiBranch );

		// Get a file reader specific to this odfiBranch.  The bank config will set up the appropriate callbacks for processing
		$fileReader = $config->getConfirmationFileReader();

		echo 'Processing confirmation file from ' . $odfiBranch->odfi_branch_name . PHP_EOL;

		// Create a temp file in memory with no size limit (PHP max memory size will set the limit)
		$confrimFile = new SplTempFileObject(-1);
		if ( ! $confirmFile->fwrite( $fileTransfer->file_transfer_data ) )
		{
			// If we make it here, either there was 0 bytes written to the file, or an error occurred (null)
			throw new Exception( 'Unable to write transferred file to temp memory file.' );
		}

		// After writing to the file, we need to rewind to the beginning
		$confirmFile->rewind();

		// Run the file through the file reader for parsing/processing
		$fileReader->parseFile( $confirmFile );
	}

}

