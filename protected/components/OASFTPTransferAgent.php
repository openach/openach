<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

class OASFTPTransferAgent extends OATransferAgent
{

	const AFTER_SAVE_STATUS = 'transferred';

	protected $client;

	public function test()
	{
		$this->login();
	}

	protected function init()
	{
		Yii::import( 'application.vendors.phpseclib.*' );
		require_once( 'Crypt/RSA.php' );
		require_once( 'Net/SFTP.php' );
		if ( Yii::app()->params['productionMode'] )
		{
			$this->client = new Net_SFTP( $this->config['prod_host'], $this->config['prod_port'] );
		}
		else
		{
			$this->client = new Net_SFTP( $this->config['test_host'], $this->config['test_port'] );
		}
		if ( ! $this->client )
		{
			throw new Exception( 'Unable to create SFTP client.' );
		}
	}

	protected function login()
	{
		if ( isset( $this->config['key'] ) && ! empty( $this->config['key'] ) )
		{
			$key = new Crypt_RSA();
			if ( ! $key->loadKey( $this->config['key'] ) )
			{
				throw new Exception( 'Unable to load private key.' );
			}
			$password = $key;
		}
		else
		{
			$password = $this->config['password'];
		}
		if ( ! $this->client->login( $this->config['user'], $password ) )
		{
			throw new Exception( 'Login failed for user ' . $this->config['user'] );
		}
	}

	public function saveFile( $file, $meta=null )
	{
		$outboundFile = $this->config['outbound_file'];
		$outboundPath = $this->config['outbound_path'];
		if ( $meta )
		{
			$outboundFile = $this->template($outboundFile,$meta);
			$outboundPath = $this->template($outboundPath,$meta);
		}

		$this->setupErrorHandler();
		try
		{
			if ( Yii::app()->params['AchFile']['EnableFileTransfers'] )
			{
				$this->login();
				$this->client->chdir( $outboundPath );
				$this->client->put( $outboundFile, $file );
				$this->client->disconnect();
				$this->status = $this::AFTER_SAVE_STATUS;
			}
		}
		catch ( Exception $e )
		{
			$this->message = $e->getMessage();
			return false;
		}
		$this->restoreErrorHandler();
		$this->status = self::AFTER_SAVE_STATUS;

		return true;
	}

	public function getConfirmation()
	{
		$this->setupErrorHandler();
		try
		{
			$this->login();
			$this->client->chdir( $this->config['confirm_path'] );
			$file = $this->client->get( $this->config['confirm_file'] );
			$this->client->disconnect();
		}
		catch ( Exception $e )
		{
			$this->message = $e->getMessage();
			return false;
		}
		$this->restoreErrorHandler();
		$this->status = self::AFTER_SAVE_STATUS;

		return $file;
	}

	public function getReturnChange()
	{
		$this->setupErrorHandler();
		try
		{

			$this->login();
			$this->client->chdir( $this->config['return_path'] );
			$file = $this->client->get( $this->config['return_file'] );
			$this->client->disconnect();
		}
		catch ( Exception $e )
		{
			$this->message = $e->getMessage();
			return false;
		}
		$this->restoreErrorHandler();
		$this->status = self::AFTER_SAVE_STATUS;

		return $file;
	}

	// PHPSecLib raises user_errors rather than exceptions.
	// To keep things try/catch friendly, temporarily reroute errors to exceptions
	protected function setupErrorHandler()
	{
		set_error_handler( 'altErrorHandler' );
	}

	protected function restoreErrorHandler()
	{
		restore_error_handler();

	}

}

// An alternative error handler that converts errors to exceptions.
function altErrorHandler( $errno, $errstr, $errfile=null, $errline=null, $errcontext=null)
{
        throw new Exception( $errstr, $errno );
}


