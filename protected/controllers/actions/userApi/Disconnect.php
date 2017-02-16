<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

class Disconnect extends OAApiAction
{

	public function run()
	{
		Yii::app()->getSession()->destroy();
		$this->userApi = null;
		echo json_encode( array( 'success'=>true ) );
		Yii::app()->end();
	}

}
