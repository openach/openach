<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

abstract class ODRecord
{
	protected $config;
	protected $recordFields = array();
	protected $recordFieldsMetadata = array();
	protected $fieldDelimiter;
	protected $reader;

	public function __construct( ODConfig $config )
	{
		$this->config = $config;
		$this->initRecordFields();
	}

	abstract protected function initRecordFields();
	abstract protected function readerHasValidDataSource();
	abstract protected function recordValidToProcess( $recordLine );
	
	protected function readerDataSource()
	{
		return $this->reader->getDataSource();
	}

	protected function dataSource()
	{
		return new ODDataSource();
	}
	
	public function parse( $recordLine )
	{
		$cursorPosition = 0;
		$fieldIndex = 0;

		if ( ! $this->recordValidToProcess( $recordLine ) )
		{
			return;
		}

		if ( ! $this->readerHasValidDataSource() )
		{
			return;
		}

		$dataSource = $this->dataSource();

		foreach ( $this->recordFieldsMetadata as $fieldMetadata )
		{

			$staticValueEnforced = false;
			if ( isset( $fieldMetadata['fieldEnforceValue'] ) )
			{
				$staticValueEnforced = true;
				$fieldEnforceValue = $fieldMetadata['fieldEnforceValue']->getStaticValue();
			}

			$fieldNameRule = $fieldMetadata['fieldName'];
			$fieldLengthRule = $fieldMetadata['fieldLength'];
			
			$fieldLength = $fieldLengthRule->getLength();
			
			$parsedData = substr( $recordLine, $cursorPosition, $fieldLength );
			$parsedData = $this->filterData( $parsedData );

			if ( $staticValueEnforced && $fieldEnforceValue != $parsedData )
			{
				return false;
			}
				
			$fieldRules = $this->recordFields[ $fieldIndex ];
			
			// Run through the rules backwards, e.g. the opposite order from which the record was built
			for ( $fieldRuleIndex = count( $fieldRules ) - 1; $fieldRuleIndex >= 0; $fieldRuleIndex-- )
			{
				$fieldRule = $fieldRules[ $fieldRuleIndex ];
				if ( ! $fieldRule instanceof ODDataFieldName )
				{
					$parsedData = $fieldRule->parse( $parsedData );
				}
			}

			if ( $fieldNameRule instanceof ODDataFieldConcat )
			{
				$fieldNameRule->parseIntoDs( $parsedData, $dataSource );
			}
			elseif( $fieldNameRule instanceof ODDataFieldName )
			{
				$fieldName = $fieldNameRule->getFieldName();
				$dataSource->{$fieldName} = $parsedData;
			}

			$cursorPosition += $fieldLength;
			$fieldIndex++;
		}

		// Allow for remapping the fields
		$this->remapDataSource( $dataSource );

		return $dataSource;
	}
	
	public function addField( $fieldRules )
	{
		$fieldName = null;
		$fieldLength = null;
		$fieldEnforceValue = null;

		foreach ( $fieldRules as $fieldRule )
		{
			if ( ! $fieldRule instanceof ODFieldInfo )
			{
				throw new Exception( 'Only ODFieldInfo objects can be used to add fields.' );
			}
			if ( $fieldRule instanceof ODDataFieldName )
			{
				$fieldName = $fieldRule;
			}
			elseif ( $fieldRule instanceof ODStaticFieldValueEnforced )
			{
				$fieldEnforceValue = $fieldRule;
			}
			elseif ( $fieldRule instanceof ODFieldRuleLength )
			{
				$fieldLength = $fieldRule;
			}
		}
		if ( $fieldName && $fieldLength )
		{
			$metaData = array( 'fieldName' => $fieldName, 'fieldLength' => $fieldLength );
			if ( $fieldEnforceValue )
			{
				$metaData['fieldEnforceValue'] = $fieldEnforceValue;
			}
			$this->recordFieldsMetadata[] = $metaData;
			$this->recordFields[] = $fieldRules;
		}
		else
		{
			throw new Exception( 'Valid field rules require both a ODDataFieldName and ODFieldRuleLength' );
		}
	}

	protected function filterData( $data )
	{
		return $data;
	}
	
	public function remapDataSource( ODDataSource $dataSource )
	{
		return $dataSource;
	}

	public function setReader( ODReader $reader )
	{
		$this->reader = $reader;
	}

	public function getReader()
	{
		return $this->reader;
	}
	
}

