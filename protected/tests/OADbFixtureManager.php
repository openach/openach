<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

Yii::import( 'system.test.CDbFixtureManager', true );

// The parent class, CDbFixtureManager doesn't insert new records using the model, so behaviors can't be tested.
// This class overrides some of the parent class methods to allow behaviors to be tested as fixtures are added.

class OADbFixtureManager extends CDbFixtureManager
{
	// This replaces the loadFixture method with one that attempts to use model()->save(), thereby 
	// utilizing behaviors.  It will fall back to the parent class method if no model exists. 
	public function loadFixture($tableName)
	{

		$tableParts = explode( '_', $tableName );
		$className = '';
		foreach( $tableParts as $tablePart )
		{
			$className .= ucfirst( $tablePart );
		}

		$fixtureModel = $className::model();

		if ( ! $fixtureModel || ! $fixtureModel instanceof CActiveRecord )
		{
			return parent::loadFixture( $tableName );
		}

		$fileName=$this->basePath.DIRECTORY_SEPARATOR.$tableName.'.php';

		if( ! is_file( $fileName ) )
			return parent::loadFixture( $tableName );

		$rows = array();
		
		$primaryKey = $fixtureModel->getMetaData()->tableSchema->primaryKey;

		if ( is_array( $primaryKey ) && count( $primaryKey ) == 1 )
		{
			$primaryKey = $primaryKey[0];
		}
		
		foreach(require($fileName) as $alias=>$row)
		{
			$fixtureModel = new $className;
			
			foreach ( $row as $fieldName => $fieldValue )
			{
				$fixtureModel->{$fieldName} = $fieldValue;
			}

			if ( ! $fixtureModel->save() )
			{
				var_dump( $fixtureModel->getErrors() );
				throw new CDbException( "Unable to save the " . $className . " with key " . $fixtureModel->{$primaryKey} );
			}

			if ( ! is_array( $primaryKey ) )
			{
				$row[ $primaryKey ] = $fixtureModel->{$primaryKey};
			}

			$rows[$alias] = $row;
		}
		return $rows;
	}



}
