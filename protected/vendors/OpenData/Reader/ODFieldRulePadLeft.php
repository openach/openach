<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

class ODFieldRulePadLeft extends ODFieldRulePad
{
	public function __construct( $length, $pad )
	{
		parent::__construct( array( 'length' => $length, 'pad' => $pad, 'type' => ODFieldRulePad::FR_STR_PAD_LEFT ) );
	}
}


