<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

/**
 * CPhoneticDataBehavior class file.
 *
 * @author Steven Brendtro <steven.brendtro@gmail.com>
 * @link http://www.openach.com/
 * @copyright Copyright &copy; 2011 Imagine Solutions, Ltd
 * @license http://www.openach.com/license/
 */

 /**
 * CPhoneticDataBehavior will automatically encode specified attributes using phonetic algorithms
 * when the active record is created and/or updated.
 *
 * You may specify an active record model to use this behavior like so:
 * <pre>
 * public function behaviors(){
 * 	return array(
 * 		'CPhoneticDataBehavior' => array(
 * 			'class' => 'behaviors.CPhoneticDataBehavior',
 * 			'attributeList' => array (
 *				// Using PHP's built-in soundex() function
 *				'employer_name' 		=> array( 
 * 									'method'=>'soundex',		
 * 									'target'=>'employer_name_fuzzy'
 * 									),
 *				// Using the New York State Identification and Intelligence System (NYSIIS) method
 *				'customer_last_name' 		=> array( 
 * 									'method'=>'nysiis',
 * 									'target'=>'customer_last_name_fuzzy'
 * 									),
 *				// Using PHP's built-in metaphone() function
 *				'customer_first_name' 		=> array(
 * 									'method'=>'metaphone',
 * 									'target'=>'customer_first_name_fuzzy' 
 * 									),
 *				// Using the Double Metaphone method (generates two keys)
 *				'company_name' 			=> array( 
 * 									'method'=>'metaphone2',	
 * 									'target'=>array(
 * 										'company_name_fuzzy_1',
 * 										'company_name_fuzzy_2'
 * 										)
 * 									),
 *				// Using PHP's built-in levenshtein() function
 * 				'surname_1'			=> array(
 * 									'method'=>'levenshtein',
 * 									'compare'=>'surname_2',
 * 									'target'=>'surname_edit_distance'
 * 									),
 *				),
 			'targetModel' => 'PhoneticData',
 *		)
 * 	);
 * }
 * </pre>
 * The {@link attributeList} option defaults to an empty array, so the behavior will do nothing
 * unless you specify the attributes that should be encoded.  The array is expected to be
 * key => value pairs, with the key being the attribute name, and the value being another key=>value 
 * list of options.  Currently required options are 'method' (one of 'soundex','nysiis','metaphone',
 * and 'metaphone2') to define what type of phonetic encoding to use, and 'target' to define the 
 * name of the attribute in which to store the encoded value.  Note that all methods take a single
 * attribute, while metaphone2 produces two keys and therefore requires two attributes.
 *
 * In addition to the phonetic encoding algorithms, an 'edit-distance' calculator has been included
 * as a possible method - 'levenshtein'.  While less frequently used in this context, it is often 
 * utilized in conjunction with other phonetic algorithms, so it may be useful in this behavior.
 * Since it requires two inputs, the primary input is given as the attribute, and the second input
 * is povided in the 'compare' option as seen above.
 *
 * An important feature to note is that encoding is sequential, and in the same order as the array
 * provided to define the attributes.  Because of this you could, for instance, calculate the
 * Levenshtein distance between an attribute that was just encoded and another attribute. 
 *
 * All encoding methods utilize the OpenData library's ODPhonetic::encode() method.
 *
 * The {@link targetModel} option defaults to '', so by default the encoding is left in local
 * fields. If this option is set to a valid model class name, the attributes will be stored in
 * the database using that model on the afterSave event.  Using this type of setup is more complex
 * as the model must adhere to a predefined interface specification (see the onAfterSave method 
 * below for more details).
 */

Yii::import( 'application.vendors.OpenData.Phonetic.*' );
class CPhoneticDataBehavior extends CActiveRecordBehavior {

	/**
	* @var array A list of the attributes to be encoded.
	*/
	public $attributeList = array();

	/**
	* @var string The data model that should be used to store the phonetic data to the database
	*/
	public $targetModel = '';

	/**
	* Responds to {@link CModel::onBeforeSave} event.
	* Sets the values of the creation or modified attributes as configured
	* @param CModelEvent $event event parameter
	*/
	public function beforeSave($event) 
	{
		// If there is a target model specified, return (we'll let afterSave do the work)
		if ( $this->targetModel )
		{
			return true;
		}
	
		foreach ( $this->attributeList as $options )
		{
			if ( ! isset( $options['attribute'] ) )
			{
				continue;
			}
			$attribute = $options['attribute'];
			$origValue = $this->getOwner()->{$attribute};
			
			if ( ! isset( $options['target'] ) || ! isset( $options['method'] ) )
			{
				continue;
			}
			switch ( $options['method'] )
			{
				case 'soundex':
				case 'nysiis':
				case 'metaphone':
					$target = $options['target'];
					$this->getOwner()->{$target} = ODPhonetic::encode( $origValue, $options['method'] );
					break;
				case 'metaphone2':
					$targets = $options['target'];
					if ( ! is_array( $targets ) )
					{
						break;
					}
					$values = ODPhonetic::encode( $origValue, $options['method'] );
					$this->getOwner()->{$targets[0]} = $values[0];
					$this->getOwner()->{$targets[1]} = $values[1];
					break;
				case 'levenshtein':
					if ( ! isset( $options['compare'] ) )
					{
						break;
					}
					$this->getOwner()->{$target} = ODPhonetic::distance( $origValue, $options['compare'], $options['method'] );
					break;
				default:
					break;
			}
		}

		return true;
	}

	/**
	* Responds to {@link CModel::onAfterSave} event.
	* Stores the attribute values in the database as configured by the targetModel option
	* @param CModelEvent $event event parameter
	*/
	public function afterSave($event) 
	{
		// If there is no target model specified, return (beforeSave has done the work already)
		if ( ! $this->targetModel )
		{
			return true;
		}
		
		$className = $this->targetModel;

		if ( ! $this->getOwner()->getPrimaryKey() )
		{
			return true;
		}

		$targetDataModel = new $className();
		$targetDataModel->deleteForEntity( get_class( $this->getOwner() ), $this->getOwner()->getPrimaryKey() );

		foreach ( $this->attributeList as $options )
		{

			if ( ! isset( $options['attribute'] ) )
			{
				continue;
			}
			$attribute = $options['attribute'];

			if ( ! $this->getOwner()->{$attribute} )
			{
				continue;
			}
			if ( $options['method'] == 'levenshtein' )
			{
				continue;
			}
			
			$origValue = $this->getOwner()->{$attribute};

			// If metaphone2, save two models only if key values are different
			if ( $options['method'] == 'metaphone2' )
			{
				$keyValues = ODPhonetic::encode( $origValue, $options['method'] );
				if ( count( $keyValues ) == 0 || $keyValues[0] == '' )
				{
					continue;
				}

				$targetDataModel = new $className();
				$targetDataModel->setIsNewRecord(true);
				$targetDataModel->setEntityModel( $this->getOwner() );
				$targetDataModel->setEntityField( $attribute );
				$targetDataModel->setMethod( $options['method'] );
				$targetDataModel->setKey( $keyValues[0] );
				$targetDataModel->setDataType( $options['dataType'] );
				if ( ! $targetDataModel->save() )
				{
					throw new Exception( 'Unable to save phonetic data.');
				}

				if ( $keyValues[0] != $keyValues[1] )
				{
					$targetDataModel = new $className();
					$targetDataModel->setIsNewRecord(true);
					$targetDataModel->setEntityModel( $this->getOwner() );
					$targetDataModel->setEntityField( $attribute );
					$targetDataModel->setMethod( $options['method'] );
					$targetDataModel->setKey( $keyValues[1] );
					$targetDataModel->setDataType( $options['dataType'] );
					if ( ! $targetDataModel->save() )
					{
						throw new Exception( 'Unable to save phonetic data.' );
					}
				}

			}
			// Else, simply save one model
			else
			{
				$keyValue = ODPhonetic::encode( $origValue, $options['method'] );
				if ( ! $keyValue )
				{
					continue;
				}

				$targetDataModel = new $className();
				$targetDataModel->setIsNewRecord(true);
				$targetDataModel->setEntityModel( $this->getOwner() );
				$targetDataModel->setEntityField( $attribute );
				$targetDataModel->setMethod( $options['method'] );
				$targetDataModel->setKey( $keyValue );
				$targetDataModel->setDataType( $options['dataType'] );
				if ( ! $targetDataModel->save() )
				{
					throw new Exception( 'Unable to save phonetic data.' );
				}
			}
		}

		return true;
		
	}
}
