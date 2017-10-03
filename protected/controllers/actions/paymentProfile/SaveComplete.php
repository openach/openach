<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2017 OpenACH, Inc., ALL RIGHTS RESERVED
 * By Steven Brendtro
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

class SaveComplete extends OAApiAction
{

	protected $paymentProfile;
	protected $externalAccount;
	protected $paymentSchedule;

	public function run()
	{

		$dbTrans = Yii::app()->db->beginTransaction();
		try
		{
			$this->assertAuth();
			$profile = $this->savePaymentProfile();
			$account = $this->saveExternalAccount();
			$schedule = $this->savePaymentSchedule();

			$result = new \stdClass;
			$result->payment_profile = $profile;
			$result->external_account = $account;
			$result->payment_schedule = $schedule;

			$dbTrans->commit();
		}
		catch ( ArrayException $e )
		{
			$dbTrans->rollback();
			echo json_encode( $this->formatError( $e->getArrayMessage() ) );
			Yii::app()->end();
		}
		catch ( \Exception $e )
		{
			$dbTrans->rollback();
			echo json_encode( $this->formatError( $e->getMessage() ) );
			Yii::app()->end();
		}

		echo json_encode( $this->formatSuccess( $result ) );
		Yii::app()->end();
	}

	public function savePaymentProfile()
	{

		if ( Yii::app()->request->getParam( 'payment_profile_originator_info_id' ) && Yii::app()->request->getParam( 'payment_profile_originator_info_id' ) != $this->userApi->user_api_originator_info_id )
		{
			throw new \Exception( 'Not authorized to update records for the specified payment_profile_originator_info_id.' );
		}

		// Existing record
		if ( Yii::app()->request->getParam( 'payment_profile_id' ) )
		{
			$paymentProfile = $this->loadPaymentProfile( Yii::app()->request->getParam( 'payment_profile_id' ) );
			// If this is an existing record, make sure we can find it
			if ( ! $paymentProfile = $this->loadPaymentProfile( Yii::app()->request->getParam( 'payment_profile_id' ) ) )
			{
				throw new \Exception( 'Unable to find the specified payment profile.' );
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
					throw new \Exception( 'A payment profile with that external id already exists.' );
				}
			}

			$paymentProfile = new PaymentProfile();
		}

		$paymentProfile->apiImport( Yii::app()->request, 'edit' );
		$paymentProfile->payment_profile_originator_info_id = $this->userApi->user_api_originator_info_id;

		if ( ! $paymentProfile->save() )
		{
			$errors = $paymentProfile->getErrors();
			throw new ArrayException( $errors );
		}
		else
		{
			$paymentProfile->refresh();
			$this->paymentProfile = $paymentProfile;
			$exported = $paymentProfile->apiExport();
			return $exported;
		}
	}

	public function saveExternalAccount()
	{

		// Existing record
		if ( $external_account_id = Yii::app()->request->getParam( 'external_account_id' ) )
		{
			// If this is an existing record, make sure we can find it
			if ( ! $externalAccount = $this->loadExternalAccountSafe( $external_account_id, $this->paymentProfile->payment_profile_id ) )
			{
				throw new \Exception( 'Unable to find the specified external account.' );
			}
			// Remove the account number and routing number, as we don't allow modifying these via the API
			// NOTE that this is done at the _GET and _POST level, as the request object just pulls from there

			$accountNumber = $externalAccount->external_account_number;
			$accountDfiId = $externalAccount->external_account_dfi_id;
			unset( $_GET['external_account_dfi_id'] );
			unset( $_POST['external_account_dfi_id'] );
			unset( $_GET['external_account_number'] );
			unset( $_POST['external_account_number'] );
			$externalAccount->apiImport( Yii::app()->request );

			$externalAccount->external_account_dfi_id = $accountDfiId;
			$externalAccount->external_account_number = $accountNumber;

			$this->externalAccount = $externalAccount;
		}
		// New Record
		else
		{
			$externalAccount = new ExternalAccount();
			$externalAccount->apiImport( Yii::app()->request );

			// Verify that the account isn't already set up for this payment profile
			if ( ExternalAccount::accountExists( $this->paymentProfile->payment_profile_id, $externalAccount->external_account_dfi_id, $externalAccount->external_account_number ) )
			{
				throw new \Exception('An account with that routing and account number already exists for this payment profile.');
			}
		}

		// Set required fields that aren't pulled in through the apiImport
		$externalAccount->external_account_payment_profile_id = $this->paymentProfile->payment_profile_id;

		if ( ! $externalAccount->save() )
		{
			$errors = $externalAccount->getErrors();
			throw new ArrayException( $errors );
		}
		else
		{
			$externalAccount->refresh(); // Make sure to reload from the DB, avoiding any false-saves
			$this->externalAccount = $externalAccount;
			$exported = $externalAccount->apiExport();
			return $exported;
		}
	}

	public function savePaymentSchedule()
	{

		$payment_schedule_id = Yii::app()->request->getParam( 'payment_schedule_id' );

		// If this is an existing payment schedule... 
		if ( $payment_schedule_id )
		{
			// Verify ownership before update
			if ( ! $paymentSchedule = $this->loadPaymentSchedule( $payment_schedule_id ) )
			{
				throw new \Exception( 'Unable to load specified payment schedule.' );
			}

			// We don't allow changing payment_type_id's
			if ( $paymentSchedule->payment_schedule_payment_type_id != Yii::app()->request->getParam( 'payment_schedule_payment_type_id' ) )
			{
				throw new \Exception( 'Payment schedules cannot be reassigned to a different payment type.' );
			}

			$paymentSchedule->apiImport( Yii::app()->request );
			$paymentSchedule->payment_schedule_remaining_occurrences = 1;
			$paymentSchedule->calculateRemaining();

			if ( $paymentSchedule->payment_schedule_amount <= 0.00 )
			{
				throw new \Exception( 'payment_schedule_amount must be greater than 0.00' );
			}

			if ( ! $paymentSchedule->save() )
			{
				$errors = $paymentSchedule->getErrors();
				throw new ArrayException( $errors );
			}
			else
			{
				$paymentSchedule->refresh();
				$this->paymentSchedule = $paymentSchedule;
				$exported = $paymentSchedule->apiExport();
				return $exported;
			}
		}
		// Else, this is a new payment schedule...
		else
		{

			if ( ! Yii::app()->request->getParam( 'payment_schedule_payment_type_id' ) )
			{
				throw new \Exception( 'You must specify a payment_schedule_payment_type_id.' );
			}

			// Verify the payment type is owned by the originator
			$criteria = new CDbCriteria();
			$criteria->addCondition( 'payment_type_originator_info_id = :originator_info_id' );
			$criteria->addCondition( 'payment_type_id = :payment_type_id' );
			$criteria->params = array(
					':originator_info_id' => $this->userApi->user_api_originator_info_id,
					':payment_type_id' => Yii::app()->request->getParam( 'payment_schedule_payment_type_id' ),
				);
			if ( ! $paymentType = PaymentType::model()->find( $criteria ) )
			{
				throw new \Exception( 'Unable to load specified payment type.' );
			}

			$paymentSchedule = new PaymentSchedule();
			$paymentSchedule->apiImport( Yii::app()->request );

			// Attach the fields that don't get in on import
			$paymentSchedule->payment_schedule_external_account_id = $this->externalAccount->external_account_id;
			$paymentSchedule->payment_schedule_payment_type_id = $paymentType->payment_type_id;

			if ( $paymentSchedule->payment_schedule_amount <= 0.00 )
			{
				throw new \Exception( 'payment_schedule_amount must be greater than 0.00' );
			}

			if ( ! $paymentSchedule->save() )
			{
				$errors = $paymentSchedule->getErrors();
				throw new ArrayException( $errors);
			}
			else
			{
				$paymentSchedule->refresh();
				$this->paymentSchedule = $paymentSchedule;
				$exported = $paymentSchedule->apiExport();
				return $exported;
			}
		}
	}

}

class ArrayException extends Exception
{
	private $arrayMessage = null;
	public function __construct($message = null, $code = 0, Exception $previous = null)
	{
		if ( is_array($message) )
		{
			$this->arrayMessage = $message;
			$message = null;
		}
		$this->exception = new Exception($message,$code,$previous);
	}

	public function getArrayMessage(){
		return $this->arrayMessage ? $this->arrayMessage : parent::getMessage();
	}
}
