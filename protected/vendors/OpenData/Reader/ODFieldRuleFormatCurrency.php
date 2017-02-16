<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

class ODFieldRuleFormatCurrency extends ODFieldRule
{

	// NOTE:  Originally we were doing decimal conversion, but its simpler
	// just to store the amount value in the DB exactly the same way it will
	// be in the file.  Decimal conversions can then be done at the display
	// level.

	public function format( $fieldValue )
	{
		return $fieldValue;
	}
	public function validate( $fieldValue )
	{
		return is_int( $fieldValue );
	}
	public function parse( $fieldValue )
	{
		return $fieldValue;
	}
}


