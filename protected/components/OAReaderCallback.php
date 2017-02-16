<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

class OAReaderCallback
{
	public $odfi_branch_id = '';

	protected function saveFileOnError( $filename, $contents )
	{
		$file = new SplFileObject( $this->getRuntimePath() . DIRECTORY_SEPARATOR . $filename );
		$file->fwrite( $contents );
	}

	protected function getRuntimePath()
	{
		$path = Yii::app()->getRuntimePath() . get_class( $this );
		$runtimePath = realpath( $path );

		if ( $runtimePath && ! is_dir( $runtimePath ) )
		{
			mkdir( $runtimePath );
		}
		
		if ( ! $runtimePath || ! is_dir( $runtimePath ) || ! is_writable( $runtimePath ) )
		{
			throw new CException( 'Application runtime path "' . $path . '" is not valid. Please make sure it is a writable directory.' );
		}

		return $runtimePath;
	}

}
