<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

/**
 * CActiveLogBehavior class file.
 *
 * @author Steven Brendtro <steven.brendtro@gmail.com>
 * @link http://www.openach.com/
 * @copyright Copyright &copy; 2011 Imagine Solutions, Ltd
 * @license http://www.openach.com/license/
 */
class CActiveLogBehavior extends CActiveRecordBehavior {

	/**
	* @var array A list of the attributes to be logged.
	*/
	public $attributeList = array();

	public $targetModel = 'OAActiveLog';

	/**
	* Responds to {@link CModel::onAfterSave} event.
	* Stores the attribute values in the database as configured by the targetModel option
	* @param CModelEvent $event event parameter
	*/
	public function afterSave($event) 
	{
		// If there is no target model specified, we have no way of continuing
		if ( ! $this->targetModel )
		{
			return true;
		}
		
		$className = $this->targetModel;

		// If there is no primary key, we don't have a way for our logs to be linked back to the original record
		if ( ! $this->getOwner()->getPrimaryKey() )
		{
			return true;
		}

		// Create our log model
		$targetDataModel = new $className();
		$targetDataModel->setTableFromModel( $this->getOwner() );

		// If our owner uses CEncryptionBehavior, we need to have it
		// encrypt fields before we continue
		if ( isset( $this->getOwner()->CEncryptionBehavior ) )
		{
			$this->getOwner()->CEncryptionBehavior->beforeSave($event);
		}
		if ( isset( $this->getOwner()->CCompressedEncryptionBehavior ) )
		{
			$this->getOwner()->CCompressedEncryptionBehavior->beforeSave($event);
		}

		foreach ( $this->attributeList as $attribute )
		{
			$targetDataModel->setAttribute( $attribute, $this->getOwner()->{$attribute} );
		}

		// If our owner uses CEncryptionBehavior, we need to have it
		// decrypt fields so the model is in its original state before we continue
		if ( isset( $this->getOwner()->CEncryptionBehavior ) )
		{
			$this->getOwner()->CEncryptionBehavior->afterSave($event);
		}
		if ( isset( $this->getOwner()->CCompressedEncryptionBehavior ) )
		{
			$this->getOwner()->CCompressedEncryptionBehavior->afterSave($event);
		}



		if ( ! $targetDataModel->save() )
		{
			throw new Exception( 'Unable to create log record.' );
		}

		return true;
		
	}
}
