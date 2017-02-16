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

        public function run()
        {
                $this->assertAuth();
		$this->paymentProfile->refresh();
                echo json_encode( $this->formatSuccess( $this->paymentProfile->apiExport() ) );
                Yii::app()->end();
        }

}
