<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/


abstract class OAACHRecord extends OARecord
{
	const RECORD_TYPE_CODE = 0;

	protected function recordValidToProcess( $recordLine )
	{
		return substr( $recordLine, 0, 1 ) == $this::RECORD_TYPE_CODE;
	}
}


