<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

class OAAPIRequest extends OAAPIBase
{
	public $action = 'test';
	
	public function __construct( OAAPIResponse $response=null )
	{
		if ( $response )
		{
			if ( $response->data )
				$this->merge( $response->data );
		}
	}

	public function getParams()
	{
		return $this->data;
	}
}

