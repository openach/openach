<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

class OACORBatchBuilder extends OABatchBuilder
{
	protected function initRecordModels()
	{
		$this->headerRecordModel = new OACORBatchHeaderRecord( $this->config );
		$this->detailRecordModel = new OAPPDDetailRecord( $this->config );
		$this->controlRecordModel = new OABatchControlRecord( $this->config );		
	}
	public function getStandardEntryClass()
	{
		return 'COR';
	} 
	protected function prepareRecordForBuild( OADataSource $dataSource )
	{
		parent::prepareRecordForBuild( $dataSource );
	}
}

