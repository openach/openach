<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

class Connect extends OAMobileApiAction
{

	public function run($originator_info_id,$email_address,$password)
	{
		// Prevent empty passwords, as these profiles are insecure and shouldn't be allowed to connect
		if ( $password == '' )
		{
			echo json_encode( $this->formatError( 'You must specify a password.' ) );
			Yii:app()->end();
		}

		// Load the payment profile WITHOUT the password, since its encrypted until loaded
		$criteria = new CDbCriteria();
		$criteria->addCondition( 'payment_profile_email_address = :email_address' );
		$criteria->addCondition( 'payment_profile_originator_info_id = :originator_info_id' );
		$criteria->addCondition( 'payment_profile_status = :payment_profile_status' );
		$criteria->params = array(
				':email_address' => $email_address,
				':originator_info_id' => $originator_info_id,
				':payment_profile_status' => 'enabled',
			);

		$this->paymentProfile = PaymentProfile::model()->find( $criteria );
		if ( ! $this->paymentProfile || $this->paymentProfile->payment_profile_password != $this->hashPassword( $password ) )
		{
			echo json_encode( $this->formatError( 'Unable to connect using the specified originator info id, email address, and password.' ) );
			Yii::app()->getSession()->destroy();
		}
		else
		{
			$session = Yii::app()->getSession()->add( 'payment_profile_id', $this->paymentProfile->payment_profile_id );
			echo json_encode( array( 'success'=>true, 'session_id' => Yii::app()->getSession()->sessionID ) );
		}
		Yii::app()->end();
	}
}
