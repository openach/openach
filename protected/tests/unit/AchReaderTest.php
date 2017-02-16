<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

Yii::import( 'application.tests.OADbTestCase' );
Yii::import( 'application.vendors.OpenACH.nacha.*' );
class AchReaderTest extends OADbTestCase
{
	protected $readFileName = 'misc/20110805A.ach';
	protected $odfiBranchId = '17d75ec4-bd49-11e0-b684-00163e4c6b77';

	public $fixtures=array(
		'odfiBranches'=>'OdfiBranch',
		'externalAccounts'=>'ExternalAccount',
	);

	public function testReader()
	{
		print '================' . PHP_EOL;
		print 'AchReaderTest loads a valid NACHA file and uses the CActiveRecord models to save them to the database.' . PHP_EOL;
		$this->truncateAchTables();

		$odfiBranch = OdfiBranch::model()->find( 'odfi_branch_id=:odfi_branch_id', array( ':odfi_branch_id' => $this->odfiBranchId ) );
		
		if ( ! $odfiBranch )
		{
			throw new Exception( 'Unable to load odfi_branch.' );
		}

		$config = OABank::factory( $odfiBranch );
		$readerCallback = new AchReaderCallback();

		$fileReader = new OAFileReader( $config );
		$fileReader->addCallback( $readerCallback, 'saveRecord' );

		$fileName = $this->readFileName;
		print 'Opening file ' . $fileName . ' for import.' . PHP_EOL;

		$achFile = new SplFileObject( $fileName );

		print 'Parsing file... (this may take a moment)' . PHP_EOL;
		$fileReader->parseFile( $achFile );

		print 'Processed ' . $readerCallback->recordCount . ' lines.' . PHP_EOL;
		print 'Saved ' . $readerCallback->recordSaveCount . ' records.' . PHP_EOL;

	}
	public function testBuilder()
	{
		// If we don't save the records, there will be no file to build
		if ( ! Yii::app()->params['AchReaderTest']['saveRecords'] )
		{
			return;
		}
		print '================' . PHP_EOL;
		print 'AchBuilderTest writes a valid NACHA file from the database.' . PHP_EOL;

		$fileName = 'misc/AchBuilderTest.ach';

		$odfiBranch = OdfiBranch::model()->find( 'odfi_branch_id=:odfi_branch_id', array( ':odfi_branch_id' => $this->odfiBranchId ) );

		if ( ! $odfiBranch )
		{
			throw new Exception( 'Unable to load odfi_branch.' );
		}

		$config = OABank::factory( $odfiBranch );

		print 'Preparing to export ach_file to ' . $fileName . PHP_EOL;

		//$achFile = AchFile::model()->find( 'ach_file_id=:ach_file_id', array( ':ach_file_id' => $achFileId ) );
		$achFile = AchFile::model()->find();

		if ( ! $achFile )
		{
			throw new CDbException( 'Unable to find an ach_file for which to test building.' );
		}

		print 'Building file... (this may take a moment)' . PHP_EOL;
		$fileBuilder = new OAFileBuilder( $config );
		$builtFile = $fileBuilder->build( $achFile );
		if ( $builtFile )
		{
			print $builtFile . PHP_EOL;
			$nachaFile = new SplFileObject( $fileName, 'w' );
			$nachaFile->fwrite( $builtFile );
		}
		else
		{
			print 'No lines were returned from the builder!';
			$this->assertNotEmpty( $builtFile );
		}

		print 'Saved records to ' . $fileName . PHP_EOL;
	}

	protected function truncateAchTables()
	{
		$tables = array(
		  'ach_file',
		  'ach_batch',
		  'ach_entry',
		);

		$fixtureManager = $this->getFixtureManager();
		foreach ( $tables as $tableName )
		{
			$fixtureManager->truncateTable( $tableName );
		}
	}
}

class AchReaderCallback
{
	public $recordCount = 0;
	public $recordSaveCount = 0;
	public $ach_file_id = '1df32e82-b582-4d42-80bb-a12059181c73';
	protected $ach_batch_id = '';
	protected $odfi_branch_id = '17d75ec4-bd49-11e0-b684-00163e4c6b77';
	protected $originator_info_id = '4c5ad948-1c74-11e1-b7de-f23c91dfda4e';
	protected $external_account_id = '96698fb8-bd4a-11e0-b684-00163e4c6b77';
	protected $payment_schedule_id = '';

	public function saveRecord( $dataSource, $recordLine, $caller )
	{

		$this->recordCount++;
	
		if ( ! Yii::app()->params['AchReaderTest']['saveRecords'] )
		{
			return;
		}

		$isReady = false;
		$isSaved = false;

		// Set up some defaults for the imported data
		if ( $dataSource instanceof AchFile && substr( $recordLine, 0, 1 ) == '1' )
		{
			// Also init the batch ID since we're looking at a new file
			$dataSource->ach_file_id = $this->ach_file_id;
			$dataSource->ach_file_status = 'confirmed';
			$dataSource->ach_file_datetime = '2011-01-01 01:01:01';
			$dataSource->ach_file_odfi_branch_id = $this->odfi_branch_id;
			$dataSource->ach_file_originator_info_id = $this->originator_info_id;
			$isReady = true;
			$isSaved = $dataSource->save();
		}
		elseif ( $dataSource instanceof AchFile && substr( $recordLine, 0, 1 ) == '9' )
		{
			$isReady = true;
			$isSaved = $dataSource->save();
		}
		elseif ( $dataSource instanceof AchBatch && substr( $recordLine, 0, 1 ) == '5' )
		{
			$this->ach_batch_id = UUID::mint( 4 );
			$dataSource->ach_batch_id = $this->ach_batch_id;
			$dataSource->ach_batch_ach_file_id = $this->ach_file_id;
			$dataSource->ach_batch_datetime = '2011-01-01 01:01:01';
			$isReady = true;
			$isSaved = $dataSource->save();
		}
		elseif ( $dataSource instanceof AchBatch && substr( $recordLine, 0, 1 ) == '8' )
		{
			$isReady = true;
			$isSaved = $dataSource->save();
		}
		elseif ( $dataSource instanceof AchEntry && substr( $recordLine, 0, 1 ) == '6' )
		{
			$dataSource->ach_entry_id = UUID::mint( 4 );
			$dataSource->ach_entry_status = 'posted';
			$dataSource->ach_entry_ach_batch_id = $this->ach_batch_id;
			$dataSource->ach_entry_odfi_branch_id = $this->odfi_branch_id;
			$dataSource->ach_entry_external_account_id = $this->external_account_id;
			$dataSource->ach_entry_payment_schedule_id = $this->payment_schedule_id;
			$dataSource->ach_entry_datetime = '2011-01-01 01:01:01';
			$isReady = true;
			$isSaved = $dataSource->save();
		}
                if ( $isReady && ! $isSaved )
                {
                    var_dump( $dataSource->getErrors() );
                    throw new Exception( "Unable to save!" );
                }
		elseif ( $isReady && $isSaved )
		{
			$this->recordSaveCount++;
		}

	}
}
