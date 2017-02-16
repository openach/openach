<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

class Save extends OAApiAction
{

	public function run()
	{
		$this->assertAuth();

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
			// Only perform this check if the payment_profile_external_id is provided - if they don't provide it, 
			// they will get an error back from the PaymentProfile's rule validation when we try to save it.
			// This is just to ensure that they don't try to duplicate external ids, as they are constrained 
			// as unique within a given payment_profile_originator_info_id
			if ( $payment_profile_external_id = Yii::app()->request->getParam( 'payment_profile_external_id' ) )
			{
				// Verify that this external id doesn't already exist
				$criteria = new CDbCriteria();
				$criteria->addCondition( 'payment_profile_external_id = :payment_profile_external_id' );
				$criteria->addCondition( 'payment_profile_originator_info_id = :originator_info_id' );
				$criteria->params = array(
						':payment_profile_external_id' => $payment_profile_external_id,
						':originator_info_id' => $this->userApi->user_api_originator_info_id,
					);
				if ( $model = PaymentProfile::model()->find( $criteria ) )
				{
					echo json_encode( $this->formatError( 'A payment profile with that external id already exists.' ) );
				}
			}

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
