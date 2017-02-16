<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

/**
 * CEncryptionBehavior class file.
 *
 * @author Steven Brendtro <steven.brendtro@gmail.com>
 * @link http://www.openach.com/
 * @copyright Copyright &copy; 2011 Imagine Solutions, Ltd
 * @license http://www.openach.com/license/
 */

 /**
 * CEncryptionBehavior will automatically encrypt and decrypt record attributes.
 *
 * CEncryptionBehavior will automatically encrypt specified attributes when the active record
 * is created and/or updated, and decrypt them when the record is loaded via one of the Find methods
 * You may specify an active record model to use this behavior like so:
 * <pre>
 * public function behaviors(){
 * 	return array(
 * 		'CEncryptionBehavior' => array(
 * 			'class' => 'behaviors.CEncryptionBehavior',
 * 			'attributeList' => array (
 *				'social_security_number' => 'crypt',
 *				'password'		 => 'hash'
 *				),
 *		)
 * 	);
 * }
 * </pre>
 * The {@link attributeList} option defaults to an empty array, so the behavior will do nothing
 * unless you specify the attributes that should be encrypted/decrypted.  The array is expected to be
 * key => value pairs, with the key being the attribute name, and the value being the type of security 
 * to use (either 'crypt' for encryption, or 'hash' for a one way hash).
 *
 * The encryption and decryption is performed using the Yii CSecurityManager's encrypt() and decrypt() methods
 * NOTE: You must specify an encryptionKey for the CSecurityManager component in the config, like so:
 *
 *	'components'=>array(
		// other components also defined here...
		// .
		// .
		// .
		'securityManager' => array(
			'cryptAlgorithm'	=> 'rijndael-256',
			'encryptionKey'		=> 'xyz....',
			'hashAlgorithm'		=> 'sha1',
			'validationKey'		=> 'xyz....',
		),
	)
 *
 * If the encryptionKey is not specified in the config, a random key will be used, and you may not
 * be able to decrypt your data.
 *
 */

class CEncryptionBehavior extends CActiveRecordBehavior {

	/**
	* @var array A list of the attributes to be encrypted/decrypted.
	*/
	public $attributeList = array();

	/**
	* Responds to {@link CModel::onBeforeSave} event.
	* Sets the values of the creation or modified attributes as configured
	* @param CModelEvent $event event parameter
	*/
	public function beforeSave($event)
	{
		$this->encrypt();
	}
	// Immediately following a save, decrypt the fields again so we can continue to use the model
	public function afterSave($event)
	{
		$this->decrypt();
	}

	/**
	* Responds to {@link CModel::onAfterFind} event.
	* Sets the values of the loaded attributes as configured
	*
	* @param CModelEvent $event event parameter
	*/
	public function afterFind($event)
	{
		$this->decrypt();
	}

	public function encrypt() {
		$securityManager = Yii::app()->securityManager;

		foreach ( $this->attributeList as $attribute => $method )
		{
			if ( $this->getOwner()->{$attribute} == '' )
			{
				continue;
			}

			$origValue = $this->getOwner()->{$attribute};
			switch ( $method )
			{
				case 'crypt':
					$newValue = base64_encode( $securityManager->encrypt( $origValue ) );
					break;
				case 'hash':
					$newValue = hash_hmac( $securityManager->hashAlgorithm, $origValue );
					break;
				default:
					$newValue = $origValue;
					break;
			}

			$this->getOwner()->{$attribute} = $newValue;
		}
	}

	public function decrypt() {
		$securityManager = Yii::app()->securityManager;

		foreach ( $this->attributeList as $attribute => $method )
		{
			if ( $this->getOwner()->{$attribute} == '' )
			{
				continue;
			}
			if ( $method == 'crypt' )
			{
				try
				{
					$this->getOwner()->{$attribute} = $securityManager->decrypt( base64_decode( $this->getOwner()->{$attribute} ) );
				}
				catch ( Exception $e )
				{
					throw new Exception( get_class( $this->getOwner() ) . ' CEncryptionBehavior unable to decrypt ' . $attribute . ' value "' . $this->getOwner()->{$attribute} . '", possibly because the value has not been properly encrypted.' );
				}
			}
		}
	}

}
