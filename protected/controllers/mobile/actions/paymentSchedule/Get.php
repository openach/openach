<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

class GetById extends OAMobileApiAction
{

	public function run($payment_schedule_id)
	{
		$this->assertAuth();

		if ( $payment_schedule_id == '' )
		{
			$model = new PaymentSchedule();
			$model->payment_schedule_payment_profile_id = $this->paymentProfile->payment_profile_id;
			echo json_encode( $this->formatSuccess( $model->apiExport() ) );
			Yii::app()->end();
		}

		$criteria = new CDbCriteria();
		$critieria->together = true;
		$criteria->addCondition( 'payment_schedule_id = :payment_schedule_id' );
		$criteria->addCondition( 'payment_profile_id = :payment_profile_id' );
		$criteria->addCondition( 'payment_profile_originator_info_id = :originator_info_id' );
		$criteria->join = 'LEFT JOIN external_account ON external_account_id = payment_schedule_external_account_id ';
		$criteria->join .= 'LEFT JOIN payment_profile ON payment_profile_id = external_account_payment_profile_id ';
		$criteria->params = array(
				':payment_schedule_id' => $payment_schedule_id,
				':payment_profile_id' => $this->paymentProfile->payment_profile_id,
				':originator_info_id' => $this->paymentProfile->payment_profile_originator_info_id,
			);
		$model = PaymentSchedule::model()->find( $criteria );
		if ( $model )
		{
			echo json_encode( $this->formatSuccess( $model->apiExport() ) );
		}
		else
		{
			echo json_encode( $this->formatError( 'Unable to find the specified payment schedule.' ) );
		}
		Yii::app()->end();
	}

}
