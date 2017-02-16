<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

class Connect extends OAApiAction
{

	public function run($user_api_token,$user_api_key)
	{
	//      $user_api_token = Yii::app()->request->getParam( 'user_api_token' );
	//      $user_api_key = Yii::app()->request->getParam( 'user_api_key' );
		// NOTES:
		// 1.  Need to create a model for API tokens/keys that are linked to single originator_info
		// 2.  Connecting is like 'logging in', and should generate a 'sessionid' (probably another table)
		// 3.  Subsequent access with the given 'sessionid' will allow access to other actions on the controller
		// 4.  All the other actions should rely on the 'sessionid' for determining which originator_info is the owner
		$criteria = new CDbCriteria();
		$criteria->addCondition( 'user_api_token = :user_api_token' );
		$criteria->addCondition( 'user_api_key = :user_api_key' );
		$criteria->addCondition( 'user_api_status = :user_api_status' );
		$criteria->params = array(
				':user_api_token' => $user_api_token,
				':user_api_key' => $user_api_key,
				':user_api_status' => 'enabled',
			);
		$this->userApi = UserApi::model()->find( $criteria );
		if ( ! $this->userApi )
		{
			echo json_encode( $this->formatError( 'Unable to connect with the specified api token/key.' ) );
			Yii::app()->getSession()->destroy();
		}
		else
		{
			if ( ! $this->userApi->user )
			{
				echo json_encode( $this->formatError( 'Unable to load the user specified with the api token/key.' ) );
				Yii::app()->getSession()->destroy();
			}
			else
			{
				$session = Yii::app()->getSession()->add( 'user_api_user_id', $this->userApi->user_api_user_id );
				echo json_encode( array( 'success'=>true, 'session_id' => Yii::app()->getSession()->sessionID ) );
			}
		}
		Yii::app()->end();
	}

}
