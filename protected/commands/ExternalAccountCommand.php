<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

/**
 * ExternalAccountCommand class file.
 *
 * @author Steven Brendtro <steven.brendtro@gmail.com>
 * @link http://www.openach.com/
 * @copyright Copyright &copy; 2011 Imagine Solutions, Ltd
 * @license http://www.openach.com/license/
 */

class ExternalAccountCommand extends CConsoleCommand
{

	public function actionCreate( $payment_profile_id, $routing_number, $account_number, $account_holder, $account_type )
	{
		if ( $externalAccount = ExternalAccount::accountExists( $payment_profile_id, $routing_number, $account_number ) )
		{
			echo 'The specified account already exists under the given payment profile.';
			Yii::app()->end();
		}

		if ( ! $paymentProfile = PaymentProfile::model()->findByPk( $payment_profile_id ) )
		{
			echo 'Unable to find the specified payment profile.';
			Yii::app()->end();
		}

		if ( ! $fedAch = FedACH::model()->findByAttributes( array( 'fedach_routing_number' => $routing_number ) ) )
		{
			echo 'Invalid routing number specified.';
		}

		echo 'Creating new External Account...' . PHP_EOL;

		$externalAccount = new ExternalAccount();
		$externalAccount->external_account_payment_profile_id = $paymentProfile->payment_profile_id;
		$externalAccount->external_account_dfi_id = $fedAch->fedach_routing_number;
		$externalAccount->external_account_number = $account_number;
		$externalAccount->external_account_type = $account_type;
		$externalAccount->external_account_holder = $account_holder;
		$externalAccount->external_account_bank = $fedAch->fedach_customer_name;

		if ( ! $externalAccount->save() )
		{
			echo 'Unable to save new External Account: ' . var_dump($externalAccount->getErrors()) . PHP_EOL;
		}
		else
		{
			$externalAccount->refresh();
			$this->displayExternalAccount( $externalAccount );
		}
		Yii::app()->end();
	}

	public function actionChangeAccountNumber( $payment_profile_id, $external_account_id, $account_number )
	{

		if ( ! $externalAccount = ExternalAccount::model()->findByAttributes( array(
				'external_account_id' => $external_account_id,
				'external_account_payment_profile_id' => $payment_profile_id
			) ) )
		{
			echo 'Unable to find the specified external account.';
			Yii::app()->end();
		}

		if ( ExternalAccount::accountExists( $payment_profile_id, $externalAccount->external_account_dfi_id, $account_number ) )
		{
			echo 'An account already exists with that routing and account number.' . PHP_EOL;
			Yii::app()->end();
		}

		if ( ! $paymentProfile = PaymentProfile::model()->findByPk( $payment_profile_id ) )
		{
			echo 'Unable to find the specified payment profile.';
			Yii::app()->end();
		}

		echo 'Updating External Account...' . PHP_EOL;

		$externalAccount->external_account_number = $account_number;

		if ( ! $externalAccount->save() )
		{
			echo 'Unable to save External Account: ' . var_dump($externalAccount->getErrors()) . PHP_EOL;
		}
		else
		{
			$externalAccount->refresh();
			$this->displayExternalAccount( $externalAccount );
		}
		Yii::app()->end();

	}

	public function actionChangeRoutingAndAccountNumber( $payment_profile_id, $external_account_id, $routing_number, $account_number )
	{

		if ( ! $externalAccount = ExternalAccount::model()->findByAttributes( array(
				'external_account_id' => $external_account_id,
				'external_account_payment_profile_id' => $payment_profile_id
			) ) )
		{
			echo 'Unable to find the specified external account.';
			Yii::app()->end();
		}

		if ( ExternalAccount::accountExists( $payment_profile_id, $routing_number, $account_number ) )
		{
			echo 'An account already exists with that routing and account number.' . PHP_EOL;
			Yii::app()->end();
		}
		
		if ( ! $paymentProfile = PaymentProfile::model()->findByPk( $payment_profile_id ) )
		{
			echo 'Unable to find the specified payment profile.';
			Yii::app()->end();
		}       
		
		if ( ! $fedAch = FedACH::model()->findByAttributes( array( 'fedach_routing_number' => $routing_number ) ) )
		{
			echo 'Invalid routing number specified.';
		}       
		
		echo 'Updating External Account...' . PHP_EOL;
		
		$externalAccount->external_account_dfi_id = $fedAch->fedach_routing_number;
		$externalAccount->external_account_number = $account_number;
		$externalAccount->external_account_bank = $fedAch->fedach_customer_name;

		if ( ! $externalAccount->save() )
		{
			echo 'Unable to save External Account: ' . var_dump($externalAccount->getErrors()) . PHP_EOL;
		}
		else
		{
			$externalAccount->refresh();
			$this->displayExternalAccount( $externalAccount );
		}
		Yii::app()->end();

	}

	public function actionChangeRoutingNumber( $payment_profile_id, $external_account_id, $routing_number )
	{

		if ( ! $externalAccount = ExternalAccount::model()->findByAttributes( array(
				'external_account_id' => $external_account_id,
				'external_account_payment_profile_id' => $payment_profile_id
			) ) )
		{
			echo 'Unable to find the specified external account.';
			Yii::app()->end();
		}

		if ( ExternalAccount::accountExists( $payment_profile_id, $routing_number, $externalAccount->external_account_number ) )
		{
			echo 'An account already exists with that routing and account number.' . PHP_EOL;
			Yii::app()->end();
		}
		
		if ( ! $paymentProfile = PaymentProfile::model()->findByPk( $payment_profile_id ) )
		{
			echo 'Unable to find the specified payment profile.';
			Yii::app()->end();
		}       
		
		if ( ! $fedAch = FedACH::model()->findByAttributes( array( 'fedach_routing_number' => $routing_number ) ) )
		{
			echo 'Invalid routing number specified.';
		}       
		
		echo 'Updating External Account...' . PHP_EOL;
		
		$externalAccount->external_account_dfi_id = $fedAch->fedach_routing_number;
		$externalAccount->external_account_bank = $fedAch->fedach_customer_name;

		if ( ! $externalAccount->save() )
		{
			echo 'Unable to save External Account: ' . var_dump($externalAccount->getErrors()) . PHP_EOL;
		}
		else
		{
			$externalAccount->refresh();
			$this->displayExternalAccount( $externalAccount );
		}
		Yii::app()->end();

	}

	public function actionChangeType( $payment_profile_id, $external_account_id, $type )
	{

		if ( ! $externalAccount = ExternalAccount::model()->findByAttributes( array(
				'external_account_id' => $external_account_id,
				'external_account_payment_profile_id' => $payment_profile_id
			) ) )
		{
			echo 'Unable to find the specified external account.';
			Yii::app()->end();
		}
		
		if ( ! $paymentProfile = PaymentProfile::model()->findByPk( $payment_profile_id ) )
		{
			echo 'Unable to find the specified payment profile.';
			Yii::app()->end();
		}       
		
		echo 'Updating External Account...' . PHP_EOL;
		
		$externalAccount->external_account_type = $account_type;

		if ( ! $externalAccount->save() )
		{
			echo 'Unable to save External Account: ' . var_dump($externalAccount->getErrors()) . PHP_EOL;
		}
		else
		{
			$externalAccount->refresh();
			$this->displayExternalAccount( $externalAccount );
		}
		Yii::app()->end();

	}

	public function actionChangeAccountHolder( $payment_profile_id, $external_account_id, $account_holder )
	{

		if ( ! $externalAccount = ExternalAccount::model()->findByAttributes( array(
				'external_account_id' => $external_account_id,
				'external_account_payment_profile_id' => $payment_profile_id
			) ) )
		{
			echo 'Unable to find the specified external account.';
			Yii::app()->end();
		}
		
		if ( ! $paymentProfile = PaymentProfile::model()->findByPk( $payment_profile_id ) )
		{
			echo 'Unable to find the specified payment profile.';
			Yii::app()->end();
		}       
		
		echo 'Updating External Account...' . PHP_EOL;
		
		$externalAccount->external_account_holder = $account_holder;

		if ( ! $externalAccount->save() )
		{
			echo 'Unable to save External Account: ' . var_dump($externalAccount->getErrors()) . PHP_EOL;
		}
		else
		{
			$externalAccount->refresh();
			$this->displayExternalAccount( $externalAccount );
		}
		Yii::app()->end();

	}

	public function actionExists( $payment_profile_id, $routing_number, $account_number )
	{
		if ( ExternalAccount::accountExists( $payment_profile_id, $routing_number, $account_number ) )
		{
			echo 'An account with that routing and account number exists for the given payment profile.' . PHP_EOL;
		}
		else
		{
			echo 'No account exists with that routing and account number for the given payment profile.' . PHP_EOL;
		}
		Yii::app()->end();
	}

	public function actionView( $external_account_id )
	{
		if ( ! $externalAccount = ExternalAccount::model()->findByPk( $external_account_id ) )
		{
			echo 'Unable to find External Account with id ' . $external_account_id . PHP_EOL;
			Yii::app()->end();
		}

		$this->displayExternalAccount( $externalAccount );
		Yii::app()->end();
	}

	public function actionSetStatus( $external_account_id, $status )
	{
		if ( ! $externalAccount = ExternalAccount::model()->findByPk( $external_account_id ) )
		{
			echo 'Unable to find External Account with id ' . $external_account_id . PHP_EOL;
			Yii::app()->end();
		}
		
		if ( $externalAccount->external_account_status == $status )
		{
			echo 'External Account with id ' . $external_account_id . ' already has a status of ' . $status . '.' . PHP_EOL;
			Yii::app()->end();
		}
		
		$externalAccount->user_status = $status;
		if ( ! $externalAccount->save() )
		{
			echo 'Unable to save External Account: ' . var_dump($externalAccount->getErrors()) . PHP_EOL;
		}
		echo 'External Account ' . $external_account_id . ' is now ' . $status . '.' . PHP_EOL;
		Yii::app()->end();
	}

	protected function displayExternalAccount( ExternalAccount $externalAccount )
	{
		echo 'External Account: ' . PHP_EOL;
		foreach ( $externalAccount->attributeLabels() as $field => $label )
		{
			echo "\t" . $label . "\t\t" . $externalAccount->{$field} . PHP_EOL;
		}
	}

	

}
