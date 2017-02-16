<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

class GetAll extends OAApiAction
{

	public function run()
	{
		$this->assertAuth();

		$criteria = new CDbCriteria();
		$criteria->addCondition( 'payment_type_originator_info_id = :originator_info_id' );
		$criteria->addCondition( 'payment_type_transaction_type = :debit_type' );
		$criteria->params = array(
				':originator_info_id' => $this->userApi->user_api_originator_info_id,
				':debit_type' => 'debit',
			);
		$models = PaymentType::model()->findAll( $criteria );
		if ( $models )
		{
			$exported = array();
			foreach ( $models as $model )
			{
				$exported[] = $model->apiExport();
			}
			echo json_encode( $this->formatSuccess( $exported ) );
		}
		else
		{
			echo json_encode( $this->formatSuccess( array( ) ) );
		}
		Yii::app()->end();
	}

}
