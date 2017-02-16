<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

Yii::import( 'application.vendors.OpenData.Treasury.OfacAltConfig' );
class OfacAltTest extends ODReaderTestCase
{

	protected $testMessage = 'Loading the latest OFAC ALT list from treasury.gov and saving to the database.';
	protected $fileReaderConfigClass = 'OfacAltConfig';
	protected $fileReaderClass = 'OfacAltFileReader';
	protected $truncateTables = array( 'ofac_alt' );

}

