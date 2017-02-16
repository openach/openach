<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/


class ODFieldRuleEnforceNumeric extends ODFieldRule
{
	public function format( $fieldValue )
	{
		if ( ! is_numeric( $fieldValue ) )
		{
			throw new Exception( 'Field value is expected to be numeric, but found non numeric value of "' . $fieldValue . '"' );
		}
		return $fieldValue;
	}
	public function validate( $fieldValue )
	{
		return is_int( $fieldValue );
	}
}


