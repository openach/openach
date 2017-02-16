<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

/**
 * CTokenizerBehavior class file.
 *
 * @author Steven Brendtro <steven.brendtro@gmail.com>
 * @link http://www.openach.com/
 * @copyright Copyright &copy; 2011 Imagine Solutions, Ltd
 * @license http://www.openach.com/license/
 */

class CTokenizerBehavior extends CActiveRecordBehavior {

	/**
	* @var array A list of the attributes needing uuids
	*/
	public $attributeList = array();

	/**
	* Responds to {@link CModel::onBeforeSave} event.
	* Sets the values of the creation or modified attributes as configured
	* @param CModelEvent $event event parameter
	*/
	public function beforeValidate($event) {
		
		foreach ( $this->attributeList as $options  )
		{
			$attribute = $options['attribute'];
			if ( ! $this->getOwner()->{$attribute} )
			{
				continue;
			}

			if ( isset( $options['isEqual'] ) )
			{
				$params = $options['isEqual'];
				if ( ! $this->isEqual( $params[0], $params[1] ) )
				{
					continue;
				}
			}
			$targets = $options['targets'];
			$delimiter = $options['delimiter'];
			$targetCount = count( $targets );

			$valueParts = explode( $delimiter, $this->getOwner()->{$attribute}, $targetCount );
			$valueCount = count( $valueParts );
			
			for ( $index = 0; $index < $targetCount && $index < $valueCount; $index++ )
			{
				if ( $this->getOwner()->{$targets[$index]} )
				{
					continue;
				}
				else
				{
					$this->getOwner()->{$targets[$index]} = $valueParts[$index];
				}
			}
		}
	}

	protected function isEqual( $attribute, $match )
	{
		return ( $this->getOwner()->{$attribute} == $match );
	}

}
