<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

class Save extends OAMobileApiAction
{

	public function run()
	{
		$this->assertAuth();
		$this->paymentProfile->refresh();

		if ( Yii::app()->request->getParam( 'payment_profile_originator_info_id' ) && Yii::app()->request->getParam( 'payment_profile_originator_info_id' ) != $this->paymentProfile->payment_profile_originator_info_id )
		{
			echo json_encode( $this->formatError( 'Updating the originator info id is not allowed.' ) );
			Yii:app()->end();
		}

		if ( Yii::app()->request->getParam( 'payment_profile_id' ) != $this->paymentProfile->payment_profile_id )
		{
			echo json_encode( $this->formatError( 'You are not authoried to update this payment profile.' );
		}

		$paymentProfile->apiImport( Yii::app()->request, 'edit' );

		if ( ! $paymentProfile->save() )
		{
			$errors = $paymentProfile->getErrors();
			echo json_encode( array( 'success'=>false, 'error'=>$errors ) );
			Yii::app()->end();
		}
		else
		{
			$paymentProfile->refresh();
			$exported = $paymentProfile->apiExport();
			echo json_encode( $this-> formatSuccess( $exported ) );
			Yii::app()->end();
		}
	}

}
