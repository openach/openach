<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

/**
 * CValidateOwnershipBehavior class file.
 *
 * @author Steven Brendtro <steven.brendtro@gmail.com>
 * @link http://www.openach.com/
 * @copyright Copyright &copy; 2011 Imagine Solutions, Ltd
 * @license http://www.openach.com/license/
 */

class CValidateOwnershipBehavior extends CActiveRecordBehavior {

	/**
	* @var array A list of the models and attributes needing validation
	*/
	public $modelList = array();

	/**
	* Responds to {@link CModel::onBeforeValidate} event.
	* @param CModelEvent $event event parameter
	*/
	public function beforeValidate($event)
	{
		if ( Yii::app() instanceof CConsoleApplication || ! Yii::app()->user )
		{
			return;
		}
		else
		{
			$user = Yii::app()->user->model();

			foreach ( $this->modelList as $class => $target )
			{
				if ( ! $this->getOwner()->getAttribute( $target ) ) 
				{
					continue;
				}
				// Try loading the model using the given primary key, and see if the user is authorized
				if ( ! $model = $class::model()->findByPk( $this->getOwner()->getAttribute( $target ) ) || ! $user->isAuthorized( $model ) )
				{
					// Empty the attribute to cause a validation error in the next step
					$this->getOwner()->setAttribute( $target, '' );
				}
			}
		}
	}

}
