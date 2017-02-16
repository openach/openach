<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

class OAApiAction extends CAction
{

	protected $userApi;

	protected function formatError( $errorMsg )
	{
		return $this->formatResult( false, $errorMsg, null );
	}

	protected function formatSuccess( $data )
	{
		return $this->formatResult( true, null, $data );
	}

	protected function formatResult( $success, $errorMsg, $data )
	{
		$result = new stdClass();
		$result->success = $success;
		if (null !== $errorMsg) $result->error = $errorMsg;
		if (null !== $data) $result->data = $data;
		return $result;
	}

	protected function assertAuth()
	{
		$this->userApi = UserApi::model()->findByAttributes( array( 'user_api_user_id' => Yii::app()->getSession()->get('user_api_user_id') ) );
		if ( ! $this->userApi )
		{
			echo json_encode( $this->formatError( 'Not authenticated with token/key. Please connect first.' ) );
			Yii::app()->end();
		}
	}

	protected function assertValidPaymentType( $payment_type_id )
	{
		foreach ( $this->userApi->originator_info->payment_types as $payment_type )
		{
			if ( $payment_type->payment_type_id == $payment_type_id && $payment_type->payment_type_status = 'enabled' )
			{
				return true;
			}
		}
		echo json_encode( $this->formatError( 'The specified payment type is either invalid or disabled.' ) );
		Yii::app()->end();
	}

	protected function loadExternalAccountSafe( $external_account_id, $payment_profile_id )
	{
		$criteria = new CDbCriteria();
		$criteria->together = true;
		$criteria->addCondition( 'external_account_id = :external_account_id' );
		$criteria->addCondition( 'payment_profile_originator_info_id = :originator_info_id' );
		$criteria->addCondition( 'payment_profile_id = :payment_profile_id' );
		$criteria->join = 'LEFT JOIN payment_profile ON payment_profile_id = external_account_payment_profile_id';
		$criteria->params = array(
				':external_account_id' => $external_account_id,
				':payment_profile_id' => $payment_profile_id,
				':originator_info_id' => $this->userApi->user_api_originator_info_id,
			);

		return ExternalAccount::model()->find( $criteria );
	}

	protected function loadExternalAccount( $external_account_id )
	{
		$criteria = new CDbCriteria();
		$criteria->together = true;
		$criteria->addCondition( 'external_account_id = :external_account_id' );
		$criteria->addCondition( 'payment_profile_originator_info_id = :originator_info_id' );
		$criteria->join = 'LEFT JOIN payment_profile ON payment_profile_id = external_account_payment_profile_id';
		$criteria->params = array(
				':external_account_id' => $external_account_id,
				':originator_info_id' => $this->userApi->user_api_originator_info_id,
			);

		return ExternalAccount::model()->find( $criteria );
	}

	protected function loadPaymentScheduleSafe( $payment_schedule_id, $external_account_id )
	{
		$criteria = new CDbCriteria();
		$criteria->together = true;
		$criteria->addCondition( 'payment_schedule_id = :payment_schedule_id' );
		$criteria->addCondition( 'external_account_id = :external_account_id' );
		$criteria->addCondition( 'payment_profile_originator_info_id = :originator_info_id' );
		$criteria->join = 'LEFT JOIN external_account ON external_account_id = payment_schedule_external_account_id ';
		$criteria->join .= 'LEFT JOIN payment_profile ON payment_profile_id = external_account_payment_profile_id ';
		$criteria->params = array(
				':external_account_id' => $external_account_id,
				':payment_schedule_id' => $payment_schedule_id,
				':originator_info_id' => $this->userApi->user_api_originator_info_id,
			);

		return PaymentSchedule::model()->find( $criteria );
	}

	protected function loadPaymentSchedule( $payment_schedule_id )
	{
		$criteria = new CDbCriteria();
		$criteria->together = true;
		$criteria->addCondition( 'payment_schedule_id = :payment_schedule_id' );
		$criteria->addCondition( 'payment_profile_originator_info_id = :originator_info_id' );
		$criteria->join = 'LEFT JOIN external_account ON external_account_id = payment_schedule_external_account_id ';
		$criteria->join .= 'LEFT JOIN payment_profile ON payment_profile_id = external_account_payment_profile_id ';
		$criteria->params = array(
				':payment_schedule_id' => $payment_schedule_id,
				':originator_info_id' => $this->userApi->user_api_originator_info_id,
			);

		return PaymentSchedule::model()->find( $criteria );
	}

	protected function loadPaymentProfile( $payment_profile_id )
	{
		$criteria = new CDbCriteria();
		$criteria->addCondition( 'payment_profile_id = :payment_profile_id' );
		$criteria->addCondition( 'payment_profile_originator_info_id = :originator_info_id' );
		$criteria->params = array(
				':payment_profile_id' => $payment_profile_id,
				':originator_info_id' => $this->userApi->user_api_originator_info_id,
			);
		return PaymentProfile::model()->find( $criteria );
	}

}
