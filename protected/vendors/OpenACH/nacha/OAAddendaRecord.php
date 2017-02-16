<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

abstract class OAAddendaRecord extends OAACHRecord
{
	const RECORD_TYPE_CODE = 7;
	const ADDENDA_TYPE_CODE = '  ';

	protected function dataSource()
	{
		return new AchEntry();
	}
	protected function readerHasValidDataSource()
	{
		// Addenda records technically never have a reader, and are tied directly to the proper type of detail record
		// so we'll always assume true...
		return true;
	}
	abstract protected function getStandardEntryClass();

	protected function recordValidToProcess( $recordLine )
	{
		return parent::recordValidToProcess( $recordLine) && substr( $recordLine, 1, 2 ) == $this::ADDENDA_TYPE_CODE;
	}

}


