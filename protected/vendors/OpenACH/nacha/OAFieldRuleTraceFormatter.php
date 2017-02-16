<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/



class OAFieldRuleTraceFormatter extends ODFieldRule
{
	public function __construct( OABankConfig $bankConfig )
	{
		$options = new stdClass();
		$options->bankConfig = $bankConfig;
		parent::__construct( $options );
	}

	protected function assertOptions()
	{
		if ( ! isset( $this->options->bankConfig ) || ! $this->options->bankConfig instanceof OABankConfig )
		{
			throw new Exception( __CLASS__ . ' requires an option of bankConfig, provided as a class of OABankConfig.' );
		}
	}
	public function format( $fieldValue )
	{
		return $this->options->bankConfig->formatTraceNumber( $fieldValue );
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

