<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

class WellsFargoConfig extends OABankConfig
{
	const PLUGIN_CLASS = 'WellsFargoConfig';
	const PLUGIN_VERSION = '0.1';
	const TRANSFER_AGENT = 'SFTP';

 	protected $testModelClass = 'WellsFargoTest';
	protected $confirmationFileReaderClass = 'WellsFargoConfirmationFileReader';
	public $errorMessages = array (
			'01'	=>	'Your file has been received by Wells Fargo. It will be processed subject to standard ACH validation.',
			'02'	=>	'Your file contains invalid effective entry dates. If you have questions, please contact Wells Fargo ACH Services immediately.',
			'03'	=>	'Your control totals do not agree with the total of your detail items. Wells Fargo will process the transactions we have received. If you do not want this file to be processed, please contact Wells Fargo ACH Services immediately.',
			'04'	=>	'Your file failed a secondary edit. Wells Fargo cannot process your ACH file as received. Please contact Wells Fargo ACH Services immediately.',
			'05'	=>	'Severe error while trying to store your file on the Wells Fargo Transaction Depository. Your file failed our initial edit. Wells Fargo cannot process your ACH file as received. Please contact Wells Fargo ACH Services immediately.',
			'06'	=>	'A file with a duplicate qualifier was received. This file and any previous files will continue through normal processing. If this file or an earlier file was sent in error, please contact Wells Fargo ACH Services immediately.',
			'07'	=>	'A file with a duplicate qualifier was received and a new qualifier xxxxxx has been assigned based on time of file receipt. This file and any previous files will continue through normal processing. If this file or an earlier file was sent in error, please contact Wells Fargo ACH Services immediately.',
			'TT'	=>	'This is a test file and will not be processed in production.',
		);
	public $statusMap = array (
			'success' => array( '01', 'TT' ),
			'error' => array( '02', '03', '04', '05', '06', '07' ),
		);

	public function defaults()
	{
		return array(
			'SFTP Username' => '',
			'SFTP Password' => '',
			'SFTP Key' => '',
			'ACH File Path' => 'inbound/',
			'ACH Filename' => 'ACH_transmission.nacha',
			'ACH Confirm Path' => 'outbound/',
			'ACH Confirm Filename' => 'NWCNOD*',
			'ACH Return Path' => 'outbound/',
			'ACH Return Filename' => 'NACORG*',
			'Production SFTP Host' => 'safetrans.wellsfargo.com',
			'Production SFTP Port' => '22',
			'Test SFTP Host' => 'safetransvalidate.wellsfargo.com',
			'Test SFTP Port' => '22',
		);
	}

	public function handleConfirmationMessageCodes( AchFileConf $dataSource )
	{
		$messageCodes = array( $dataSource->message_code_1, $dataSource->message_code_2, $dataSource->message_code_3 );
		$errors = array();

		foreach ( $messageCodes as $code )
		{
			if ( in_array( $code, $this->config->statusMap['error'] ) )
			{
				$errors[$code] = $this->config->errorMessages[$code];
			}
		}

		foreach ( $errors as $code => $message )
		{
			switch ( $code )
			{
				case '02':
					// TODO:  Incorrect effective entry dates on ach_file record, set the ach_file_conf to success
					break;
				case '03':
					// TODO:  Recheck the totals, and notify of a system-level error that causes incorrect totals
					break;
				case '06':
					// TODO:  Duplicate qualifier, potentially duplicate file transmission.  Notify of system-level error that caused a redundant sending of the file
					break;
				case '07':
					// TODO:  Duplicate qualifier, new one assigned, potentially duplicate file transmission.  Notify of system-level error that caused a redundant sending of the file
					break;
				default:
					break;
			}
		}
	}

}

class WellsFargoConfirmationCallback 
{
	public function saveRecord( $dataSource, $recordLine, $caller )
	{
		$dataSource->save();
	}
}

class WellsFargoTest extends OABankTest
{
	
}

class WellsFargoConfirmationFileReader extends OAFileReader
{
	protected $confirmationRecordModel;

	protected function dataSource()
	{
		return new AchFileConf();
	}

	protected function initReaderChain()
	{
		parent::initReaderChain();
		$this->readerChain[] = $this->confirmationRecordModel;
	}
	protected function initRecordModels()
	{
		// Wells Fargo sends the originated file back without the
		// detail (6) and addenda (7) records, and then adds some
		// status codes to the file control (9) record

		parent::initRecordModel();

		// Replace the file control record with our updated version
		$this->controlRecordModel = new WellsFargoConfirmationRecord();
		$this->confirmationRecordModel = $this->controlRecordModel;
	}

}

class WellsFargoConfirmationRecord extends OAFileControlRecord
{

	protected function initRecordFields()
	{
		// Wells Fargo uses the standard NACHA file control (9) record,
		// but repurposes the final reserved field for message codes
		// We will start by initializing the record as usual
		parent::initRecordFields();

		// Remove the final 39 character reserved sfield
		array_pop( $this->recordFields );
		array_pop( $this->recordFieldsMetadata );

		// Now we can repurpose the final 39 chars
		
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
				new ODDataFieldName( 'message_code_1' ),
				new ODFieldRuleLength( 2 ),
				new ODFieldRulePadRight( 2, ' ' )
			)
		);

		$this->addField(
			array(
				new ODDataFieldName( 'message_code_2' ),
				new ODFieldRuleLength( 2 ),
				new ODFieldRulePadRight( 2, ' ' )
			)
		);

		$this->addField(
			array(
				new ODDataFieldName( 'message_code_3' ),
				new ODFieldRuleLength( 2 ),
				new ODFieldRulePadRight( 2, ' ' )
			)
		);

		$this->addField( 
			array(
				new ODDataFieldName( 'reserved' ),
				new ODStaticFieldValue( ' ' ),
				new ODFieldRuleLength( 32 ),
				new ODFieldRulePadRight( 32, ' ' )
			)
		);
		
	}

	public function remapDataSource( OADataSource $dataSource )
	{
		// Handle the message codes (automates fixing some less severe errors)
		$this->config->handleConfirmationMessageCodes( $dataSource );

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
