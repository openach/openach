<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

/* Note that this class may extend Yii's CActiveRecord, or the OpenData implementation
 * The version exended depends on which one is included, either manually, or by 
 * the classloader.
 */
class ODDataSource extends CActiveRecord
{
	public function fetch()
	{
		return true;
	}
	
	public function merge( CActiveRecord $record )
	{
		foreach ( array_keys( $record->attributes ) as $attributeName )
		{
			$attributeValue = $record->{$attributeName};

			if ( $attributeValue === NULL || ! $attributeValue )
			{
				continue;
			}

			$this->{$attributeName} = $attributeValue;
		}
	}

	public function remapFields( $fieldMap )
	{
		if ( ! $fieldMap || ! is_array( $fieldMap ) )
		{
			return;
		}

		foreach ( $fieldMap as $source => $target )
		{
			$this->{$source} = $this->{$target};
		}
	}

}



