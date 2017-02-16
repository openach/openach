<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

/**
 * PaymentProfileCommand class file.
 *
 * @author Steven Brendtro <steven.brendtro@gmail.com>
 * @link http://www.openach.com/
 * @copyright Copyright &copy; 2011 Imagine Solutions, Ltd
 * @license http://www.openach.com/license/
 */

class PaymentProfileCommand extends CConsoleCommand
{

	public function actionView( $payment_profile_id )
	{
		if ( ! $paymentProfile = PaymentProfile::model()->findByPk( $payment_profile_id ) )
		{
			echo 'Unable to find the payment profile with the id ' . $payment_profile_id . PHP_EOL;
			Yii::app()->end();
		}

		$this->displayPaymentProfile( $paymentProfile );
		Yii::app()->end();
	}

	public function actionListExternalAccounts( $payment_profile_id )
	{
		if ( ! $paymentProfile = PaymentProfile::model()->findByPk( $payment_profile_id ) )
		{
			echo 'Unable to find the payment profile with the id ' . $payment_profile_id . PHP_EOL;
			Yii::app()->end();
		}

		$criteria = new CDbCriteria();
		$criteria->together;
		$criteria->addCondition( 'external_account_payment_profile_id = :payment_profile_id' );
		$criteria->addCondition( 'payment_profile_originator_info_id = :originator_info_id' );
		$criteria->addCondition( 'external_account_status NOT IN ( :closed )' );
		$criteria->join = 'LEFT JOIN payment_profile ON payment_profile_id = external_account_payment_profile_id ';
		$criteria->params = array(
				':payment_profile_id' => $payment_profile_id,
				':originator_info_id' => $this->userApi->user_api_originator_info_id,
				':closed' => 'closed',
			);
		$models = ExternalAccount::model()->findAll( $criteria );
		if ( $models )
		{
			$exported = array();
			foreach ( $models as $model )
			{
				$model->mask();
				$exported[] = $model->apiExport('summary');
			}
			echo json_encode( $exported );
		}
		else
		{
			echo json_encode( array() );
		}
		Yii::app()->end();

	}

	public function actionDisable( $payment_profile_id )
	{
		if ( ! $paymentProfile = PaymentProfile::model()->findByPk( $payment_profile_id ) )
		{
			echo 'Unable to find payment profile with id ' . $payment_profile_id . PHP_EOL;
			Yii::app()->end();
		}
		
		if ( $paymentProfile->payment_profile_status == 'disabled' )
		{
			echo 'Payment profile with id ' . $payment_profile_id . ' is already disabled.' . PHP_EOL;
			Yii::app()->end();
		}
		
		$paymentProfile->payment_profile_status = 'disabled';
		if ( ! $paymentProfile->save() )
		{
			echo 'Unable to save payment profile: ' . var_dump($userApi->getErrors()) . PHP_EOL;
		}
		echo 'Payment Profile ' . $payment_profile_id . ' disabled.' . PHP_EOL;
		Yii::app()->end();
	}

	public function actionEnable( $payment_profile_id )
	{
		if ( ! $paymentProfile = PaymentProfile::model()->findByPk( $payment_profile_id ) )
		{
			echo 'Unable to find payment profile with id ' . $payment_profile_id . PHP_EOL;
			Yii::app()->end();
		}

		if ( $paymentProfile->payment_profile_status == 'enabled' )
		{
			echo 'Payment profile with id ' . $payment_profile_id . ' is already enabled.' . PHP_EOL;
			Yii::app()->end();
		}
		
		$paymentProfile->payment_profile_status = 'enabled';
		if ( ! $paymentProfile->save() )
		{
			echo 'Unable to save payment profile: ' . var_dump($userApi->getErrors()) . PHP_EOL;
		}
		echo 'Payment Profile ' . $payment_profile_id . ' enabled.' . PHP_EOL;
		Yii::app()->end();
	}

	public function actionSetPassword( $payment_profile_id, $password )
	{
		if ( ! $paymentProfile = PaymentProfile::model()->findByPk( $payment_profile_id ) )
		{
			echo 'Unable to find payment profile with id ' . $payment_profile_id . PHP_EOL;
			Yii::app()->end();
		}

		if ( $password == '' )
		{
			echo 'Passwords cannot be empty.';
			Yii::app()->end();
		}

		$paymentProfile->payment_profile_password = $this->hashPassword( $password );
		if ( ! $paymentProfile->save() )
		{
			echo 'Unable to save payment profile: ' . var_dump($userApi->getErrors()) . PHP_EOL;
		}
		echo 'Password set on payment profile ' . $payment_profile_id . PHP_EOL;
		echo 'NOTE: External apps relying on the password field for authentication may no longer be able to authenticate this profile.' . PHP_EOL;
		Yii::app()->end();
	}

	protected function displayPaymentProfile( PaymentProfile $paymentProfile )
	{
		echo 'Payment Profile: ' . PHP_EOL;
		echo "\tPaymentProfile ID:\t" . $paymentProfile->payment_profile_id . PHP_EOL;
		echo "\tOriginator Info ID:\t" . $paymentProfile->payment_profile_originator_info_id . PHP_EOL;
		echo "\tExternal ID:\t\t" . $paymentProfile->payment_profile_external_id . PHP_EOL;
		echo "\tEmail Address:\t\t" . $paymentProfile->payment_profile_email_address . PHP_EOL;
		echo "\tStatus:\t\t\t" . $paymentProfile->payment_profile_status . PHP_EOL;
	}

	protected function hashPassword( $password )
	{
		$securityManager = Yii::app()->securityManager;
		return hash_hmac(
				$securityManager->hashAlgorithm,
				$password,
				$securityManager->getValidationKey()
			);
	}


}
