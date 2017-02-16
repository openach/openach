<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

/**
 * CUuidKeyBehavior class file.
 *
 * @author Steven Brendtro <steven.brendtro@gmail.com>
 * @link http://www.openach.com/
 * @copyright Copyright &copy; 2011 Imagine Solutions, Ltd
 * @license http://www.openach.com/license/
 */

class CUuidKeyBehavior extends CActiveRecordBehavior {

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
		
		foreach ( $this->attributeList as $target )
		{
			if ( $this->getOwner()->{$target} != '' )
			{
				continue;
			}
			else
			{
				$this->getOwner()->{$target} = UUID::mint( 4 );
			}
		}
	}

}
