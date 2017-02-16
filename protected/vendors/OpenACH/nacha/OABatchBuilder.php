<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

abstract class OABatchBuilder extends OABuilder
{
	protected $headerRecordModel;
	protected $detailRecordModel;
	protected $controlRecordModel;

	protected $detailRecordCount = 0;

	abstract public function getStandardEntryClass();

	protected function hasValidDataSource()
	{
		if ( $this->dataSource instanceof ACHBatch
			&& $this->dataSource->ach_batch_header_standard_entry_class == $this->getStandardEntryClass()
			&& is_array( $this->builderDataSource ) )
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	protected function initBuilderDataSource()
	{
		if ( ! $this->dataSource )
		{
			return;
		}
		// load models for all ACH Entries associated with the current ach_batch
		$criteria = new CDbCriteria();
		$criteria->addCondition( 'ach_entry_ach_batch_id = :ach_batch_id' );
		$criteria->order = 'ach_entry_detail_trace_number ASC';
		$criteria->params = array( ':ach_batch_id'=>$this->dataSource->ach_batch_id );
		$achEntryModel = new AchEntry();
		$this->builderDataSource = $achEntryModel->findAll( $criteria );
	}
	
	protected function initBuilderChain()
	{
		$this->builderChain[] = $this->headerRecordModel;
		$this->builderChain[] = $this->detailRecordModel;
		$this->builderChain[] = $this->controlRecordModel;
		parent::initBuilderChain();
	}

	protected function prepareRecordForBuild( OADataSource $dataSource )
	{
		$this->detailRecordCount++;
		$dataSource->ach_entry_detail_sequence_number = $this->detailRecordCount;
	}

}


