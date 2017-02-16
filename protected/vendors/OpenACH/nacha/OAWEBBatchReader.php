<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

class OAWEBBatchReader extends OABatchReader
{
	protected function initRecordModels()
	{
		$this->headerRecordModel = new OAWEBBatchHeaderRecord( $this->config );
		$this->detailRecordModel = new OAWEBDetailRecord( $this->config );
		$this->controlRecordModel = new OABatchControlRecord( $this->config );		
	}
	protected function initCallbackChain()
	{
		parent::initCallbackChain();
	}
	public function getStandardEntryClass()
	{
		return 'WEB';
	}

}

