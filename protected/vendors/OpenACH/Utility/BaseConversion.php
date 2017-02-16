<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

class BaseConversion 
{

	static public function DecimalTo36( $decimal )
	{
		return base_convert( $decimal, 10, 36 );
	}

	static public function 36ToDecimal( $base36 )
	{
		return base_convert( $base36, 36, 10 );
	}

	static public function HexToDecimal( $hex )
	{
		return base_convert( $hex, 16, 10);
	}

	static public function DecimalToHex( $decimal )
	{
		return base_convert( $decimal, 10, 16 );
	}

}
