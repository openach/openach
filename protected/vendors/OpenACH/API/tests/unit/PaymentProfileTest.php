<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

class PaymentProfileTest extends OAApiTestCase
{
	public $fixtures = array( 'payment_profile', 'payment_profile_create' );
	public $modelClass = 'PaymentProfile';

	public function testGetById()
	{
		foreach ( $this->payment_profile as $fixture )
		{
			$paymentProfileReq = new OAGetPaymentProfileRequest();
			$paymentProfileReq->payment_profile_id = $fixture['payment_profile_id'];
			$paymentProfile = self::$client->sendRequest( $paymentProfileReq );
			$this->assertTrue( $paymentProfile->success );
			$this->assertFieldsMatch( $paymentProfile, $fixture );
		}
			
	}

	public function testCreate()
	{
		foreach ( $this->payment_profile_create as $fixture )
		{
			$paymentProfileCreateReq = new OASavePaymentProfileRequest();
			foreach ( $fixture as $field => $value )
			{
				$paymentProfileCreateReq->{$field} = $value;
			}
			$paymentProfile = self::$client->sendRequest( $paymentProfileCreateReq );
			// Make sure we mark this record for clean up (deletion) on tearDown.
			$this->cleanUpRecords[] = $paymentProfile->payment_profile_id;
			echo 'Created payment profile ' . $paymentProfile->payment_profile_id . PHP_EOL;

			$this->assertRecordCreated( $paymentProfile->payment_profile_id, $fixture );
		}
	}

	protected function assertRecordCreated( $id, $fixture=null )
	{
		$paymentProfileReq = new OAGetPaymentProfileRequest();
		$paymentProfileReq->payment_profile_id = $id;
		$paymentProfile = self::$client->sendRequest( $paymentProfileReq );
		$this->assertTrue( $paymentProfile->success );
		parent::assertRecordCreated( $id, $fixture );
	}
}
