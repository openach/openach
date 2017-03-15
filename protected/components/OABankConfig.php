<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

Yii::import( 'application.vendors.OpenACH.nacha.Banks.*' );
//Yii::import( 'application.vendors.OpenACH.nacha.OABank' );

abstract class OABankConfig extends OAPluginConfig
{
	const PARENT_MODEL = 'OdfiBranch';
	const TRANSFER_AGENT = 'Manual';
	const AFTER_SAVE_STATUS = 'transferred';

	protected $testModelClass;
	protected $gatewayDfiId = '';
	protected $confirmationFileReaderClass = 'OAFileReader';
	protected $confirmationFileReaderCallbackClass = 'OAConfirmationReaderCallback';
	protected $returnChangeFileReaderClass = 'OAFileReader';
	protected $returnChangeFileReaderCallbackClass = 'OAReturnChangeReaderCallback';
	protected $odfiBranch;

	public function __construct( OdfiBranch $odfiBranch=null )
	{
		$this->odfiBranch = $odfiBranch;
		$this->init($this->odfiBranch->odfi_branch_id);
	}

	public function getTransferAgent()
	{
		return OATransferAgent::factory( $this );
	}

	public function getLocalTransferAgent()
	{
		return new OALocalTransferAgent( $this );
	}

	public function getTestModel()
	{
		return new $this->testModelClass;
	}
	public function getConfirmationFileBuilder()
	{
		return new $this->testModelClass;
	}
	public function formatTraceNumber( $recordSequence )
	{
		if ( ! $this->odfiBranch )
		{
			throw new Exception( 'This method requires a valid OdfiBranch.' );
		}

		return substr( $this->odfiBranch->odfi_branch_dfi_id, 0, 8 ) . str_pad( $recordSequence, 7, '0', STR_PAD_LEFT );
	}
	public function getBlockingFactor()
	{
		return 10;
	}

	public function getTransferConfig()
	{
		$config = array();
		$config['prod_host'] = $this->getConfig( 'Production SFTP Host' );
		$config['prod_port'] = $this->getConfig( 'Production SFTP Port' );
		$config['test_host'] = $this->getConfig( 'Test SFTP Host' );
		$config['test_port'] = $this->getConfig( 'Test SFTP Port' );
		$config['user'] = $this->getConfig( 'SFTP Username' );
		$config['password'] = $this->getConfig( 'SFTP Password' );
		$config['key'] = $this->getConfig( 'SFTP Key' );
		$config['outbound_path'] = $this->getConfig( 'ACH File Path' );
		$config['outbound_file'] = $this->getConfig( 'ACH Filename' );
		$config['confirm_path'] = $this->getConfig( 'ACH Confirm Path' );
		$config['confirm_file'] = $this->getConfig( 'ACH Confirm Filename' );
		$config['return_path'] = $this->getConfig( 'ACH Return Path' );
		$config['return_file'] = $this->getConfig( 'ACH Return Filename' );
		return $config;
	}

	public function setTransferConfig( $config )
	{
		$mapping = array(
			'prod_host'	=> 'Production SFTP Host',
			'prod_port'	=> 'Production SFTP Port',
			'test_host'	=> 'Test SFTP Host',
			'test_port'	=> 'Test SFTP Port',
			'user'		=> 'SFTP Username',
			'password'	=> 'SFTP Password',
			'key'		=> 'SFTP Key',
			'outbound_path'	=> 'ACH File Path',
			'outbound_file'	=> 'ACH Filename',
			'confirm_path'	=> 'ACH Confirm Path',
			'confirm_file'	=> 'ACH Confirm Filename',
			'return_path'	=> 'ACH Return Path',
			'return_file'	=> 'ACH Return Filename',
		);

		foreach ( $config as $key => $value )
		{
			if ( isset( $mapping[$key] ) )
			{
				if ( $value === null )
				{
					$value = "";
				}
				$this->configState[ $mapping[$key] ] = $value;
			}
		}

	}

	public function getRecordConfig()
	{
		$config = $this->getConfig('record_config');
		return json_decode( $config );
	}

	public function setRecordConfig($config)
	{
		$this->configState['record_config'] = $config;
	}

	public function beforeRecordSave( OADataSource $dataSource)
	{
		$config = $this->getRecordConfig();

		if ( ! $config )
		{
			return;
		} 

		foreach ( $config as $className => $override )
		{
			if ( get_class( $dataSource ) == $className )
			{
				foreach ( $override as $key => $value )
				{
					$dataSource->{$key} = $value;
				}
			}
		}
	}

	protected function initConfig()
	{
		return;
	}
	public function isPPDEnabled()
	{
		return true;
	}
	public function isIATEnabled()
	{
		return true;
	}

	public function getGatewayDfiId()
	{
		return $this->gatewayDfiId;
	}

	public function getReturnChangeFileReader()
	{
		$class = new ReflectionClass( $this->returnChangeFileReaderClass );
		$fileReader = $class->newInstanceArgs( array( $this ) );
		$fileReader->addCallback( $this->getReturnChangeFileReaderCallback(), 'handleRecord' );
		return $fileReader;
	}

	public function getConfirmationFileReader()
	{
		$class = new ReflectionClass( $this->confirmationFileReaderClass );
		$fileReader = $class->newInstanceArgs( array( $this ) );
		$fileReader->addCallback( $this->getConfirmationFileReaderCallback(), 'handleRecord' );
		return $fileReader;
	}

	public function getReturnChangeFileReaderCallback()
	{
		$class = new ReflectionClass( $this->returnChangeFileReaderCallbackClass );
		$callback = $class->newInstanceArgs( array() );
		$callback->odfi_branch_id = $this->odfiBranch->odfi_branch_id;
		return $callback;
	}

	public function getConfirmationFileReaderCallback()
	{
		$class = new ReflectionClass( $this->confirmationFileReaderCallbackClass );
		return $class->newInstanceArgs( array() );
	}

	public function getOdfiBranch()
	{
		return $this->odfiBranch;
	}

}

abstract class OABankTest
{

}

