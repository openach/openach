<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

class PaymentTypeTest extends OAApiTestCase
{
	public $fixtures = array( 'payment_type' );

	public function testGetById()
	{
		foreach ( $this->payment_type as $fixture )
		{
			$paymentTypeReq = new OAGetPaymentTypeRequest();
			$paymentTypeReq->payment_type_id = $fixture['payment_type_id'];
			$paymentType = self::$client->sendRequest( $paymentTypeReq );
			$this->assertTrue( $paymentType->success );
			foreach ( $fixture as $field => $value )
			{
				$this->assertEquals( $paymentType->{$field}, $value );
			}
		}
			
	}

	public function testGetAll()
	{
		$paymentTypesReq = new OAGetpaymentTypesRequest();

		$paymentTypes = self::$client->sendRequest( $paymentTypesReq );
		foreach ( $paymentTypes as $paymentType )
		{
			echo PHP_EOL . 'Found Payment Type' . PHP_EOL;
			foreach ( $paymentType as $key => $value )
			{
				print "$key = $value" . PHP_EOL;
			}
		}
	}

}
