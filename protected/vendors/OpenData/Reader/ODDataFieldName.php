<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

class ODDataFieldName extends ODFieldInfo
{
	public function __construct( $fieldName )
	{
		parent::__construct( array( 'fieldName' => $fieldName ) );
	}
	protected function assertOptions()
	{
		assert( isset( $this->options->fieldName ) );
	}
	public function getFieldName()
	{
		return $this->getOption('fieldName');
	}
}


