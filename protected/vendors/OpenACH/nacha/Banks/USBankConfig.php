<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

class USBankConfig extends OABankConfig
{
	const PLUGIN_CLASS = 'USBankConfig';
	const PLUGIN_VERSION = '0.1';
	const TRANSFER_AGENT = 'SFTP';

 	protected $testModelClass = 'USBankTest';
	protected $confirmationFileReaderClass = 'USBankConfirmationFileReader';
	protected $confirmationFileReaderCallbackClass = 'USBankConfirmationReaderCallback';
	protected $gatewayDfiId = '091050234'; // NOTE!  This is Canada's... Europe, Mexico and Panama have their own
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
			'ACH File Path' => '',
			'ACH Filename' => '',
			'ACH Confirm Path' => '',
			'ACH Confirm Filename' => '',
			'ACH Return Path' => '',
			'ACH Return Filename' => '',
			'Production SFTP Host' => 'ftpsb.usbank.com',
			'Production SFTP Port' => '20022',
			'Test SFTP Host' => 'ftpst.usbank.com',
			'Test SFTP Port' => '20022',
		);
	}
}

class USBankTest extends OABankTest
{
	
}

class USBankConfirmationFileReader extends ODReader
{
	protected $confirmationRecordModel;
	
	protected function initReaderChain()
	{
		$this->readerChain[] = $this->confirmationRecordModel;
	}
	protected function initRecordModels()
	{
		$this->confirmationRecordModel = new USBankConfirmationRecord();
	}
}

class USBankConfirmationRecord extends OARecord
{

	protected function initRecordFields()
	{
		$this->addField( 
			array(
				new ODDataFieldName( 'customer_point_name' ),
				new ODFieldRuleLength( 9 )
			)
		);
		
		$this->addField( 
			array(
				new ODDataFieldName( 'reserved' ),
				new ODStaticFieldValue( ' ' ),
				new ODFieldRuleLength( 2 ),
				new ODFieldRulePadRight( 2, ' ' ) 
			)
		);
		
		$this->addField(
			array(
				new ODDataFieldName( 'customer_name_description' ),
				new ODFieldRuleLength( 30 ),
				new ODFieldRulePadRight( 30, ' ' ) 
			)
		);

		$this->addField( 
			array(
				new ODDataFieldName( 'reserved' ),
				new ODStaticFieldValue( ' ' ),
				new ODFieldRuleLength( 2 ),
				new ODFieldRulePadRight( 2, ' ' ) 
			)
		);
		
		$this->addField(
			array(
				new ODDataFieldName( 'preprocessor_dataset_name' ),
				new ODFieldRuleLength( 24 ),
				new ODFieldRulePadRight( 24, ' ' ) 
			)
		);

		$this->addField( 
			array(
				new ODDataFieldName( 'reserved' ),
				new ODStaticFieldValue( ' ' ),
				new ODFieldRuleLength( 2 ),
				new ODFieldRulePadRight( 2, ' ' ) 
			)
		);
		
		$this->addField(
			array(
				new ODDataFieldName( 'delivery_method_file_confirmation' ),
				new ODFieldRuleLength( 1 ),
				new ODFieldRulePadRight( 1, ' ' ) 
			)
		);

		$this->addField( 
			array(
				new ODDataFieldName( 'reserved' ),
				new ODStaticFieldValue( ' ' ),
				new ODFieldRuleLength( 2 ),
				new ODFieldRulePadRight( 2, ' ' ) 
			)
		);
		
		$this->addField(
			array(
				new ODDataFieldName( 'file_total_requirements' ),
				new ODFieldRuleLength( 1 ),
				new ODFieldRulePadRight( 1, ' ' ) 
			)
		);

		$this->addField( 
			array(
				new ODDataFieldName( 'reserved' ),
				new ODStaticFieldValue( ' ' ),
				new ODFieldRuleLength( 2 ),
				new ODFieldRulePadRight( 2, ' ' ) 
			)
		);
		
		$this->addField(
			array(
				new ODDataFieldName( 'file_confirmation_date' ),
				new ODFieldRuleLength( 6 )
			)
		);

		$this->addField( 
			array(
				new ODDataFieldName( 'reserved' ),
				new ODStaticFieldValue( ' ' ),
				new ODFieldRuleLength( 1 ),
				new ODFieldRulePadRight( 1, ' ' ) 
			)
		);
		
		$this->addField(
			array(
				new ODDataFieldName( 'file_confirmation_time' ),
				new ODFieldRuleLength( 6 )
			)
		);

		$this->addField( 
			array(
				new ODDataFieldName( 'reserved' ),
				new ODStaticFieldValue( ' CREATE  ' ),
				new ODFieldRuleLength( 9 )
			)
		);
		
		
		$this->addField(
			array(
				new ODDataFieldName( 'file_creation_date' ),
				new ODFieldRuleLength( 6 )
			)
		);

		$this->addField( 
			array(
				new ODDataFieldName( 'reserved' ),
				new ODStaticFieldValue( ' ' ),
				new ODFieldRuleLength( 1 ),
				new ODFieldRulePadRight( 1, ' ' ) 
			)
		);
		
		$this->addField(
			array(
				new ODDataFieldName( 'file_creation_time' ),
				new ODFieldRuleLength( 4 )
			)
		);

		// US Bank thoughtfully adds seconds, however they are not included in NACHA's format for files, so we split them out
		$this->addField(
			array(
				new ODDataFieldName( 'file_creation_time_seconds' ),
				new ODFieldRuleLength( 2 )
			)
		);

		$this->addField( 
			array(
				new ODDataFieldName( 'reserved' ),
				new ODStaticFieldValue( ' ' ),
				new ODFieldRuleLength( 2 ),
				new ODFieldRulePadRight( 2, ' ' ) 
			)
		);
		
		$this->addField(
			array(
				new ODDataFieldName( 'file_modifier_id' ),
				new ODFieldRuleLength( 1 )
			)
		);

		$this->addField( 
			array(
				new ODDataFieldName( 'reserved' ),
				new ODStaticFieldValue( ' ' ),
				new ODFieldRuleLength( 2 ),
				new ODFieldRulePadRight( 2, ' ' ) 
			)
		);
		
		$this->addField(
			array(
				new ODDataFieldName( 'batch_count' ),
				new ODFieldRuleLength( 6 ),
				new ODFieldRulePadLeft( 6, 0 )
			)
		);

		$this->addField( 
			array(
				new ODDataFieldName( 'reserved' ),
				new ODStaticFieldValue( ' IT ' ),
				new ODFieldRuleLength( 4 )
			)
		);

		$this->addField(
			array(
				new ODDataFieldName( 'batch_item_count' ),
				new ODFieldRuleLength( 8 ),
				new ODFieldRulePadLeft( 8, 0 )
			)
		);

		$this->addField( 
			array(
				new ODDataFieldName( 'reserved' ),
				new ODStaticFieldValue( ' DR ' ),
				new ODFieldRuleLength( 4 )
			)
		);

		$this->addField(
			array(
				new ODDataFieldName( 'debit_amount' ),
				new ODFieldRuleLength( 12 ),
				new ODFieldRulePadLeft( 12, 0 )
			)
		);

		$this->addField( 
			array(
				new ODDataFieldName( 'reserved' ),
				new ODStaticFieldValue( ' CR ' ),
				new ODFieldRuleLength( 4 )
			)
		);

		$this->addField(
			array(
				new ODDataFieldName( 'credit_amount' ),
				new ODFieldRuleLength( 12 ),
				new ODFieldRulePadLeft( 12, 0 )
			)
		);

		$this->addField( 
			array(
				new ODDataFieldName( 'reserved' ),
				new ODStaticFieldValue( ' ' ),
				new ODFieldRuleLength( 1 )
			)
		);


		$this->addField(
			array(
				new ODDataFieldName( 'fatal_error_message_number' ),
				new ODFieldRuleLength( 3 ),
				new ODFieldRulePadRight( 3, ' ' )
			)
		);

		$this->addField( 
			array(
				new ODDataFieldName( 'reserved' ),
				new ODStaticFieldValue( ' ' ),
				new ODFieldRuleLength( 2 ),
				new ODFieldRulePadRight( 2, ' ' ) 
			)
		);

		$this->addField(
			array(
				new ODDataFieldName( 'more_fatal_errors' ),
				new ODFieldRuleLength( 1 )
			)
		);

		$this->addField( 
			array(
				new ODDataFieldName( 'reserved' ),
				new ODStaticFieldValue( ' ' ),
				new ODFieldRuleLength( 2 ),
				new ODFieldRulePadRight( 2, ' ' ) 
			)
		);

		$this->addField(
			array(
				new ODDataFieldName( 'error_message' ),
				new ODFieldRuleLength( 70 ),
				new ODFieldRulePadRight( 70, ' ' )
			)
		);

		$this->addField( 
			array(
				new ODDataFieldName( 'reserved' ),
				new ODStaticFieldValue( ' ' ),
				new ODFieldRuleLength( 2 ),
				new ODFieldRulePadRight( 2, ' ' ) 
			)
		);

		$this->addField(
			array(
				new ODDataFieldName( 'error_message_2' ),
				new ODFieldRuleLength( 70 ),
				new ODFieldRulePadRight( 70, ' ' )
			)
		);

		$this->addField( 
			array(
				new ODDataFieldName( 'reserved' ),
				new ODStaticFieldValue( ' ' ),
				new ODFieldRuleLength( 2 ),
				new ODFieldRulePadRight( 2, ' ' ) 
			)
		);
		
		$this->addField(
			array(
				new ODDataFieldName( 'billing_account_routing_number' ),
				new ODFieldRuleLength( 9 ),
				new ODFieldRulePadRight( 9, ' ' )
			)
		);

		$this->addField( 
			array(
				new ODDataFieldName( 'reserved' ),
				new ODStaticFieldValue( ' ' ),
				new ODFieldRuleLength( 2 ),
				new ODFieldRulePadRight( 2, ' ' ) 
			)
		);
		
		$this->addField(
			array(
				new ODDataFieldName( 'billing_account_number' ),
				new ODFieldRuleLength( 17 ),
				new ODFieldRulePadRight( 17, ' ' )
			)
		);

		$this->addField( 
			array(
				new ODDataFieldName( 'reserved' ),
				new ODStaticFieldValue( ' ' ),
				new ODFieldRuleLength( 2 ),
				new ODFieldRulePadRight( 2, ' ' ) 
			)
		);
		
		$this->addField( 
			array(
				new ODDataFieldName( 'reserved' ),
				new ODStaticFieldValue( ' ' ),
				new ODFieldRuleLength( 152 ),
				new ODFieldRulePadRight( 152, ' ' ) 
			)
		);
	}
	
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


class USBankConfirmationReaderCallback extends OAConfirmationReaderCallback
{
	public function handleRecord( $dataSource, $recordLine, $caller )
	{
		$criteria = new CDbCriteria;
		$criteria->compare( 'ach_file_odfi_branch_id', $caller->getConfig()->getOdfiBranch()->odfi_branch_id );
		$criteria->compare( 'ach_file_header_file_creation_date', $dataSource->file_creation_date );
		$criteria->compare( 'ach_file_header_file_creation_time', $dataSource->file_creation_time );
		$criteria->compare( 'ach_file_header_file_modifier_id', $dataSource->file_modifier_id );

		if ( ! $achFile = AchFile::model()->find( $criteria ) )
		{
			$filename = $caller->getConfig()->getOdfiBranch()->odfi_branch_id
					. '-' . $dataSource->file_creation_date 
					. $dataSource->file_creation_time 
					. $dataSource->file_modifier_id;
			$this->saveFileOnError( $filename, $caller->getSourceFile() );
			throw new Exception( 'Unable to find ach_file record to match confirmation file.  Saved confirmation file to '. $this->getRuntimePath() . DIRECTORY_SEPARATOR . $filename );
		}

		if ( $dataSource->fatal_error_message == '000' )
		{
	// TODO.... do something with achFile!
			$achFileConf = $achFile->buildAchFileConf();
			$achFileConf->ach_file_conf_status = 'success';
			if ( ! $achFileConf->save() )
			{
				throw new Exception( 'Unable to save ACH file confirmation record.' );
			}
		}

		
	}
}
