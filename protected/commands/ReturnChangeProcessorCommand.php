<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

/**
 * ReturnChangeProcessorCommand class file.
 *
 * @author Steven Brendtro <steven.brendtro@gmail.com>
 * @link http://www.openach.com/
 * @copyright Copyright &copy; 2011 Imagine Solutions, Ltd
 * @license http://www.openach.com/license/
 */

class ReturnChangeProcessorCommand extends CConsoleCommand
{

	public function actionRun()
	{
		// Load all odfi_branches having files with status of 'transferred' or 'confirmed' within the last 60 days
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
		$dateCheck = "ach_file_datetime <= :sixtyday";
	
		$odfiBranchIds = Yii::app()->db->createCommand()
			->selectDistinct( 'ach_file_odfi_branch_id' )
			->from( 'ach_file' )
			->where(	array(
						'AND',
						'ach_file_status IN ( :file_status_transferred, :file_status_confirmed )',
						$dateCheck
					),
					array(
						':file_status_transferred' => 'transferred',
						':file_status_confirmed' => 'confirmed',
						':sixtyday' => date('Y-m-d', strtotime($sixtyDayValue))
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
			$this->checkReturnChange( $odfiBranch );
		}

		return;
	}

	public function actionLoadFile( $file_name, $odfi_branch_id )
	{
		if ( ! $odfiBranch = OdfiBranch::model()->findByPk( $odfi_branch_id ) )
		{
			throw new Exception( 'Unable to load odfi branch with id ' . $odfi_branch_id );
		}

		$transferAgent = $odfiBranch->getBankConfig()->getLocalTransferAgent();

		echo 'Reading return/change file from ' . $file_name . PHP_EOL;

		if ( $returnChangeFile = $transferAgent->getFile( $file_name ) )
		{
			$fileTransfer = FileTransfer::createNewTransfer( $odfiBranch, $odfiBranch->getBankConfig(), $transferAgent, $returnChangeFile );

			if ( ! $fileTransfer->save() )
			{
				throw new Exception( 'Unable to save the file transfer.' );
			}
	
			try
			{
				$this->processReturnChange( $fileTransfer, $odfiBranch );
			}
			catch ( Exception $e )
			{
				$fileTransfer->file_transfer_status = 'failed';
				$fileTransfer->file_transfer_message = $e->getMessage();
				if ( ! $fileTransfer->save() )
				{
					throw new Exception( 'Unable to save the file transfer after marking it as failed.' );
				}

				return;
			}

			$fileTransfer->file_transfer_status = 'processed';
			if ( ! $fileTransfer->save() )
			{
				throw new Exception( 'Unable to save file transfer after marking it as processed.' );
			}
			
		}

	}

	protected function checkReturnChange( $odfiBranch )
	{
		$transferAgent = $odfiBranch->getBankConfig()->getTransferAgent();

		echo 'Checking for return/change file from ' . $odfiBranch->odfi_branch_name . PHP_EOL;

		if ( $returnChangeFile = $transferAgent->getReturnChange() )
		{
echo $returnChangeFile;
			$fileTransfer = FileTransfer::createNewTransfer( $odfiBranch, $odfiBranch->getBankConfig(), $transferAgent, $returnChangeFile );

			if ( ! $fileTransfer->save() )
			{
				throw new Exception( 'Unable to save the file transfer.' );
			}

			try
			{
				$this->processReturnChange( $fileTransfer, $odfiBranch );
			}
			catch ( Exception $e )
			{
				$fileTransfer->file_transfer_status = 'failed';
				$fileTransfer->file_transfer_message = $e->getMessage();

				if ( ! $fileTransfer->save() )
				{
					throw new Exception( 'Unable to save the file transfer after marking it as failed.' );
				}

				return;
			}

			$fileTransfer->file_transfer_status = 'processed';
			if ( ! $fileTransfer->save() )
			{
				throw new Exception( 'Unable to save file transfer after marking it as processed.' );
			}
		}
else {
	throw new Exception( 'Unable to find file!' );
}

	}

	protected function processReturnChange( $fileTransfer, $odfiBranch )
	{
		$config = OABank::factory( $odfiBranch );

		$fileReader = $config->getReturnChangeFileReader();

		echo 'Processing return/change file from ' . $odfiBranch->odfi_branch_name . PHP_EOL;

		// Create a temp file in memory with no size limit (PHP max memory size will set the limit)
		$achFile = new SplTempFileObject(-1);
		if ( ! $achFile->fwrite( $fileTransfer->file_transfer_data ) )
		{
			// If we make it here, either there was 0 bytes written to the file, or an error occurred (null)
			throw new Exception( 'Unable to write transferred file to temp memory file.' );
		}

		// After writing to the file, we need to rewind to the beginning
		$achFile->rewind();

		$fileReader->parseFile( $achFile );
	}

}

