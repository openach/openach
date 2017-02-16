<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

class ODFieldRulePad extends ODFieldRule
{
	const FR_STR_PAD_RIGHT	= STR_PAD_RIGHT;
	const FR_STR_PAD_LEFT	= STR_PAD_LEFT;
	const FR_STR_PAD_BOTH	= STR_PAD_BOTH;
	
	protected function assertOptions()
	{
		if ( ! isset( $this->options->type ) )
		{
			$this->options->type = self::FR_STR_PAD_LEFT;
		}
		assert( isset( $this->options ) );
		assert( isset( $this->options->length ) );
		assert( isset( $this->options->pad ) );
		assert( isset( $this->options->type ) );
	}
	public function format( $fieldValue )
	{
		return str_pad( $fieldValue, $this->options->length, $this->options->pad, $this->options->type );
	}
	public function parse( $fieldValue )
	{
		if ( $this->options->type == self::FR_STR_PAD_LEFT )
		{
			return ltrim( $fieldValue, $this->options->pad );
		}
		elseif ( $this->options->type == self::FR_STR_PAD_RIGHT )
		{
			return rtrim( $fieldValue, $this->options->pad );
		}
		else
		{
			return trim( $fieldValue, $this->options->pad );
		}
	}
	public function validate( $fieldValue )
	{
		return true;
	}
}


