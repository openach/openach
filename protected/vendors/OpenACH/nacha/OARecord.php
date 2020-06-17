<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

abstract class OARecord extends ODRecord implements OAHasBuilder
{
	protected $builtRecord;
	protected $builder;

	public function prepareRecordFields( OABuilder $builder)
	{
		foreach ( $this->recordFields as $recordField )
		{
			foreach ( $recordField as $fieldInfo )
			{
				$fieldInfo->setBuilder( $this->builder );
			}
		}
	}

	public function build( OADataSource $dataSource )
	{
		if ( ! $dataSource )
		{
			throw new Exception( __CLASS__ . '::build() was called without a valid data source.');
		}
		$this->builtRecord = array();
		foreach ( $this->recordFields as $fieldRules )
		{
			$formattedValue = '';
			$fieldName = '';
			foreach ( $fieldRules as $fieldRule )
			{
				if ( $fieldRule instanceof ODDataFieldConcat )
				{
					$formattedValues = array();
					foreach( $fieldRule->getFieldName() as $fieldName )
					{
						if ( isset( $dataSource->{$fieldName} ) )
						{
							$formattedValues[] = $dataSource->{$fieldName};
						}
					}
					$formattedValue = $fieldRule->format( $formattedValues );
					$fieldName = implode(',', $fieldRule->getFieldName() );
					continue;
				}
				elseif ( $fieldRule instanceof ODDataFieldName )
				{
					if ( isset( $dataSource->{$fieldRule->getFieldName()} ) )
					{
						$formattedValue = $dataSource->{$fieldRule->getFieldName()};
					}
					$fieldName = $fieldRule->getFieldName();
					continue;
				}
				if ( $fieldRule instanceof ODStaticFieldValue )
				{
					$formattedValue = $fieldRule->getStaticValue();
					continue;
				}
				try {
					$formattedValue = $fieldRule->format( $formattedValue );
				}
				catch ( Exception $e )
				{
					$dataSourceInfo = var_export( $dataSource->attributes, true );
					throw new Exception( __CLASS__ . ' encountered an exception while formatting ' . $fieldName . ': ' . $e->getMessage() . PHP_EOL . $dataSourceInfo );
				}
			}
			$this->builtRecord[] = $formattedValue;
		}
		
		return implode( $this->config->getFieldDelimiter(), $this->builtRecord );
	}
	
	public function setBuilder( OABuilder $builder )
	{
		$this->builder = $builder;
	}
	
	public function getBuilder()
	{
		return $this->builder;
	}
}


