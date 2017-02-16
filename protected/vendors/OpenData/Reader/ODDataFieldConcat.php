<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 *
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

class ODDataFieldConcat extends ODDataFieldName
{
	public function __construct( $fieldName, $fieldDelimiter )
	{
		if ( ! is_array( $fieldName ) )
		{
			$fieldName = array( $fieldName );
		}
		$options = array( 'fieldName' => $fieldName, 'fieldDelimiter' => $fieldDelimiter );
		$this->options = (object) $options;
		$this->assertOptions();
	}
	protected function assertOptions()
	{
		parent::assertOptions();
		assert( isset( $this->options->fieldDelimiter ) );
	}
	public function getFieldDelimiter()
	{
		return $this->getOption('fieldDelimiter');
	}
	public function format( $fieldValue )
	{
		if ( ! is_array( $fieldValue ) )
		{
			$fieldValue = array( $fieldValue );
		}
		return implode( $this->getOption('fieldDelimiter'), $fieldValue );
	}
	public function parse( $fieldValue )
	{
		$fieldValueParts = explode( $this->getOption('fieldDelimiter'), $fieldValue );
		$fieldValueMapping = array();
		$fieldIndex = 0;
		foreach ( $this->getFieldName() as $fieldName )
		{
			if ( isset( $fieldValueParts[$fieldIndex] ) )
			{
				$fieldValueMapping[$fieldName] = $fieldValueParts[$fieldIndex];
			}
			else
			{
				$fieldValueMapping[$fieldName] = '';
			}
			$fieldIndex++;
		}
		return $fieldValueMapping;
	}
	public function parseIntoDs( $fieldValue, ODDataSource $dataSource )
	{
		$fieldValues = $this->parse( $fieldValue );
		foreach ( $fieldValues as $fieldName => $fieldValue )
		{
			$dataSource->{$fieldName} = $fieldValue;
		}
	}
}
