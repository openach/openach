<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

class GetById extends OAApiAction
{
	public function run($payment_type_id)
	{
		$this->assertAuth();

		$criteria = new CDbCriteria();
		$criteria->addCondition( 'payment_type_id = :payment_type_id' );
		$criteria->addCondition( 'payment_type_originator_info_id = :originator_info_id' );
		$criteria->addCondition( 'payment_type_transaction_type = :debit_type' );
		$criteria->params = array(
				':originator_info_id' => $this->userApi->user_api_originator_info_id,
				':payment_type_id' => $payment_type_id,
				':debit_type' => 'debit',
			);
		$model = PaymentType::model()->find( $criteria );
		if ( $model )
		{
			echo json_encode( $this->formatSuccess( $model->apiExport() ) );
		}
		else
		{
			echo json_encode( $this->formatError( 'Unable to find the specified payment type.' ) );
		}
		Yii::app()->end();
	}
}
