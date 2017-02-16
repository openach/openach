<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

abstract class OABatchHeaderRecord extends OAHeaderRecord
{

	const RECORD_TYPE_CODE = 5;

	protected function dataSource()
	{
		return new AchBatch();
	}

	protected function recordValidToProcess( $recordLine )
	{
		return parent::recordValidToProcess( $recordLine ) && substr( $recordLine, 50, 3 ) == $this->getStandardEntryClass();
	}
	
	abstract public function getStandardEntryClass();

	protected function readerHasValidDataSource()
	{
		// The reader will only have a data source if we're reading between a file header and file control record
		if ( $this->reader->getReader()->getDataSource() && $this->reader->getReader()->getDataSource() instanceof AchFile )
		{
			return true;
		}
		else
		{
			return false;
		}
	}
}


