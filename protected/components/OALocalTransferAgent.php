<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

class OALocalTransferAgent extends OATransferAgent
{

	const AFTER_SAVE_STATUS = 'transferred';

	public function saveFile( $file, $meta=null )
	{
		throw new Exception( 'Due to security implications, saving an ACH file to the local filesystem is disabled.' );
	}

	public function getFile( $fileName )
	{
		try
		{
			$file =  new SplFileObject( $fileName );
			$fileBuffer = '';
			while ( ! $file->eof() )
			{
				$fileBuffer .= $file->fgets() . PHP_EOL;
			}
			$this->status = self::AFTER_SAVE_STATUS;
			return $fileBuffer;
		}
		catch ( Exception $e )
		{
			$this->message = $e->getMessage();
			return false;
		}
	}

	public function getConfirmation()
	{
		throw new Exception( 'Due to security implications, OALocalTransferAgent only allows fetching files via getFile().' );
	}

	public function getReturnChange()
	{
		throw new Exception( 'Due to security implications, OALocalTransferAgent only allows fetching files via getFile().' );
	}

}

