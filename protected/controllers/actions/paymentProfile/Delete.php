<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

class Delete extends OAApiAction
{

        public function run($payment_profile_id)
        {
                $this->assertAuth();

                if ( $payment_profile_id == '' )
                {
                        $model = new PaymentProfile();
                        echo json_encode( $this->formatSuccess( $model->apiExport() ) );
                        Yii::app()->end();
                }

                $criteria = new CDbCriteria();
                $criteria->addCondition( 'payment_profile_id = :payment_profile_id' );
                $criteria->addCondition( 'payment_profile_originator_info_id = :originator_info_id' );
                $criteria->params = array(
                                ':payment_profile_id' => $payment_profile_id,
                                ':originator_info_id' => $this->userApi->user_api_originator_info_id,
                        );
                $model = PaymentProfile::model()->find( $criteria );
                if ( $model )
                {

			$dbTrans = Yii::app()->db->beginTransaction();
			try
			{
				foreach ( $model->external_accounts as $externalAccount )
				{
					foreach ( $externalAccount->payment_schedules as $paymentSchedule )
					{
						if ( ! $paymentSchedule->delete() )
						{
							throw new \Exception( 'Unable to delete payment schedule ' . $paymentSchedule->payment_schedule_id );
						}
					}
					if ( ! $externalAccount->delete() )
					{
						throw new \Exception( 'Unable to delete external account ' . $externalAccount->external_account_id );
					}
				}
				if ( ! $model->delete() )
				{
					throw new \Exception( 'Unable to delete payment profile ' . $model->payment_profile_id );
				}
				$dbTrans->commit();
				echo json_encode( $this->formatSuccess( 'Deleted payment profile ' . $payment_profile_id  . ' and all attached records.' ) );
			}
			catch ( \Exception $e )
			{
				$dbTrans->rollback();
				echo json_encode( $this->formatError( $e->getMessage() ) );
			}

                }
                else
                {
                        echo json_encode( $this->formatError( 'Unable to find the specified payment profile for originator info id ' . $this->userApi->user_api_originator_info_id ) );
                }
                Yii::app()->end();
        }

}
