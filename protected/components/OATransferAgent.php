<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

class OATransferAgent
{
	protected $config;
	protected $status = 'failed';
	protected $message = '';

	public static function factory( OABankConfig $bankConfig )
	{
		switch ( $bankConfig::TRANSFER_AGENT )
		{
			case 'SFTP':
				return new OASFTPTransferAgent( $bankConfig );
				break;
			case 'Manual':
				return new OAManualTransferAgent( $bankConfig );
			default:
				throw new Exception( get_class( $bankConfig ) . ' uses an unknown transfer agent type of ' . $bankConfig::TRANSFER_AGENT . '.' );
				break;
		}
	}

	public function __construct( OABankConfig $bankConfig )
	{
		$this->config = $bankConfig->getTransferConfig();
		$this->init();
	}

	protected function init()
	{
		return;
	}

	public function saveFile( $file, $meta=null )
	{
		throw new Exception( 'This method should be implemented by a subclass.' );
	}

	public function getConfirmation()
	{
		throw new Exception( 'This method should be implemented by a subclass.' );
	}

	public function getReturnChange()
	{
		throw new Exception( 'This method should be implemented by a subclass.' );
	}

	public function getTransferStatus()
	{
		return $this->status;
	}

	public function getTransferMessage()
	{
		return $this->message;
	}

	protected function template($template, $params)
	{
		foreach ( $params as $key => $value )
		{
			$template = str_replace('{{' . $key . '}}', $value, $template);
		}
		return $template;
	}

}

