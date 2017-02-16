<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

/**
 * ApiUserCommand class file.
 *
 * @author Steven Brendtro <steven.brendtro@gmail.com>
 * @link http://www.openach.com/
 * @copyright Copyright &copy; 2011 Imagine Solutions, Ltd
 * @license http://www.openach.com/license/
 */

class ApiUserCommand extends CConsoleCommand
{

	public function actionCreate( $user_id, $originator_info_id )
	{
		if ( ! $user = User::model()->findByPk( $user_id ) )
		{
			echo 'Unable to find user with id ' . $user_id . PHP_EOL;
			Yii::app()->end();
		}

		if ( $user->hasRole( 'administrator' ) )
		{
			echo 'Unable to add an API User to an administrator account.' . PHP_EOL;
			Yii::app()->end();
		}

		if ( ! $originatorInfo = OriginatorInfo::model()->findByPk( $originator_info_id ) )
		{
			echo 'Unable to find originator info with id ' . $originator_info_id . PHP_EOL;
			Yii::app()->end();
		}
		if ( ! $user->isAuthorized( $originatorInfo ) )
		{
			echo 'The specified user does not own the given originator info.' . PHP_EOL;
			Yii::app()->end();
		}

		echo 'Creating new API User...' . PHP_EOL;
		$userApi = new UserApi();
		$userApi->user_api_user_id = $user->user_id;
		$userApi->user_api_originator_info_id = $originatorInfo->originator_info_id;
		$userApi->user_api_status = 'enabled';

		if ( ! $userApi->save() )
		{
			echo 'Unable to save new API User: ' . var_dump($userApi->getErrors()) . PHP_EOL;
		}
		else
		{
			$userApi->refresh();
			$this->displayUserApi( $userApi );
		}
		Yii::app()->end();
	}

	public function actionView( $user_api_token )
	{
		if ( ! $userApi = UserApi::model()->findByPk( $user_api_token ) )
		{
			echo 'Unable to find API User with token ' . $user_api_token . PHP_EOL;
			Yii::app()->end();
		}

		$this->displayUserApi( $userApi );
		Yii::app()->end();
	}

	public function actionList( $user_id )
	{
		if ( ! $user = User::model()->findByPk( $user_id ) )
		{
			echo 'Unable to find user with id ' . $user_id . PHP_EOL;
			Yii::app()->end();
		}
		foreach ( $user->user_api as $userApi )
		{
			$this->displayUserApi( $userApi );
			echo "----------------------------------------------------------------------" . PHP_EOL;
		}
		echo 'Found ' . count( $user->user_api ) . ' API Users for user id ' . $user_id . PHP_EOL;
		Yii::app()->end();

	}

	public function actionDeleteAll( $user_id )
	{
		if ( ! $user = User::model()->findByPk( $user_id ) )
		{
			echo 'Unable to find user with id ' . $user_id . PHP_EOL;
			Yii::app()->end();
		}

		$command = Yii::app()->db->createCommand(Yii::app()->db->createCommand());
		$total = $command->delete( 'user_api', 'user_api_user_id = :user_id', array( ':user_id' => $user->user_id ) );

		echo 'Deleted ' . $total . ' API Users for user id ' . $user_id . PHP_EOL;
		Yii::app()->end();
	}


	public function actionDisableAll( $user_id )
	{
		if ( ! $user = User::model()->findByPk( $user_id ) )
		{
			echo 'Unable to find user with id ' . $user_id . PHP_EOL;
			Yii::app()->end();
		}
		foreach ( $user->user_api as $userApi )
		{
			$userApi->user_api_status = 'disabled';
			if ( ! $userApi->save() )
			{
				echo 'Unable to save API User with token ' . $userApi->user_api_token . '.' . PHP_EOL;
				var_dump( $userApi->getErrors() );
			}
		}
		echo 'Disabled all API Users for user id ' . $user_id . PHP_EOL;
		Yii::app()->end();
	}


	public function actionDisable( $user_api_token )
	{
		if ( ! $userApi = UserApi::model()->findByPk( $user_api_token ) )
		{
			echo 'Unable to find API User for token ' . $user_api_token . PHP_EOL;
			Yii::app()->end();
		}
		
		if ( $userApi->user_api_status == 'disabled' )
		{
			echo 'API User with token ' . $user_api_token . ' is already disabled.' . PHP_EOL;
			Yii::app()->end();
		}
		
		$userApi->user_api_status = 'disabled';
		if ( ! $userApi->save() )
		{
			echo 'Unable to save API User: ' . var_dump($userApi->getErrors()) . PHP_EOL;
		}
		echo 'API User ' . $user_api_token . ' disabled.' . PHP_EOL;
		Yii::app()->end();
	}

	public function actionEnableAll( $user_id )
	{
		if ( ! $user = User::model()->findByPk( $user_id ) )
		{
			echo 'Unable to find user with id ' . $user_id . PHP_EOL;
			Yii::app()->end();
		}
		foreach ( $user->user_api as $userApi )
		{
			$userApi->user_api_status = 'enabled';
			if ( ! $userApi->save() )
			{
				echo 'Unable to save API User with token ' . $userApi->user_api_token . '.' . PHP_EOL;
				var_dump( $userApi->getErrors() );
			}
		}
		echo 'Enabled all API Users for user id ' . $user_id . PHP_EOL;
		Yii::app()->end();
	}


	public function actionEnable( $user_api_token )
	{
		if ( ! $userApi = UserApi::model()->findByPk( $user_api_token ) )
		{
			echo 'Unable to find API User with token ' . $user_api_token . PHP_EOL;
			Yii::app()->end();
		}
		
		if ( $userApi->user_api_status == 'enabled' )
		{
			echo 'API User with token ' . $user_api_token . ' is already enabled.' . PHP_EOL;
			Yii::app()->end();
		}
		
		$userApi->user_api_status = 'enabled';
		if ( ! $userApi->save() )
		{
			echo 'Unable to save API User: ' . var_dump($userApi->getErrors()) . PHP_EOL;
		}
		echo 'API User ' . $user_api_token . ' enabled.' . PHP_EOL;
		Yii::app()->end();
	}



	protected function displayUserApi( UserApi $userApi )
	{
		echo 'API User: ' . PHP_EOL;
		echo "\tUser ID:\t\t" . $userApi->user_api_user_id . PHP_EOL;
		echo "\tOriginator Info ID:\t" . $userApi->user_api_originator_info_id . PHP_EOL;
		echo "\tApi Token:\t\t" . $userApi->user_api_token . PHP_EOL;
		echo "\tApi Key:\t\t" . $userApi->user_api_key . PHP_EOL;
		echo "\tStatus:\t\t\t" . $userApi->user_api_status . PHP_EOL;
	}
	

}
