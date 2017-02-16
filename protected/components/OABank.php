<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

Yii::import( 'application.vendors.OpenACH.nacha.Banks.*' );
//Yii::import( 'application.vendors.OpenACH.nacha.OABankConfig' );

class OABank
{
	public static function factory( OdfiBranch $odfiBranch )
	{
		if ( ! $odfiBranch )
		{
			throw new Exception( 'OABank::factory() requires a valid odfi branch.');
		}
		if ( ! isset( $odfiBranch->odfi_branch_plugin ) )
		{
			throw new Exception( 'The odfi branch provided did not specify a plugin.');
		}

		$pluginClass = $odfiBranch->odfi_branch_plugin . 'Config';
		return new $pluginClass( $odfiBranch );
	}
}

