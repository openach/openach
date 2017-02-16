<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

abstract class ODFieldInfo
{
	protected $options;
	public function __construct( $options = null )
	{
		$this->options = (object) $options;
		$this->assertOptions();
	}
	protected function getOption( $optionName )
	{
		return $this->options->{$optionName};
	}
	protected function assertOptions()
	{
		// Subclasses can extend this to require options
	}
	public function format( $fieldValue )
	{
		return $fieldValue;
	}
	public function parse( $fieldValue )
	{
		return $fieldValue;
	}
	public function validate( $fieldValue )
	{
		return true;
	}
}


