<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

abstract class OABuilder extends OAObject implements OAHasBuilder
{
	protected $builderChain = array();
	protected $config;
	protected $headerRecordModel;
	protected $controlRecordModel;
	protected $builtRecords;
	protected $builder;
	protected $dataSource;
	protected $builderDataSource;
		
	public function __construct( OAConfig $config )
	{
		$this->config = $config;
		$this->initRecordModels();
		$this->initBuilderChain();
	}
	
	abstract protected function hasValidDataSource();
	abstract protected function initBuilderDataSource();
	
	public function build( OADataSource $dataSource )
	{
		$this->dataSource = $dataSource;
		$this->initBuilderDataSource();

		if ( ! $this->hasValidDataSource() )
		{
			return;
		}

		$this->builtRecords = array();

		foreach ( $this->builderChain as $recordBuilderModel )
		{
			if ( $recordBuilderModel instanceof OAHeaderRecord  || $recordBuilderModel instanceof OAControlRecord )
			{
				$this->builtRecords[] = $recordBuilderModel->build( $this->dataSource );
				continue;
			}
			
			if ( $recordBuilderModel instanceof OADetailRecord || $recordBuilderModel instanceof OABatchBuilder )
			{
				foreach ( $this->builderDataSource as $dataSource )
				{
					$this->prepareRecordForBuild( $dataSource );
					$builtRecord = $recordBuilderModel->build( $dataSource );
					if ( trim( $builtRecord ) )
					{
						$this->builtRecords[] = $builtRecord;
					}
				}
			}
		}

		return implode( $this->config->getLineDelimiter(), $this->builtRecords );
	}

	protected function prepareRecordForBuild( OADataSource $dataSource )
	{
		return;
	}

	abstract protected function initRecordModels();

	protected function initBuilderChain()
	{
		foreach ( $this->builderChain as $builderModel )
		{
			$builderModel->setBuilder( $this );
		}
	}
	
	public function getControlRecordModel()
	{
		return $this->controlRecordModel;
	}
	
	public function setBuilder( OABuilder $builder )
	{
		$this->builder = $builder;
	}
	
	public function getBuilder()
	{
		return $this->builder;
	}

	public function getDataSource()
	{
		return $this->dataSource;
	}

	public function getBuilderDataSource()
	{
		return $this->builderDataSource();
	}

}
