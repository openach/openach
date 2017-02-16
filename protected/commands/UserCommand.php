<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

/**
 * UserCommand class file.
 *
 * @author Steven Brendtro <steven.brendtro@gmail.com>
 * @link http://www.openach.com/
 * @copyright Copyright &copy; 2011 Imagine Solutions, Ltd
 * @license http://www.openach.com/license/
 */

class UserCommand extends CConsoleCommand
{

	public function actionCreate( $user_login, $user_password, $user_email_address, $user_first_name, $user_last_name )
	{
		if ( $user = User::model()->findByAttributes( array( 'user_login' => $user_login ) ) )
		{
			echo 'User with login ' . $user_login . ' already exists.' . PHP_EOL;
			Yii::app()->end();
		}

		echo 'Creating new User...' . PHP_EOL;
		$user = new User();
		$user->user_login = $user_login;
		$user->user_password = $user_password;
		$user->user_email_address = $user_email_address;
		$user->user_first_name = $user_first_name;
		$user->user_last_name = $user_last_name;
		$user->user_status = 'enabled';

		if ( ! $user->save() )
		{
			echo 'Unable to save new User: ' . var_dump($user->getErrors()) . PHP_EOL;
		}
		else
		{
			$user->refresh();
			$this->displayUser( $user );
		}
		Yii::app()->end();
	}

	public function actionChangePassword( $user_login, $user_password )
	{
		$criteria = new CDbCriteria();
		$criteria->addCondition( 'user_login = :user_login' );
		$criteria->params = array( ':user_login' => $user_login );
		if ( ! $user = User::model()->find( $criteria ) )
		{
			echo 'Unable to find User with login ' . $user_login . PHP_EOL;
			Yii::app()->end();
		}
		$user->user_password = $user_password;
		if ( ! $user->save() )
		{
			echo 'Unable to update the password. ' . var_export( $user->getErrors(), true ) . PHP_EOL;
		}
		else
		{
			echo 'Password updated for user ' . $user_login . PHP_EOL;
		}
	}

	public function actionView( $user_id )
	{
		if ( ! $user = User::model()->findByPk( $user_id ) )
		{
			echo 'Unable to find User with id ' . $user_id . PHP_EOL;
			Yii::app()->end();
		}

		$this->displayUser( $user );
		Yii::app()->end();
	}

	public function actionViewOriginators( $user_id )
	{
		if ( ! $user = User::model()->findByPk( $user_id ) )
		{
			echo 'Unable to find User with id ' . $user_id . PHP_EOL;
			Yii::app()->end();
		}

		$this->displayUser( $user );

		foreach ( $user->originators as $originator )
		{
			$this->displayOriginator( $originator );
			foreach ( $originator->originator_info as $originator_info )
			{
				$this->displayOriginatorInfo( $originator_info );
			}
			foreach ( $originator->odfi_branches as $odfi_branch )
			{
				$this->displayOdfiBranch( $odfi_branch );
			}
		}

		Yii::app()->end();
		
	}

	public function actionDisable( $user_id )
	{
		if ( ! $user = User::model()->findByPk( $user_id ) )
		{
			echo 'Unable to find User with id ' . $user_id . PHP_EOL;
			Yii::app()->end();
		}
		
		if ( $user->user_status == 'disabled' )
		{
			echo 'User with id ' . $user_id . ' is already disabled.' . PHP_EOL;
			Yii::app()->end();
		}
		
		$user->user_status = 'disabled';
		if ( ! $user->save() )
		{
			echo 'Unable to save User: ' . var_dump($user->getErrors()) . PHP_EOL;
		}
		echo 'User ' . $user_id . ' disabled.' . PHP_EOL;
		Yii::app()->end();
	}

	public function actionEnable( $user_id )
	{
		if ( ! $user = User::model()->findByPk( $user_id ) )
		{
			echo 'Unable to find User with id ' . $user_id . PHP_EOL;
			Yii::app()->end();
		}
		
		if ( $user->user_status == 'enabled' )
		{
			echo 'User with id ' . $user_id . ' is already enabled.' . PHP_EOL;
			Yii::app()->end();
		}
		
		$user->user_status = 'enabled';
		if ( ! $user->save() )
		{
			echo 'Unable to save User: ' . var_dump($user->getErrors()) . PHP_EOL;
		}
		echo 'User ' . $user_id . ' enabled.' . PHP_EOL;
		Yii::app()->end();
	}


	public function actionGrantRole( $user_id, $role )
	{
		if ( ! $user = User::model()->findByPk( $user_id ) )
		{
			echo 'Unable to find User with id ' . $user_id . PHP_EOL;
			Yii::app()->end();
		}

		if ( $user->hasRole( $role ) )
		{
			echo 'User with id ' . $user->user_id . ' already has the role of "' . $role . '"' . PHP_EOL;
			Yii::app()->end();
		}

		if ( $role == 'adminstirator' && $user->user_api )
		{
			echo 'For security reasons you cannot assign the "administrator" role to users with API keys.';
			Yii::app()->end();
		}

		$user->grantRole( $role );

		echo 'User ' . $user_id . ' granted role of "' . $role . '" enabled.' . PHP_EOL;

		Yii::app()->end();
	}

	public function actionRevokeRole( $user_id, $role )
	{
		if ( ! $user = User::model()->findByPk( $user_id ) )
		{
			echo 'Unable to find User with id ' . $user_id . PHP_EOL;
			Yii::app()->end();
		}

		if ( ! $user->hasRole( $role ) )
		{
			echo 'User with id ' . $user->user_id . ' does not currently have the role of "' . $role . '"' . PHP_EOL;
			Yii::app()->end();
		}

		$user->revokeRole( $role );

		echo 'User ' . $user_id . ' granted role of "' . $role . '" enabled.' . PHP_EOL;

		Yii::app()->end();
	}
	

	public function actionSetup( $user_id, $name, $identification, $routing_number, $account_number, $plugin='Manual' )
	{
		if ( ! $user = User::model()->findByPk( $user_id ) )
		{
			echo 'Unable to find User with id ' . $user_id . PHP_EOL;
			Yii::app()->end();
		}

		if ( ! $routing = FedACH::model()->findByPk( $routing_number ) )
		{
			echo 'Unable to find ODFI with routing number ' . $routing_number . PHP_EOL;
			Yii::app()->end();
		}
		//$j->customer_name = $routing->fedach_customer_name;
		//$returnObj->city = $routing->fedach_city;
		//$returnObj->state_province = $routing->fedach_state_province;


		$originator = new Originator();
		$originator->originator_user_id = $user->user_id;
		$originator->originator_name = $name;
		$originator->originator_identification = $identification;

		try
		{
			$dbTrans = Yii::app()->db->beginTransaction();

			if ( ! $originator->save() )
			{
				throw new Exception( 'Unable to save originator: ' . var_export( $originator->getErrors() ), true );
			}
			//$originator->refresh();

			$odfiBranch = new OdfiBranch();
			$odfiBranch->odfi_branch_name = $routing->fedach_customer_name;
			$odfiBranch->odfi_branch_city = $routing->fedach_city;
			$odfiBranch->odfi_branch_state_province = $routing->fedach_state_province;
			$odfiBranch->odfi_branch_originator_id = $originator->originator_id;
			$odfiBranch->odfi_branch_friendly_name = $name . ' House Account';
			$odfiBranch->odfi_branch_dfi_id = $routing_number;
			$odfiBranch->odfi_branch_dfi_id_qualifier = '01';
			$odfiBranch->odfi_branch_plugin = $plugin;

			if ( ! $odfiBranch->save() )
			{
				throw new Exception( 'Unable to save OdfiBranch: ' . var_export( $odfiBranch->getErrors() ), true );
			}
			//$odfiBranch->refresh();

			$originatorInfo = new OriginatorInfo();
			$originatorInfo->originator_info_originator_id = $originator->originator_id;
			$originatorInfo->originator_info_name = $name;
			$originatorInfo->originator_info_identification = $identification;
			$originatorInfo->originator_info_odfi_branch_id = $odfiBranch->odfi_branch_id;

			if ( ! $originatorInfo->save() )
			{
				throw new Exception( 'Unable to save OdfiBranch: ' . var_export( $originatorInfo->getErrors() ), true );
			}
			//$originatorInfo->refresh();

			$externalAccount = new ExternalAccount();
			$externalAccount->external_account_originator_info_id = $originatorInfo->originator_info_id;
			$externalAccount->external_account_type = 'checking';
			$externalAccount->external_account_name = $name . ' Settlement Account';
			$externalAccount->external_account_bank = $routing->fedach_customer_name;
			$externalAccount->external_account_holder = $name;
			$externalAccount->external_account_dfi_id = $routing_number;
			$externalAccount->external_account_dfi_id_qualifier = '01';
			$externalAccount->external_account_number = $account_number;
			$externalAccount->external_account_verification_status = 'completed';
			$externalAccount->external_account_status = 'enabled';
			//$externalAccount->external_account_business = true;
			$externalAccount->external_account_business = 1;
			$externalAccount->external_account_allow_originator_payments = true;
			$externalAccount->external_account_payment_profile_id = '';

			if ( ! $externalAccount->save() )
			{
				throw new Exception( 'Unable to save ExternalAccount: ' . var_export( $externalAccount->getErrors() ), true );
			}

			$creditPaymentType = new PaymentType();
			$debitPaymentType = new PaymentType();

			$creditPaymentType->payment_type_originator_info_id = $originatorInfo->originator_info_id;
			$creditPaymentType->payment_type_name = 'Refund';
			$creditPaymentType->payment_type_transaction_type = 'credit';
			$creditPaymentType->payment_type_external_account_id = $externalAccount->external_account_id;
			
			$debitPaymentType->payment_type_originator_info_id = $originatorInfo->originator_info_id;
			$debitPaymentType->payment_type_name = 'Payment';
			$debitPaymentType->payment_type_transaction_type = 'debit';
			$debitPaymentType->payment_type_external_account_id = $externalAccount->external_account_id;


			if ( ! $creditPaymentType->save() )
			{
				throw new Exception( 'Unable to save credit PaymentType: ' . var_export( $creditPaymentType->getErrors(), true ) );
			}
			if ( ! $debitPaymentType->save() )
			{
				throw new Exception( 'Unable to save debit PaymentType: ' . var_export( $debitPaymentType->getErrors(), true ) );
			}

			$dbTrans->commit();
		}
		catch( Exception $e )
		{
			$dbTrans->rollback();
			throw $e;
		}

		echo 'User: ' . PHP_EOL;
		echo "\tOriginator:\t\t" . $originator->originator_id . PHP_EOL;
		echo "\tOriginator Info:\t" . $originatorInfo->originator_info_id . PHP_EOL;
		echo "\tOdfi Branch:\t" . $odfiBranch->odfi_branch_id . PHP_EOL;
		echo PHP_EOL;
	}



	protected function displayUser( User $user )
	{
		echo 'User: ' . PHP_EOL;
		echo "\tID:\t\t" . $user->user_id . PHP_EOL;
		echo "\tLogin:\t\t" . $user->user_login . PHP_EOL;
		echo "\tFirst Name:\t\t" . $user->user_first_name . PHP_EOL;
		echo "\tLast Name:\t\t" . $user->user_last_name . PHP_EOL;
		echo "\tStatus:\t\t\t" . $user->user_status . PHP_EOL;
		echo PHP_EOL;
	}

	protected function displayOriginator( Originator $originator )
	{
		echo "\tOriginator: " . PHP_EOL;
		echo "\t\tID:\t\t" . $originator->originator_id . PHP_EOL;
		echo "\t\tName:\t\t" . $originator->originator_name . PHP_EOL;
		echo PHP_EOL;
	}

	protected function displayOriginatorInfo( OriginatorInfo $originator_info )
	{
		echo "\t\tOriginator Info: " . PHP_EOL;
		echo "\t\t\tID:\t\t" . $originator_info->originator_info_id . PHP_EOL;
		echo "\t\t\tName:\t\t" . $originator_info->originator_info_name . PHP_EOL;
		echo PHP_EOL;
	}

	protected function displayOdfiBranch( OdfiBranch $odfi_branch )
	{
		echo "\t\tOdfi Branch: " . PHP_EOL;
		echo "\t\t\tID:\t\t" . $odfi_branch->odfi_branch_id . PHP_EOL;
		echo "\t\t\tName:\t\t" . $odfi_branch->odfi_branch_friendly_name . PHP_EOL;
		echo "\t\t\tPlugin:\t\t" . $odfi_branch->odfi_branch_plugin . PHP_EOL;
	}


	public function actionViewAll( $user_login )
	{
		$user = User::model()->findByAttributes( array( 'user_login'=> $user_login ) );
		$this->displayUser( $user );
		var_dump( $user->roles );
	}

	

}
