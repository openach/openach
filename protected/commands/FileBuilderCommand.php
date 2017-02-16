<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

/**
 * FileBuilderCommand class file.
 *
 * @author Steven Brendtro <steven.brendtro@gmail.com>
 * @link http://www.openach.com/
 * @copyright Copyright &copy; 2011 Imagine Solutions, Ltd
 * @license http://www.openach.com/license/
 */

class FileBuilderCommand extends CConsoleCommand
{

	public function actionRun()
	{

		$criteria = new CDbCriteria();
		$criteria->addCondition( 'ach_file_status = :processing' );
		$criteria->params = array(':processing'=>'processing');
		$achFiles = AchFile::model()->findAll( $criteria );

		foreach ( $achFiles as $achFile )
		{

			// Build (and transfer/save) the file
			$this->buildFile( $achFile );

			// Update the file status
			//$achFile->ach_file_status = 'built';

			// Save the record to ensure the creation date/time and modifier ID are saved
			// along with any fields computed by the File Builder during the build
			if ( ! $achFile->save() )
			{
				throw new Exception( 'Built and saved the ACH file, but was unable to update the AchFile record to mark it as built.' );
			}

		}

		// We may want to save the built files to the database as encrypted for security purposes
		
		// for now, simply return.  Remove this when it is working
		return;
	}

	protected function buildFile( $achFile )
	{

			echo "Building file for '" . $achFile->odfi_branch->odfi_branch_name . "' (" . $achFile->odfi_branch->odfi_branch_id . "), using bank plugin '" . get_class( $achFile->odfi_branch->getBankConfig() ) . "' and transfer plugin '" . get_class( $achFile->odfi_branch->getBankConfig()->getTransferAgent() ) . "'." . PHP_EOL;

			if ( ! Yii::app()->params['AchFile']['EnableFileTransfers'] )
			{
				echo 'WARNING!!!  AchFile transfers are DISABLED!!!  Files will be built, NOT transfered.' . PHP_EOL;
			}
			if ( ! Yii::app()->params['AchFile']['UpdateStatusAfterTransfer'] )
			{
				echo 'WARNING!!!  AchFile status updates are DISABLED!!!  Files will be built, and possibly transferred, on successive FileBuilder runs!  This setting should be used only for debugging purposes ONLY!' . PHP_EOL;
			}

			if ( $builtFile = $achFile->build() )
			{

				if ( Yii::app()->params['AchFile']['SaveLocalCopy'] )
				{
					// The following two lines output the file to a temp folder...
					// but we can do this all in memory to be more secure.
					$fileName = '/tmp/achfiles/AchFileBuildTest-' . $achFile->ach_file_id . '.ach';
					$nachaFile = new SplFileObject( $fileName, 'w' );
					$nachaFile->fwrite( $builtFile );
				}

				$transferAgent = $achFile->odfi_branch->getBankConfig()->getTransferAgent();

				// Transfer the file
				if ( $transferAgent->saveFile( $builtFile, array( 'id' => $achFile->ach_file_id ) ) )
				{
					if ( Yii::app()->params['AchFile']['UpdateStatusAfterTransfer'] )
					{
						// Update the file status
						$achFile->ach_file_status = $transferAgent::AFTER_SAVE_STATUS;
						echo 'Built and saved ach_file ' . $achFile->ach_file_id . ' with status [' . $achFile->ach_file_status . ']' . PHP_EOL;
					}
					else
					{
						echo 'AchFile/UpdateStatusAfterTransfer set to false, so the status will not be updated.  This will result in the file being rebuilt on the next FileBuilder run.' . PHP_EOL;
					}
				}
				else
				{
					echo 'Built file, but the transfer agent failed to save the file.  FileBuilder will attempt to build the file again on the next run.';
					if ( $transferAgent->getTransferMessage() )
					{
						echo 'The error message returned was: ' . $transferAgent->getTransferMessage();
					}
					echo PHP_EOL;
				}

				$fileTransfer = FileTransfer::createNewTransfer( $achFile, $achFile->odfi_branch->getBankConfig(), $transferAgent, $builtFile );
				if ( ! $fileTransfer->save() )
				{
					var_dump( $fileTransfer->getErrors() );
					throw new Exception( 'Unable to save a file transfer record for ACH file ' . $achFile->ach_file_id );
				}

			}
			else
			{
				throw new Exception( 'No lines returned from the file builder.' );
			}
	}


	public function actionReadyToProcess()
	{
		$command = AchEntry::model()->getAllUnbatchedQuery();
		$command->selectDistinct( 'odfi_branch.odfi_branch_id' );
		$odfiBranches = $command->queryAll();

		echo $command->getText(). PHP_EOL;

		// Each Odfi Branch will have its own file
		
		foreach ( $odfiBranches as $odfiBranchRow )
		{
			var_dump( $odfiBranchRow );
		}

		Yii::app()->end();

	}

}

