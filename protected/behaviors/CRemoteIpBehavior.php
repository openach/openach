<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

/**
 * CRemoteIpBehavior class file.
 *
 * @author Steven Brendtro <steven.brendtro@gmail.com>
 * @link http://www.openach.com/
 * @copyright Copyright &copy; 2011 Imagine Solutions, Ltd
 * @license http://www.openach.com/license/
 */

class CRemoteIpBehavior extends CActiveRecordBehavior {

	/**
	* @var array A list of the attributes needing uuids
	*/
	public $attributeList = array();

	/**
	* Responds to {@link CModel::onBeforeSave} event.
	* Sets the values of the creation or modified attributes as configured
	* @param CModelEvent $event event parameter
	*/
	public function beforeValidate($event) {

		if ( Yii::app() instanceof CConsoleApplication )
		{
			$remoteIp = '127.0.0.1';
		}
		else
		{
			$remoteIp = Yii::app()->request->userHostAddress;
		}
		
		foreach ( $this->attributeList as $target )
		{
			if ( $this->getOwner()->getAttribute( $target ) )
			{
				continue;
			}
			else
			{
				$this->getOwner()->setAttribute( $target, $remoteIp );
			}
		}
	}

}
