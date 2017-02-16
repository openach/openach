<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

class SaveComplete extends OAApiAction
{

	public function run()
	{
		$this->assertAuth();


		// Do the work, ALL INSIDE A TRANSACTION!
		// Have the rest of the code throw exceptions, catch them and roll back, then send error
		// Or on success, commit transaction and return 

	}

	protected function saveProfile()
	{

		if ( Yii::app()->request->getParam( 'payment_profile_originator_info_id' ) && Yii::app()->request->getParam( 'payment_profile_originator_info_id' ) != $this->userApi->user_api_originator_info_id )
		{
			echo json_encode( $this->formatError( 'Not authorized to update records for the specified payment_profile_originator_info_id.' ) );
			Yii:app()->end();
		}

		// Existing record
		if ( Yii::app()->request->getParam( 'payment_profile_id' ) )
		{
			$paymentProfile = $this->loadPaymentProfile( Yii::app()->request->getParam( 'payment_profile_id' ) );
			// If this is an existing record, make sure we can find it
			if ( ! $paymentProfile = $this->loadPaymentProfile( Yii::app()->request->getParam( 'payment_profile_id' ) ) )
			{
				echo json_encode( $this->formatError( 'Unable to find the specified payment profile.' ) );
				Yii::app()->end();
			}
		}
		// New Record
		else
		{
			$paymentProfile = new PaymentProfile();
		}

		$paymentProfile->apiImport( Yii::app()->request, 'edit' );
		$paymentProfile->payment_profile_originator_info_id = $this->userApi->user_api_originator_info_id;

		if ( ! $paymentProfile->save() )
		{
			$errors = $paymentProfile->getErrors();
			echo json_encode( array( 'success'=>false, 'error'=>$errors ) );
			Yii::app()->end();
		}
		else
		{
			$paymentProfile->refresh();
			$exported = $paymentProfile->apiExport();
			echo json_encode( $this->formatSuccess( $exported ) );
			Yii::app()->end();
		}
	}

}
