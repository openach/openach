<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

class SagePayConfig extends OABankConfig
{
	const PLUGIN_CLASS = 'SagePayConfig';
	const PLUGIN_VERSION = '0.1';
	const TRANSFER_AGENT = 'SFTP';

 	protected $testModelClass = 'SagePayTest';
	protected $confirmationFileReaderClass = 'SagePayConfirmationFileReader';
	protected $confirmationFileReaderCallbackClass = 'SagePayConfirmationReaderCallback';

        protected $returnChangeFileReaderClass = 'SagePayReturnChangeFileReader';
        protected $returnChangeFileReaderCallbackClass = 'SagePayReturnChangeReaderCallback';


	public $errorMessages = array (
			'001'	=>	'File sequence error / previous record type Y',
			'002'	=>	'File contains only 1 & 9 Records',
			'003'	=>	'No File Header before First Batch Header; Dummy added',
			'004'	=>	'Debit amounts not equal to calculated amount',
			'005'	=>	'Debit Entry Dollar field not numeric',
			'006'	=>	'Credit Amounts not equal to calculated amount',
			'007'	=>	'Credit Entry Dollar field not numeric',
			'008'	=>	'File trailer record missing; dummy added',
			'009'	=>	'File trailer found not of sequence',
			'010'	=>	'File trailer misplaced in file',
			'011'	=>	'Eff Entry Date is a NON PEP+ business date',
			'012'	=>	'Eff Entry Date is over 60 days from today',
			'013'	=>	'Eff Entry Date is invalid',
			'014'	=>	'Company Entry Description is blank (Susp / Warning) NOT FATAL',
			'015'	=>	'Company ID is blank',
			'016'	=>	'Company Name is blank',
			'017'	=>	'Invalid ODFI ID field',
			'018'	=>	'First Batch Header missing; dummy added',
			'019'	=>	'Invalid total Debit Entry Dollar Field',
			'020'	=>	'Invalid total Credit Entry Dollar Field',
			'021'	=>	'Unable to read PPSCH Calendar for Eff Date',
			'022'	=>	'Requested CA Not Found (Susp / Warning) NOT FATAL  ',
			'023'	=>	'Invalid Transaction Code',
			'024'	=>	'Receiving RT is not numeric',
			'025'	=>	'Invalid Debit / Credit Amount Field',
			'026'	=>	'Prenote TC with Dollar amount >0 (live)',
			'027'	=>	'Invalid Addenda Record Indicator',
			'028'	=>	'Transaction Addenda records exceed 9,999',
			'029'	=>	'Addenda Record was not expected',
			'030'	=>	'Addenda Record is missing',
	    );

	public function defaults()
	{
		return array(
			'SFTP Username' => '',
			'SFTP Password' => '',
			'ACH File Path' => 'Incoming/',
			'ACH Filename' => '{{id}}',
			'ACH Confirm Path' => 'Outgoing/',
			'ACH Confirm Filename' => '*_File_Summary_*.csv',
			'ACH Return Path' => 'Outgoing/',
			'ACH Return Filename' => '*_Merchant_Change_Report_*.csv',
			'Production SFTP Host' => 'ftp.eftchecks.com',
			'Production SFTP Port' => '22',
			'Test SFTP Host' => 'ftp.eftchecks.com',
			'Test SFTP Port' => '22',
		);
	}
}

class SagePayTest extends OABankTest
{
	
}



// Note, SagePay doesn't actually return a file confirmation.  Errors are emailed to the
// email address on file.  Someday this might change and this reader may be useful. 
// Until then, it is simply a placeholder.
class SagePayConfirmationFileReader extends ODReader
{
	protected $confirmationRecordModel;
	
	protected function initReaderChain()
	{
		$this->readerChain[] = $this->confirmationRecordModel;
	}
	protected function initRecordModels()
	{
		$this->confirmationRecordModel = new SagePayConfirmationRecord();
	}
}

// Note, SagePay doesn't actually return a file confirmation.  Errors are emailed to the 
// email address on file.  Someday this might change and this ConfirmationRecord may be useful. 
// Until then, it is simply a placeholder.
class SagePayConfirmationRecord extends OARecord
{

	protected function initRecordFields()
	{
		$this->addField(
			array(
				new ODDataFieldConcat(
					array(
						'file_name',
						'record_count',
						'date_loaded',
						'total_amount',
					), ',' ),
			)
		);

	}

/**
 * This is the model class for table "ach_file_conf".
 *
 * The followings are the available columns in table 'ach_file_conf':
 * @property string $ach_file_conf_id
 * @property string $ach_file_conf_datetime
 * @property string $ach_file_conf_odfi_branch_id
 * @property string $ach_file_conf_status
 * @property string $ach_file_conf_date
 * @property string $ach_file_conf_time
 * @property string $ach_file_conf_batch_count
 * @property string $ach_file_conf_batch_item_count
 * @property string $ach_file_conf_block_count
 * @property string $ach_file_conf_error_message_number
 * @property string $ach_file_conf_error_message
 * @property string $ach_file_conf_total_debits
 * @property string $ach_file_conf_total_credits
 */

	
	public function remapDataSource( OADataSource $dataSource )
	{
		$achFileConf = new AchFileConf();
		if ( $dataSource->fatal_error_message == '000' )
		{
			$achFileConf->ach_file_conf_status = 'success';
		}
		// TODO: Map any meaningful incoming bank confirmation fields to internal fields
		$fieldRemap = array(
				
			);
		$dataSource->remapFields( $fieldRemap );
	}

	protected function readerHasValidDataSource()
	{
		return true;
	}

	protected function recordValidToProcess( $recordLine )
	{
		return true;
	}
}


class SagePayConfirmationReaderCallback extends OAConfirmationReaderCallback
{
	public function handleRecord( $dataSource, $recordLine, $caller )
	{
		$criteria = new CDbCriteria;
		$criteria->compare( 'ach_file_id', $dataSource->file_name );
		$criteria->compare( 'ach_file_odfi_branch_id', $caller->getConfig()->getOdfiBranch()->odfi_branch_id );

		if ( ! $achFile = AchFile::model()->find( $criteria ) )
		{
			$filename = $caller->getConfig()->getOdfiBranch()->odfi_branch_id . '-' . $dataSource->file_name;
			$this->saveFileOnError( $filename, $caller->getSourceFile() );
			throw new Exception( 'Unable to find ach_file record to match confirmation file.  Saved confirmation file to '. $this->getRuntimePath() . DIRECTORY_SEPARATOR . $filename );
		}

		// SagePay only creates the confirmation file on a successful process of the ACH file
		// File errors are emailed directly to the account holder

		$achFileConf = $achFile->buildAchFileConf();
		$achFileConf->ach_file_conf_status = 'success';
		if ( ! $achFileConf->save() )
		{
			$filename = $caller->getConfig()->getOdfiBranch()->odfi_branch_id . '-' . $dataSource->file_name;
			$this->saveFileOnError( $filename, $caller->getSourceFile() );
			throw new Exception( 'Unable to save ACH file confirmation record. Saved confirmation file to ' . $this->getRuntimePath() . DIRECTORY_SEPARATOR . $filename );
		}
	}
}

class SagePayReturnChangeFileReader extends OAReturnChangeReaderCallback
{

}

class SagePayReturnChangeReaderCallback extends OAReturnChangeReaderCallback
{

}
