<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

class OAManualTransferAgent extends OATransferAgent
{

	const AFTER_SAVE_STATUS = 'confirmed';

	public function saveFile( $file, $meta=null )
	{
		$outboundFile = $this->config['outbound_file'];
		$outboundPath = $this->config['outbound_path'];
		if ( $meta )
		{
			$outboundFile = $this->template($outboundFile,$meta);
			$outboundPath = $this->template($outboundPath,$meta);
		}
		if ( ! file_exists( $outboundPath ) )
		{
			mkdir($outboundPath, 0755, true);
		}
		$fileName = $outboundPath . $outboundFile . '.ach';
		$nachaFile = new SplFileObject( $fileName, 'w' );
		$bytes = $nachaFile->fwrite( $file );
		return ( $bytes !== null ) ? true : false;
	}

	public function getConfirmation()
	{
		$fileName = $this->config['confirm_path'] . $this->config['confirm_file'];
		return file_get_contents( $fileName );
	}

	public function getReturnChange()
	{
		$fileName = $this->config['return_path'] . $this->config['return_file'];
		return file_get_contents( $fileName );
	}

}

