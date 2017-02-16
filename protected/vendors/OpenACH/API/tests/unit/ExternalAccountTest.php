<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

class ExternalAccountTest extends OAApiTestCase
{
	public $fixtures = array( 'external_account', 'payment_profile' );
	public function testGetAll()
	{
		foreach ( $this->payment_profile as $paymentProfile )
		{
			$externalAccountsReq = new OAGetExternalAccountsRequest();
		
			$externalAccountsReq->payment_profile_id = $paymentProfile['payment_profile_id'];
			$externalAccounts = self::$client->sendRequest( $externalAccountsReq );
			foreach ( $externalAccounts as $externalAccount )
			{
				echo PHP_EOL . 'Found External Account' . PHP_EOL;
				foreach ( $externalAccount as $key => $value )
				{
					print "$key = $value" . PHP_EOL;
				}
			}
		}
	}
	public function testGetById()
	{
		foreach ( $this->external_account as $fixture )
		{
			$externalAccountReq = new OAGetExternalAccountRequest();
			$externalAccountReq->external_account_id = $fixture['external_account_id'];
			$externalAccount = self::$client->sendRequest( $externalAccountReq );
			$this->assertTrue( $externalAccount->success );
			foreach ( $fixture as $field => $value )
			{
				$this->assertEquals( $externalAccount->{$field}, $value );
			}
		}
			
	}

}
