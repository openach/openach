<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

class GetAll extends OAMobileApiAction
{
	public function run()
	{
		$this->assertAuth();

		$external_account_id = Yii::app()->request->getParam( 'external_account_id' );

		$criteria = new CDbCriteria();
		$criteria->together;
		$criteria->addCondition( 'payment_profile_id = :payment_profile_id' );
		$criteria->addCondition( 'payment_profile_originator_info_id = :originator_info_id' );
		$criteria->addCondition( 'external_account_status NOT IN ( :closed )' );
		$criteria->join = 'LEFT JOIN external_account ON external_account_id = ach_entry_external_account_id ';
		$criteria->join .= 'LEFT JOIN payment_profile ON payment_profile_id = external_account_payment_profile_id ';
		$criteria->params = array(
				':payment_profile_id' => $this->paymentProfile->payment_profile_id,
				':originator_info_id' => $this->paymentProfile->payment_profile_originator_info_id,
				':closed' => 'closed',
			);

		if ( $external_account_id )
		{
			$criteria->addCondition( 'external_account_id = :external_account_id' );
			$criteria->params[':external_account_id'] = $external_account_id;
		}

		$criteria->order = 'ach_entry_datetime DESC';
		$models = AchEntry::model()->findAll( $criteria );
		if ( $models )
		{
			$exported = array();
			foreach ( $models as $model )
			{
				$model->mask();
				$exported[] = $model->apiExport('summary');
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
