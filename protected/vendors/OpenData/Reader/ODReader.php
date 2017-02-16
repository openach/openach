<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

abstract class ODReader extends ODObject
{
	protected $readerModels = array();
	protected $readerChain = array();
	protected $callbackChain = array();
	protected $headerRecordModel;
	protected $controlRecordModel;
	protected $dataSource;
	protected $config;
	protected $reader;
	protected $sourceFile;
	protected $currentLine;
        protected $unparsedRecord;
	protected $skipBlankLines = false;
		
	public function __construct( ODConfig $config )
	{
		$this->config = $config;
		$this->initRecordModels();
		$this->initReaderChain();
		$this->initCallbackChain();
	}
	
	abstract protected function initRecordModels();
	protected function initCallbackChain()
	{
		return;
	}
	
	public function readLine()
	{
		if ( $this->sourceFile->eof() )
		{
			$this->currentLine = '';
		}
		else
		{
			$this->currentLine = $this->sourceFile->fgets();
			if ( ! trim( $this->currentLine ) && $this->skipBlankLines && ! $this->sourceFile->eof() )
			{
				$this->readLine();
			}
		}
		return $this->currentLine;
	}

	public function parseFile( SplFileObject $sourceFile )
	{
		$this->sourceFile = $sourceFile;
		while( $recordLine = $this->readLine() )
		{
			$this->parse( $recordLine );
		}
	}
	
	public function hasSourceFile()
	{
		if ( $this->sourceFile )
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	public function parse( $recordLine )
	{
		foreach ( $this->readerChain as $recordReaderModel )
		{

			if ( $dataSource = $recordReaderModel->parse( $recordLine ) )
			{
				if ( $recordReaderModel === $this->headerRecordModel )
				{
					$this->setDataSource( $dataSource );
				}

				foreach ( $this->callbackChain as $callback )
				{
					$callback->target->{$callback->method}( $dataSource, $recordLine, $recordReaderModel );
				}

				if ( $recordReaderModel === $this->controlRecordModel )
				{
					$this->dataSource = null;
				}

			}
                        if ( $this->unparsedRecord )
                        {
                            $unparsedRecord = $this->unparsedRecord;
                            $this->unparsedRecord = null;
                            $this->parse( $unparsedRecord );
                        }
		}
	}

	protected function initReaderChain()
	{
		foreach ( $this->readerChain as $readerModel )
		{
			$readerModel->setReader( $this );
		}
	}
	
	public function getControlRecordModel()
	{
		return $this->controlRecordModel;
	}
	
	public function setReader( ODReader $reader )
	{
		$this->reader = $reader;
	}
	
	public function getReader()
	{
		return $this->reader;
	}
	
	public function addCallback( $target, $method )
	{
		$callback = new stdClass();
		$callback->target = $target;
		$callback->method = $method;
		$this->callbackChain[] = $callback;
		foreach ( $this->readerChain as $readerModel )
		{
			if ( $readerModel instanceof ODReader )
			{
				$readerModel->addCallback( $target, $method );
			}
		}
	}
	
	public function getDataSource()
	{
		return $this->dataSource;
	}
	
	public function setDataSource( $dataSource )
	{
		$this->dataSource = $dataSource;
	}

        public function setUnparsedRecord( $recordLine )
        {
                $this->unparsedRecord = $recordLine;
        }

	public function getConfig()
	{
		return $this->config;
	}

	public function getSourceFile()
	{
		return $this->sourceFile;
	}
}


