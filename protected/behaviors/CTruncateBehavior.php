<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

/**
 * CTruncateBehavior class file.
 *
 * @author Steven Brendtro <steven.brendtro@gmail.com>
 * @link http://www.openach.com/
 * @copyright Copyright &copy; 2011 Imagine Solutions, Ltd
 * @license http://www.openach.com/license/
 */

 /**
 * CTruncateBehavior will automatically truncate fields to the specified length
 * when the active record is created and/or updated.
 *
 * You may specify an active record model to use this behavior like so:
 * <pre>
 * public function behaviors(){
 * 	return array(
 * 		'CTruncateBehavior' => array(
 * 			'class' => 'behaviors.CTruncateBehavior',
 * 			'attributeList' => array (
 *				// Using sha1 hash
 *				'customer_first_name' 		=> 10, // Truncate to 10 chars
 *				'customer_last_name' 		=> 20, // Truncate to 20 chars
 *				),
 *		)
 * 	);
 * }
 * </pre>
 * The {@link attributeList} option defaults to an empty array, so the behavior will do nothing
 * unless you specify the attributes that should be truncated.  The array is expected to be
 * key => value pairs, with the key being the attribute name, and the value being the length to 
 * truncate to.
 *
 */

class CTruncateBehavior extends CActiveRecordBehavior {

	/**
	* @var array A list of the attributes to be encoded.
	*/
	public $attributeList = array();

	/**
	* Responds to {@link CModel::onBeforeValidate} event.
	* Sets the values of the creation or modified attributes as configured
	* @param CModelEvent $event event parameter
	*/
	public function beforeValidate($event) 
	{
		foreach ( $this->attributeList as $attribute => $length )
		{
			$origValue = $this->getOwner()->{$attribute};
			$this->getOwner()->{$attribute} = substr( $origValue, 0, $length );
		}

		return true;
	}
}
