<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

/**
 * OAWebUser is a representation of a CWebUser, necessary for Yii user logins
 */
class OAWebUser extends CWebUser
{
	// Class Members
	protected $_model;

	public function getModel($id=null)
	{
		if ( $this->_model === null )
		{
			if ( $id !== null )
			{
				$this->_model = User::model()->findByPk( $id );
			}
		}
		return $this->_model;
	}

	public function model()
	{
		if ( $this->_model )
		{
			return $this->_model;
		}
		else
		{
			$this->_model = User::model()->findByPk( $this->getId() );
			return $this->_model;
		}
	}

}
