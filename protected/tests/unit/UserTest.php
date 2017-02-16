<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

Yii::import( 'application.tests.OADbTestCase' );

class UserTest extends OADbTestCase
{
	public $fixtures=array(
		'users'=>'User',
	);

	public function testLoadExtraUsers()
	{
		print "Loading additional test users..." . PHP_EOL;
		$baseUserName = 'test-user-';
		$password = 'test';
		for ( $i = 1; $i <= 50; $i++ )
		{
			$user = User::model();
			$user->user_id = UUID::mint( 4 );
			$user->user_login = $baseUserName . $i;
			$user->user_password = 'test';
			$user->user_first_name = 'Test';
			$user->user_last_name = 'User';
			$user->user_email_address = $user->user_login . '@openach.com';
			if ( !$user->save() )
			{
				var_dump( $user->getErrors() );
				throw new Exception( 'Unable to save user' );
			}
		}
	}

}
