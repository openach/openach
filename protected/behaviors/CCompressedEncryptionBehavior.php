<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

/**
 * CCompressedEncryptionBehavior class file.
 *
 * @author Steven Brendtro <steven.brendtro@gmail.com>
 * @link http://www.openach.com/
 * @copyright Copyright &copy; 2011 Imagine Solutions, Ltd
 * @license http://www.openach.com/license/
 */

class CCompressedEncryptionBehavior extends CEncryptionBehavior {

	/**
	* Responds to {@link CModel::onBeforeSave} event.
	* Sets the values of the creation or modified attributes as configured
	* @param CModelEvent $event event parameter
	*/
	public function beforeSave($event)
	{
		$this->compress();
		$this->encrypt();
	}
	// Immediately following a save, decrypt the fields again so we can continue to use the model
	public function afterSave($event)
	{
		$this->decrypt();
		$this->decompress();
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
		$this->decompress();
	}

	public function compress() {

		foreach ( $this->attributeList as $attribute => $method )
		{
			if ( $this->getOwner()->{$attribute} == '' )
			{
				continue;
			}

			$origValue = $this->getOwner()->{$attribute};
			if ( ! $newValue = gzdeflate( $origValue ) )
			{
				throw new Exception( 'An error occurred while compressing the value ' . $origValue );
			}

			$this->getOwner()->{$attribute} = $newValue;
		}
	}

	public function decompress() {

		foreach ( $this->attributeList as $attribute => $method )
		{
			if ( $this->getOwner()->{$attribute} == '' )
			{
				continue;
			}

			if ( !$newValue = gzinflate( $this->getOwner()->{$attribute} ) )
			{
				throw new Exception( 'An error occurred while decompressing the value.' );
			}

			$this->getOwner()->{$attribute} = $newValue;
			
		}
	}

}
