<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

class GetAllByPaymentProfileId extends OAApiAction
{
	public function run($payment_profile_id)
	{
		$this->assertAuth();

		$criteria = new CDbCriteria();
		$criteria->together;
		$criteria->addCondition( 'external_account_payment_profile_id = :payment_profile_id' );
		$criteria->addCondition( 'payment_profile_originator_info_id = :originator_info_id' );
		$criteria->addCondition( 'external_account_status NOT IN ( :closed )' );
		$criteria->join = 'LEFT JOIN payment_profile ON payment_profile_id = external_account_payment_profile_id ';
		$criteria->params = array(
				':payment_profile_id' => $payment_profile_id,
				':originator_info_id' => $this->userApi->user_api_originator_info_id,
				':closed' => 'closed',
			);
		$models = ExternalAccount::model()->findAll( $criteria );
		if ( $models )
		{
			$exported = array();
			foreach ( $models as $model )
			{
				$model->mask();
				$exported[] = $model->apiExport();
			}
			echo json_encode( $this->formatSuccess( $exported ) );
		}
		else
		{
			echo json_encode( $this->formatSuccess( array() ) );
		}
		Yii::app()->end();
	}
}
