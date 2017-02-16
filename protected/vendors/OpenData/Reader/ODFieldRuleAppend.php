<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

class ODFieldRuleAppend extends ODFieldRule
{
	public function __construct( $staticValue )
	{
		parent::__construct( array( 'staticValue' => $staticValue ) );
	}
	protected function assertOptions()
	{	
		assert( isset( $this->options->staticValue ) );
	}
	public function getStaticValue()
	{
		return $this->getOption('staticValue');
	}
	public function format( $fieldValue )
	{
		return $fieldValue . $this->getStaticValue();
	}
	public function parse( $fieldValue )
	{
		return rtrim( $fieldValue, $this->getStaticValue() );
	}
}


