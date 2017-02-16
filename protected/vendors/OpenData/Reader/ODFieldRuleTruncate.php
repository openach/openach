<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/



class ODFieldRuleTruncate extends ODFieldRule
{
	const FR_FROM_START 	= 0;
	const FR_FROM_END	= 1;

	protected function assertOptions()
	{
		if ( ! isset( $this->options->type ) )
		{
			$this->options->type = self::FR_FROM_START;
		}
	}
	public function format( $fieldValue )
	{
		if ( $this->options->type == self::FR_FROM_START )
		{
			return substr( $fieldValue, 0, $this->options->length );
		}
		else
		{
			return substr( $fieldValue, - $this->options->length );
		}
	}
	public function validate( $fieldValue )
	{
		return true;
	}
	
	public function getLength()
	{
		return $this->options->length;
	}
}

