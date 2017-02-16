<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

class OAIATBatchBuilder extends OABatchBuilder
{
	protected function initRecordModels()
	{
		$this->headerRecordModel = new OAIATBatchHeaderRecord( $this->config );
		$this->detailRecordModel = new OAIATDetailRecord( $this->config );
		$this->controlRecordModel = new OABatchControlRecord( $this->config );		
	}
	public function getStandardEntryClass()
	{
		return 'IAT';
	}

	protected function prepareRecordForBuild( OADataSource $dataSource )
	{
		parent::prepareRecordForBuild( $dataSource );
	}
}
