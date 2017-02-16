<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	// Class Members
	protected $_user;

	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate()
	{

		$user = User::model()->find( 'user_login=:user_login', array( ':user_login' => $this->username ) );

		if ( $user === null )
		{
			$this->errorCode = self::ERROR_USERNAME_INVALID;
		}
		elseif ( ! $user->validatePassword( $this->password ) )
		{
			$this->errorCode = self::ERROR_PASSWORD_INVALID;
		}
		elseif ( $user->isDisabled() )
		{
			$this->errorCode = self::ERROR_USERNAME_INVALID;
		}
		else
		{
			$this->_user = $user;
			$this->errorCode = self::ERROR_NONE;
		}

		return $this->errorCode == self::ERROR_NONE;
	}

	public function getUser()
	{
		return $this->_user;
	}

	/**
	 * Returns the unique identifier for the identity.
	 * this overridden implementation returns the user_id
	 * @return string the unique identifier for the identity.
	 */
	public function getId()
        {
                return $this->_user->user_id;
        }

}
