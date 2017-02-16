<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

Yii::import( 'application.models.*' );
Yii::import( 'application.vendors.OpenData.Reader.*' );
Yii::import( 'application.vendors.OpenData.Treasury.*' );

class OfacUpdateCommand extends CConsoleCommand
{

	protected $updateRecords = true;

	public function actionReloadAll()
	{
		$this->updateRecords = false;

		$this->truncateData( 'OfacSdn' );	
		$this->actionSdn();

		$this->truncateData( 'OfacAlt' );
		$this->actionAlt();

		$this->truncateData( 'OfacAdd' );
		$this->actionAdd();
	}

	public function actionSdn()
	{
		$this->loadOfacData( 'OfacSdnConfig', 'OfacSdnFileReader' );
	}

	public function actionAlt()
	{
		$this->loadOfacData( 'OfacAltConfig', 'OfacAltFileReader' );
	}

	public function actionAdd()
	{
		$this->loadOfacData( 'OfacAddConfig', 'OfacAddFileReader' );
	}

	protected function loadOfacData( $fileReaderConfigClass, $fileReaderClass )
	{
		$config = new $fileReaderConfigClass();

		$readerCallback = new OfacReaderCallback();
		
		$readerCallback->updateRecords = $this->updateRecords;

		$fileReader = new $fileReaderClass( $config );
		$fileReader->addCallback( $readerCallback, 'saveRecord' );

		print 'Opening file ' . $config->directoryUrl . ' for import.' . PHP_EOL;
		$readerFile = new SplFileObject( $config->directoryUrl );

		print 'Parsing file... (this may take a moment)' . PHP_EOL;
		$fileReader->parseFile( $readerFile );

		print 'Processed ' . $readerCallback->recordCount . ' lines.' . PHP_EOL;
		print 'Saved ' . $readerCallback->recordSaveCount . ' records.' . PHP_EOL;
	}

	protected function truncateData( $modelClass )
	{
		$command = Yii::app()->db->createCommand(Yii::app()->db->createCommand());
		$command->truncateTable ( $modelClass::model()->tableName() );
		$command = Yii::app()->db->createCommand(Yii::app()->db->createCommand());
		$command->delete( 'phonetic_data', 'phonetic_data_entity_class = :entity_class', array( ':entity_class' => $modelClass ) );
	}

}

class OfacReaderCallback
{
	public $recordCount = 0;
	public $recordSaveCount = 0;
	public $updateRecords = true;

	protected function removeExisting( $dataSource )
	{
		$existing = null;
		if ( $dataSource instanceof OfacAdd )
		{
			$params = array( 'ofac_add_ent_num' => $dataSource->ofac_add_ent_num );
			$existing = OfacAdd::model()->findByAttributes( $params );
		}
		elseif ( $dataSource instanceof OfacAlt )
		{
			$params = array( 'ofac_alt_ent_num' => $dataSource->ofac_alt_ent_num );
			$existing = OfacAlt::model()->findByAttributes( $params );
		}
		elseif ( $dataSource instanceof OfacSdn )
		{
			$params = array ( 'ofac_sdn_ent_num' => $dataSource->ofac_sdn_ent_num );
			$existing = OfacSdn::model()->findByAttributes( $params );
		}

		if ( $existing )
		{
			$command = Yii::app()->db->createCommand();
			$where = 'phonetic_data_entity_class = :entity_class AND phonetic_data_entity_id = :entity_id';
			$params = array( 
					':entity_class' => get_class( $dataSource ),
					':entity_id' => $dataSource->{ $dataSource->primaryKey() },
				);
			$command->delete( 'phonetic_data', $where, $params );
			$existing->delete();
		}
	}

	public function saveRecord( $dataSource, $recordLine, $caller )
	{
		if ( $this->updateRecords )
		{
			$this->removeExisting();
		}

		if ( ! $dataSource->save() ) 
                {
                    var_dump( $dataSource->getErrors() );
                    throw new Exception( "Unable to save!" );
                }

		$this->recordSaveCount++;
		$this->recordCount++;
	}

}
