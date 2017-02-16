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
                        echo json_encode( $this->formatSuccess( $model->apiExport() ) );
                }
                else
                {
                        echo json_encode( $this->formatError( 'Unable to find the specified payment profile for originator info id ' . $this->userApi->user_api_originator_info_id ) );
                }
                Yii::app()->end();
        }

}
