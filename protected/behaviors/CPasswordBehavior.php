<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

/**
 * CPasswordBehavior class file.
 *
 * @author Steven Brendtro <steven.brendtro@gmail.com>
 * @link http://www.openach.com/
 * @copyright Copyright &copy; 2011 Imagine Solutions, Ltd
 * @license http://www.openach.com/license/
 */

class CPasswordBehavior extends CActiveRecordBehavior {

	/**
	* @var string The needing password behavior
	*/
	public $passwordAttribute;
	public $confirmAttribute;
	public $currentAttribute;

	public function afterFind( $event )
	{
		$this->getOwner()->setAttribute( $this->currentAttribute, $this->getOwner()->getAttribute( $this->passwordAttribute ) );
		$this->getOwner()->setAttribute( $this->passwordAttribute, null );
	}

	public function beforeSave( $event )
	{
		if ( empty($this->getOwner()->{$this->passwordAttribute}) && empty($this->getOwner()->{$this->confirmAttribute}) && !empty($this->getOwner()->{$this->currentAttribute}))
		{
			$this->getOwner()->setAttribute( $this->passwordAttribute, $this->getOwner()->getAttribute( $this->currentAttribute ) );
		}
		else
		{
			$hashedPassword = $this->hashPassword( $this->getOwner()->getAttribute( $this->passwordAttribute ) );
			$this->getOwner()->setAttribute( $this->passwordAttribute, $hashedPassword );
		}
	}

	protected function hashPassword( $password )
	{
		$securityManager = Yii::app()->securityManager;
		return hash_hmac(
				$securityManager->hashAlgorithm,
				$password,
				$securityManager->getValidationKey()
			);
	}

}
