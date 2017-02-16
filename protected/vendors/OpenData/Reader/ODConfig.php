<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

class ODConfig extends ODObject
{
	protected $configState;

	public function __construct()
	{
		parent::__construct();
		$this->init();
	}

	public function init()
	{
		$this->configState = array();
		return;
	}

	public function getConfig( $configKey )
	{
		if ( isset( $this->configState[$configKey] ) )
		{
			return $this->configState[$configKey];
		}
		else
		{
			return;
		}
	}
	public function getConfigState()
	{
		return $this->configState;
	}
	public function getLineDelimiter()
	{
		return PHP_EOL;
	}
	public function getFieldDelimiter()
	{
		return '';
	}

}
