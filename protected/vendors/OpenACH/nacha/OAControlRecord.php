<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

abstract class OAControlRecord extends OAACHRecord
{
	public function touch( OADataSource $dataSource )
	{
		if ( $this->builder && $builderBuilder = $this->builder->getBuilder() && $builderControlRecord = $builderBuilder->getControlRecord() )
		{
			$builderControlRecord->touch( $dataSource );
		}
	}

	protected function recordValidToProcess( $recordLine )
	{
		if ( $recordLine != str_repeat( '9', 94 ) && parent::recordValidToProcess( $recordLine ) )
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	protected function readerHasValidDataSource()
	{
		if ( $this->reader->getDataSource() )
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	protected function dataSource()
	{
		return $this->reader->getDataSource();
	}

}

