<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

class OAFileBuilder extends OABuilder
{
	protected $batchBuilderModels = array();

	protected function initRecordModels()
	{
		$this->headerRecordModel = new OAFileHeaderRecord( $this->config );

		if ( $this->config->isPPDEnabled() )
		{
			$this->batchBuilderModels[] = new OAPPDBatchBuilder( $this->config );
		}

		if ( $this->config->isIATEnabled() )
		{
			$this->batchBuilderModels[] = new OAIATBatchBuilder( $this->config );
		}

		// Used for sending notification of change records
		// This is included for consisitency of design, as the OAFileReader can process them
		// In order to actually use them, they would need to be more completely implemented
		// to ensure all required data is coming from the AchBatch and AchEntry (possibly
		// also AchEntryReturn) models.  Its commented out to streamline execution.
		// $this->batchBuilderModels[] = new OACORBatchBuilder( $this->config );

		$this->controlRecordModel = new OAFileControlRecord( $this->config );
	}
	protected function initBuilderChain()
	{
		$this->builderChain[] = $this->headerRecordModel;

		foreach ( $this->batchBuilderModels as $batchBuilderModel )
		{
			$this->builderChain[] = $batchBuilderModel;
		}

		$this->builderChain[] = $this->controlRecordModel;

		parent::initBuilderChain();
	}
	protected function hasValidDataSource()
	{
		return $this->dataSource instanceof ACHFile && is_array( $this->builderDataSource );
	}
	protected function initBuilderDataSource()
	{
		if ( ! $this->dataSource )
		{
			return;
		}
		// load models for all ACH Batches associated with the current ach_file
		$criteria = new CDbCriteria();
		$criteria->addCondition( 'ach_batch_ach_file_id = :ach_file_id' );
		$criteria->order = 'ach_batch_header_batch_number ASC';
		$criteria->params = array( ':ach_file_id'=>$this->dataSource->ach_file_id );
		$achBatchModel = new AchBatch();
		$this->builderDataSource = $achBatchModel->findAll( $criteria );
	}
	public function build( OADataSource $dataSource )
	{
		$builtFile = parent::build( $dataSource );
		$totalLines = substr_count( $builtFile, $this->config->getLineDelimiter() ) + 1;

		if ( $totalLines <= $this->config->getBlockingFactor() )
		{
			$blockLineCount = $this->config->getBlockingFactor() - $totalLines;
		}
		else
		{
			$blockLineCount = $this->config->getBlockingFactor() - ( $totalLines % $this->config->getBlockingFactor() ) - 1;
		}

		// A blocking line is 94 characters of the number 9
		$blockingLine = str_pad( '', 94, '9' );

		for ( $i = 0; $i <= $blockLineCount; $i++ )
		{
			$builtFile .= $this->config->getLineDelimiter() . $blockingLine;
		}

		return $builtFile;

	}
}


