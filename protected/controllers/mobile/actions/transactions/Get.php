<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

class Get extends OAMobileApiAction
{
	public function run($transaction_id)
	{
		$this->assertAuth();

		$criteria = new CDbCriteria();
		$criteria->addCondition( 'ach_entry_id = :ach_entry_id' );
		$criteria->addCondition( 'payment_profile_id = :payment_profile_id' );
		$criteria->addCondition( 'payment_profile_originator_info_id = :originator_info_id' );
		$criteria->addCondition( 'external_account_status NOT IN ( :closed )' );
		$criteria->join = 'LEFT JOIN external_account ON external_account_id = ach_entry_external_account_id ';
		$criteria->join .= 'LEFT JOIN payment_profile ON payment_profile_id = external_account_payment_profile_id ';
		$criteria->params = array(
				':ach_entry_id' => $transaction_id,
				':payment_profile_id' => $this->paymentProfile->payment_profile_id,
				':originator_info_id' => $this->paymentProfile->payment_profile_originator_info_id,
				':closed' => 'closed',
			);

		$model = AchEntry::model()->find( $criteria );
		if ( $model )
		{
			echo json_encode( $this->formatSuccess( $model->apiExport() ) );
		}
		else
		{
			echo json_encode( $this->formatError( 'Unable to find the specified transaction.' ) );
		}
		Yii::app()->end();
	}

}
