<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

Yii::import( 'application.vendors.OpenData.FederalReserve.FedwireDirectoryConfig' );
class FedwireDirectoryTest extends ODReaderTestCase
{

	protected $testMessage = 'Loading the latest Fedwire routing directory from frb.org and saving to the database.';
	protected $fileReaderConfigClass = 'FedwireDirectoryConfig';
	protected $fileReaderClass = 'FedwireDirectoryFileReader';
	protected $truncateTables = array( 'fedwire' );

}

