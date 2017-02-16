<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

Yii::import( 'application.vendors.OpenData.Treasury.OfacAddConfig' );
class OfacAddTest extends ODReaderTestCase
{

	protected $testMessage = 'Loading the latest OFAC ADD list from treasury.gov and saving to the database.';
	protected $fileReaderConfigClass = 'OfacAddConfig';
	protected $fileReaderClass = 'OfacAddFileReader';
	protected $truncateTables = array( 'ofac_add' );

}

