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
	public function run($external_account_id)
	{
		$this->assertAuth();

		if ( $external_account_id == '' )
		{
			$model = new ExternalAccount();
			echo json_encode( $this->formatSuccess( $model->apiExport() ) );
			Yii::app()->end();
		}

		$criteria = new CDbCriteria();
		$criteria->together = true;
		$criteria->addCondition( 'external_account_id = :external_account_id' );
		$criteria->addCondition( 'payment_profile_originator_info_id = :originator_info_id' );
		$criteria->join = 'LEFT JOIN payment_profile ON payment_profile_id = external_account_payment_profile_id';
		$criteria->params = array(
				':external_account_id' => $external_account_id,
				':originator_info_id' => $this->userApi->user_api_originator_info_id,
			);
		$model = ExternalAccount::model()->find( $criteria );
		if ( $model )
		{
			echo json_encode( $this->formatSuccess( $model->apiExport() ) );
		}
		else
		{
			echo json_encode( $this->formatError( 'Unable to find the specified external account.' ) );
		}
		Yii::app()->end();
	}

}
