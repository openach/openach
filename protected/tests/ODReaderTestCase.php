<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

Yii::import( 'application.vendors.OpenACH.nacha.*' );
abstract class ODReaderTestCase extends OADbTestCase
{

	protected $testMessage = 'Performing ODReader Test';
	protected $fileReaderConfigClass = '';
	protected $fileReaderClass = '';
	protected $truncateTables = array();

	public $fixtures=array(
		'odfiBranches'=>'OdfiBranch',
		'externalAccounts'=>'ExternalAccount',
	);

	protected $odfiBranchId = '17d75ec4-bd49-11e0-b684-00163e4c6b77';

	public function testReader()
	{
		if ( ! Yii::app()->params['ODReaderTestCase']['loadExternalSources'] )
		{
			print "Config setting of loadExternalSources is disabled.  The following test will be skipped:" . PHP_EOL;
			print "\t" . $this->testMessage . PHP_EOL;
			return;
		}

		$fileReaderConfigClass = $this->fileReaderConfigClass;
		$fileReaderClass = $this->fileReaderClass;

		print '================' . PHP_EOL;
		print $this->testMessage . PHP_EOL;
		$this->truncateTables();

		// OAFileReader requires an OABankConfig, even if its empty
		// and the OABankConfig requires an OdfiBranch, even if its empty
		$odfiBranch = OdfiBranch::model()->find( 'odfi_branch_id=:odfi_branch_id', array( ':odfi_branch_id' => $this->odfiBranchId ) );

		$config = new $fileReaderConfigClass( $odfiBranch );

		$readerCallback = new ReaderTestCallback();

		$fileReader = new $fileReaderClass( $config );
		$fileReader->addCallback( $readerCallback, 'saveRecord' );

		print 'Opening file ' . $config->directoryUrl . ' for import.' . PHP_EOL;

		$readerFile = new SplFileObject( $config->directoryUrl );

		print 'Parsing file... (this may take a moment)' . PHP_EOL;
		$fileReader->parseFile( $readerFile );

		print 'Processed ' . $readerCallback->recordCount . ' lines.' . PHP_EOL;
		print 'Saved ' . $readerCallback->recordSaveCount . ' records.' . PHP_EOL;

	}

	protected function truncateTables()
	{

		$fixtureManager = $this->getFixtureManager();
		foreach ( $this->truncateTables as $tableName )
		{
			$fixtureManager->truncateTable( $tableName );
		}
	}
}

class ReaderTestCallback
{
	public $recordCount = 0;
	public $recordSaveCount = 0;

	public function saveRecord( $dataSource, $recordLine, $caller )
	{
		$this->recordCount++;
		if ( ! $dataSource->save() ) 
                {
                    var_dump( $dataSource->getErrors() );
                    throw new Exception( "Unable to save!" );
                }
		else
		{
			$this->recordSaveCount++;
		}

	}
}
