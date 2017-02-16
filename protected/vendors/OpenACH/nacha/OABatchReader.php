<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

abstract class OABatchReader extends OANachaReader
{
	protected $headerRecordModel;
	protected $detailRecordModel;
	protected $controlRecordModel;

	abstract public function getStandardEntryClass();

	protected function initReaderChain()
	{
		$this->readerChain = array();
		$this->readerChain[] = $this->headerRecordModel;
		$this->readerChain[] = $this->detailRecordModel;
		$this->readerChain[] = $this->controlRecordModel;
		parent::initReaderChain();
	}

}


