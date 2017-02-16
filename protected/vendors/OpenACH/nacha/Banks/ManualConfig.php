<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

class ManualConfig extends OABankConfig
{
	const PLUGIN_CLASS = 'ManualConfig';
	const PLUGIN_VERSION = '0.1';
	const TRANSFER_AGENT = 'Manual';

 	protected $testModelClass = 'ManualTest';
	protected $gatewayDfiId = '';
	protected $errorMessages = array();

	public function defaults()
	{
		return array(
			'ACH File Path' => '',
			'ACH Filename' => 'x380.acfh9399.w700',
			'ACH Confirm Path' => '',
			'ACH Confirm Filename' => 'w700.xcfmf198.x380',
			'ACH Return Path' => '',
			'ACH Return Filename' => 'w700.acrt0343.x380',
		);
	}
}

class ManualTest extends OABankTest
{
	
}
