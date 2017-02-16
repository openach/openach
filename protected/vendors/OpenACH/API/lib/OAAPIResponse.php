<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

class OAAPIResponse extends OAAPIBase
{
	public $postFields = '';
	public $header = '';
	public $body = '';
	public $error = '';
	public $httpCode = '';
	public $lastUrl = '';
	public $success = false;
}
