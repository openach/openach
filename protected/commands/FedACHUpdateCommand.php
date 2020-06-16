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
Yii::import( 'application.vendors.OpenData.FederalReserve.*' );

class FedACHUpdateCommand extends CConsoleCommand
{

	protected $updateRecords = true;

	public function actionReloadAll()
	{
		$this->updateRecords = false;

		$this->truncateData( 'FedACH' );	
		$this->actionAch();

		$this->truncateData( 'Fedwire' );
		$this->actionWire();
	}

        protected function notAvailable()
        {
                echo 'The FedACH and FedWire directories are no longer publicly available. If you know of a free/open source for this data, please contact us and we will update this command to pull from that source instead.' . PHP_EOL;
                exit;
        }

	public function actionAch()
	{
                $this->notAvailable();
		// $this->loadFedData( 'FedACHDirectoryConfig', 'FedACHDirectoryFileReader' );
	}

	public function actionWire()
	{
                $this->notAvailable();
                /*
                Yii::import( 'application.models.*' );
		$test = new \FedACH();
		$this->loadFedData( 'FedwireDirectoryConfig', 'FedwireDirectoryFileReader' );
                */
	}

	protected function loadFedData( $fileReaderConfigClass, $fileReaderClass )
	{
		$config = new $fileReaderConfigClass();

		$readerCallback = new FedReaderCallback();
		
		$readerCallback->updateRecords = $this->updateRecords;

		$fileReader = new $fileReaderClass( $config );
		$fileReader->addCallback( $readerCallback, 'saveRecord' );

		print 'Opening file ' . $config->directoryUrl . ' for import.' . PHP_EOL;
		$readerFileName = $this->frbAgreeAndFetchFile( $config->directoryUrl );
		$readerFile = new SplFileObject( $readerFileName );

		// Get a record count (for progress indication)
		$readerFile->seek( $readerFile->getSize() );
		$readerCallback->estimatedRecords = $readerFile->key();
		$readerFile->rewind();

		print 'Parsing file... (this may take a moment)' . PHP_EOL;
		$fileReader->parseFile( $readerFile );

		print 'Processed ' . $readerCallback->recordCount . ' lines.' . PHP_EOL;
		print 'Saved ' . $readerCallback->recordSaveCount . ' records.' . PHP_EOL;

		// Clean up by closing file and removing it
		$readerFile = null;
		unlink( $readerFileName );
	}

	protected function truncateData( $modelClass )
	{
		$command = Yii::app()->db->createCommand(Yii::app()->db->createCommand());
		$command->truncateTable ( $modelClass::model()->tableName() );
	}

	// The Fed now requries you to agree to terms before downloading.  By using this code, you agree.
	protected function frbAgreeAndFetchFile( $url )
	{
		$cookieJarFile = '/tmp/cookie-jar-' . uniqid();
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieJarFile );
		curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieJarFile );
		$answer = curl_exec($ch);
		if (curl_error($ch))
		{
			echo curl_error($ch);
		}

		//another request preserving the session (Using the same cookie jar)
		sleep(2); // At least pretend to be human...
		curl_setopt($ch, CURLOPT_URL, 'https://www.frbservices.org/EPaymentsDirectory/submitAgreement');
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, "agreementValue=Agree");
		$answer = curl_exec($ch);
		if (curl_error($ch))
		{
			echo curl_error($ch);
		}

		curl_close($ch);

		// Clean Up
		unlink( $cookieJarFile );

		$frbFile = '/tmp/frb-file-' . uniqid();

		// Save the file - we'll clean it up later
		file_put_contents( $frbFile, $answer );
		return $frbFile;
	}

}

class FedReaderCallback
{
	public $recordCount = 0;
	public $recordSaveCount = 0;
	public $updateRecords = true;
	public $estimatedRecords = 0;

	protected function removeExisting( $dataSource )
	{
		$existing = null;
		if ( $dataSource instanceof FedACH )
		{
			$params = array( 'fedach_routing_number' => $dataSource->fedach_routing_number );
			$existing = FedACH::model()->findByAttributes( $params );
		}
		elseif ( $dataSource instanceof Fedwire )
		{
			$params = array( 'fedwire_routing_number' => $dataSource->fedwire_routing_number );
			$existing = Fedwire::model()->findByAttributes( $params );
		}

		if ( $existing )
		{
			$existing->delete();
		}
	}

	public function saveRecord( $dataSource, $recordLine, $caller )
	{
		if ( $this->updateRecords )
		{
			$this->removeExisting( $dataSource );
		}

		if ( ! $dataSource->save() ) 
                {
                    var_dump( $dataSource->getErrors() );
                    throw new Exception( "Unable to save!" );
                }

		$this->recordSaveCount++;
		$this->recordCount++;
		$this->progressIndicator();
	}

	protected function progressIndicator()
	{
		if ( $this->recordSaveCount % 100 == 0 || $this->recordSaveCount == 0 )
		{
			echo "\tRecord " . $this->recordSaveCount . '/' . $this->estimatedRecords . PHP_EOL;
		}
	}

}
