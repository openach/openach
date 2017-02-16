<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

class ApiError extends OAApiAction
{

        public function run()
        {
                if ( $error = Yii::app()->errorHandler->error )
                {
                        echo json_encode( $this->formatError( $error['message'] ) );
                }
                else
                {
                        echo json_encode( $this->formatError( 'An unspecified error occurred.' ) );
                }
                Yii::app()->end();
        }

}
