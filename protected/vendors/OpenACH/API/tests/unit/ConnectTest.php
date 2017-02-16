<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

class ConnectTest extends OAApiTestCase
{
	// Override auto connection as we need to test it
	public $automaticallyConnect = false;

	public function testIniConfigConnect()
	{
		$response = self::$client->connect();
		$this->assertTrue( $response->success );
	}

	/**
	 * @depends testIniConfigConnect
	 */

	public function testDisconnect()
	{
		$response = self::$client->disconnect();
		$this->assertTrue( $response->success );
	}

}
