<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

/**
 * CHashDataBehavior class file.
 *
 * @author Steven Brendtro <steven.brendtro@gmail.com>
 * @link http://www.openach.com/
 * @copyright Copyright &copy; 2011 Imagine Solutions, Ltd
 * @license http://www.openach.com/license/
 */

 /**
 * CHashDataBehavior will automatically encode specified attributes using hash algorithms
 * when the active record is created and/or updated.
 *
 * You may specify an active record model to use this behavior like so:
 * <pre>
 * public function behaviors(){
 * 	return array(
 * 		'CHashDataBehavior' => array(
 * 			'class' => 'behaviors.CPhoneticDataBehavior',
 * 			'attributeList' => array (
 *				// Using sha1 hash
 *				'customer_last_name' 		=> array( 
 * 									'method'=>'sha1',
 * 									'target'=>'customer_last_name_hash'
 * 									),
 *				// Using md5 hash
 *				'customer_first_name' 		=> array(
 * 									'method'=>'md5',
 * 									'target'=>'customer_first_name_hash' 
 * 									),
 *				// Using sha256 hash
 *				'company_name' 			=> array( 
 * 									'method'=>'sha256',	
 * 									'target'=>'company_name_hash'
 * 									),
 *				),
 *		)
 * 	);
 * }
 * </pre>
 * The {@link attributeList} option defaults to an empty array, so the behavior will do nothing
 * unless you specify the attributes that should be hashed.  The array is expected to be
 * key => value pairs, with the key being the attribute name, and the value being another key=>value 
 * list of options.  Currently required options are 'method' (any hash algorithm accepted by PHP's
 * built-in hash() function ) to define what type of hashing to use, and 'target' to define the 
 * name of the attribute in which to store the hashed value.  
 *
 * An important feature to note is that encoding is sequential, and in the same order as the array
 * provided to define the attributes.  Because of this you could, for instance, calculate a hash
 * of two previously calculated hashes.  From the above example, 'company_name_hash_1' could be used
 * by any following hash definitions.
 *
 * All hashing methods utilize PHP's built-in hash() function. 
 *
 * IMPORTANT NOTES: 
 *	- All hashes are recalculated every time the beforeSave event occurs.
 * 	- Empty strings are not hashed.
 *	- All values are transformed to lowercase before hashing! This can be disabled by passing 
 *	  'transform' => false in the parameters for an attribute.
 *
 */

class CHashDataBehavior extends CActiveRecordBehavior {

	/**
	* @var array A list of the attributes to be encoded.
	*/
	public $attributeList = array();

	/**
	* Responds to {@link CModel::onBeforeSave} event.
	* Sets the values of the creation or modified attributes as configured
	* @param CModelEvent $event event parameter
	*/
	public function beforeSave($event) 
	{
		foreach ( $this->attributeList as $attribute => $options )
		{
			$origValue = $this->getOwner()->{$attribute};
			
			if ( ! isset( $options['target'] ) || ! isset( $options['method'] ) )
			{
				continue;
			}

			// Transform defaults to true
			$transform = true;

			if ( isset( $options['transform'] ) )
			{
				$transform = $options['transform'];
			}

			if ( $transform )
			{
				$origValue = strtolower( $origValue );
			}

			$hashValue = hash( $options['method'], $origValue );
			$this->getOwner()->setAttribute( $options['target'], $hashValue );
		}

		return true;
	}
}
