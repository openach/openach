<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

class ODFieldRuleEnforceLength extends ODFieldRule
{
	protected function assertOptions()
	{
		assert( isset( $this->options ) );
		assert( isset( $this->options->length ) );
	}
	public function format( $fieldValue )
	{
		assert( strlen( $fieldValue ) >= $this->option->length );
		return $fieldValue;
	}
	public function validate( $fieldValue )
	{
		return strlen( $fieldValue ) >= $this->option->length;
	}
}

