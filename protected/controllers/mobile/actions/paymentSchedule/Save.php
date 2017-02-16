<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

class Save extends OAMobileApiAction
{

	public function run()
	{
		$this->assertAuth();

		$payment_schedule_id = Yii::app()->request->getParam( 'payment_schedule_id' );
		$payment_schedule_external_account_id = Yii::app()->request->getParam( 'payment_schedule_external_account_id' );

		// If this is an existing payment schedule... 
		if ( $payment_schedule_id )
		{
			// Verify ownership before update
			if ( ! $paymentSchedule = $this->loadPaymentSchedule( $payment_schedule_id ) )
			{
				echo json_encode( $this->formatError( 'Unable to load specified payment schedule.' ) );
				Yii::app()->end();
			}

			// Verify the new external account is owned by the same payment profile
			if ( ! $externalAccount = $this->loadExternalAccountSafe( $payment_schedule_external_account_id, $paymentSchedule->external_account->external_account_payment_profile_id ) )
			{
				echo json_encode( $this->formatError( 'Unauthorized external account with external_account_id ' . $paymentSchedule->payment_schedule_payment_profile_id . '.' ) );
				Yii::app()->end();
			}

			// We don't allow changing payment_type_id's
			if ( $paymentSchedule->payment_schedule_payment_type_id != Yii::app()->request->getParam( 'payment_schedule_payment_type_id' ) )
			{
				echo json_encode( $this->formatError( 'Payment schedules cannot be reassigned to a different payment type.' ) );
				Yii::app()->end();
			}

			$paymentSchedule->apiImport( Yii::app()->request );
			$paymentSchedule->payment_schedule_remaining_occurrences = 1;
			$paymentSchedule->calculateRemaining();

			if ( ! $paymentSchedule->save() )
			{
				$errors = $paymentSchedule->getErrors();
				echo json_encode( array( 'success'=>false, 'error'=>json_encode( $errors ) ) );
				Yii::app()->end();
			}
			else
			{
				$paymentSchedule->refresh();
				echo json_encode( $this->formatSuccess( $paymentSchedule->apiExport() ) );
				Yii::app()->end();
			}
		}
		// Else, this is a new payment schedule...
		else
		{
			// Verify ownership of external account
			if ( ! $externalAccount = $this->loadExternalAccount( $payment_schedule_external_account_id ) )
			{
				echo json_encode( $this->formatError( 'Unauthorized external account.' . 'external_account_id = ' . $payment_schedule_external_account_id ) );
				Yii::app()->end();
			}

			$this->assertValidPaymentType( Yii::app()->request->getParam( 'payment_schedule_payment_type_id' );

			// Verify the payment type is owned by the originator
			$criteria = new CDbCriteria();
			$criteria->addCondition( 'payment_type_originator_info_id = :originator_info_id' );
			$criteria->addCondition( 'payment_type_id = :payment_type_id' );
			$criteria->params = array(
					':originator_info_id' => $this->paymentProfile->payment_profile_originator_info_id,
					':payment_type_id' => Yii::app()->request->getParam( 'payment_schedule_payment_type_id' ),
					':payment_type_transaction_type' => 'debit',
				);
			if ( ! $paymentType = PaymentType::model()->find( $criteria ) )
			{
				echo json_encode( $this->formatError( 'Unable to load specified payment type.' ) );
				Yii::app()->end();
			}

			$paymentSchedule = new PaymentSchedule();
			$paymentSchedule->apiImport( Yii::app()->request );

			// Attach the fields that don't get in on import
			$paymentSchedule->payment_schedule_external_account_id = $externalAccount->external_account_id;
			$paymentSchedule->payment_schedule_payment_type_id = $paymentType->payment_type_id;

			if ( ! $paymentSchedule->save() )
			{
				$errors = $paymentSchedule->getErrors();
				echo json_encode( array( 'success'=>false, 'error'=> json_encode( $errors ) ) );
				Yii::app()->end();
			}
			else
			{
				$paymentSchedule->refresh();
				echo json_encode( $this->formatSuccess( $paymentSchedule->apiExport() ) );
				Yii::app()->end();
			}
		}
	}

}
