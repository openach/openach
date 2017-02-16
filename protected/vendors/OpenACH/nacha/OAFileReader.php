<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

class OAFileReader extends OANachaReader
{
	protected $batchReaderModels = array();

	protected function initRecordModels()
	{
		$this->headerRecordModel = new OAFileHeaderRecord( $this->config );

		if ( $this->config->isPPDEnabled() )
		{
			$this->batchReaderModels[] = new OAPPDBatchReader( $this->config );
		}

		if ( $this->config->isIATEnabled() )
		{
			$this->batchReaderModels[] = new OAIATBatchReader( $this->config );
		}

		// Used for notification of change records in return/change files
		$this->batchReaderModels[] = new OACORBatchReader( $this->config );

		$this->controlRecordModel = new OAFileControlRecord( $this->config );
	}
	protected function initReaderChain()
	{
		$this->readerChain = array();
		$this->readerChain[] = $this->headerRecordModel;

		foreach ( $this->batchReaderModels as $batchReaderModel )
		{
			$this->readerChain[] = $batchReaderModel;
		}

		$this->readerChain[] = $this->controlRecordModel;

		parent::initReaderChain();
	}
	protected function initCallbackChain()
	{
	}
}


