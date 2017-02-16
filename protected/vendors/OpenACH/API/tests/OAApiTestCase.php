<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

// Load the OpenACH SDK
include_once( dirname(__FILE__) . '/../lib/OpenACHSdk.php' );

class OAApiTestCase extends PHPUnit_Framework_TestCase
{

	static $config;
	static $client;

	public $fixtures = array();
	public $automaticallyConnect = true;
	public $cleanUpRecords = array();
	public $modelClass;

	// Do all setup tasks here before testing begins
	public static function setUpBeforeClass()
	{
		self::$config = new OAClientConfigIni('..'); // this path is always relative to the SDK lib directory
		self::$client = new OAConnection( self::$config );
	}

	protected function setUp()
	{
		foreach ( $this->fixtures as $fixture )
		{
			$this->loadFixture( $fixture );
		}

		if ( $this->automaticallyConnect )
		{
			self::$client->connect( self::$config );
		}
	}

	protected function tearDown()
	{
		$className = $this->modelClass;
		if ( $className )
		{
			foreach ( $this->cleanUpRecords as $recordId )
			{
				if ( ! $model = $className::model()->findByPk( $recordId ) )
					continue;
				$model->delete();
				
			}
		}
	}

	protected function loadFixture( $fixture )
	{
		$this->{$fixture} = include( 'fixtures/' . $fixture . '.php' );
	}

	protected function assertRecordCreated( $id, $fixture=null )
	{
		if ( ! $this->modelClass )
			return;

		$className = $this->modelClass;
		$model = $className::model()->findByPk( $id );

		if ( ! $model )
			$this->assertTrue( false );

		if ( $model && $fixture )
		{
			$this->assertFieldsMatch( $model, $fixture );
		}

	}

	protected function assertFieldsMatch( $model, $fixture )
	{
		foreach ( $fixture as $field => $value )
		{
			try
			{
				$this->assertEquals( $model->{$field}, $value );
			}
			catch ( Exception $e )
			{
				throw new Exception( 'assertEquals failed for field ' . $field . $e->getMessage() . ' where values were "' . $model->{$field} . '" and "' . $value . '".'  );
			}
		}
	}
}
