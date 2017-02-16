<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/


// Automates testing of model()->save() through the use of the OADbFixtureManager, as well as validation
// of records by providing a testFetch() method to do a field-by-field comparison of saved data.
abstract class OADbTestCase extends CDbTestCase
{
	protected $debugLogging = true;


	public function testFetch()
	{
		if ( ! $this->fixtures )
			return;
			
		foreach ( $this->fixtures as $fixtureVarName => $fixtureModel )
		{
			if ( $this->debugLogging )
			{
				print "Running automated fetch for $fixtureVarName and $fixtureModel" . PHP_EOL;
			}
			foreach ( $this->{$fixtureVarName} as $fixture )
			{
				$fieldNames = array_keys( $fixture );
				$primaryKeyField = $fieldNames[0];
				$primaryKey = $fixture[ $primaryKeyField ];

				if ( $this->debugLogging )
				{
					print "Attempting to fetch $fixtureVarName with primary key of $primaryKey." . PHP_EOL;
				}

				$searchCondition = $primaryKeyField . '=:' . $primaryKeyField;
				$searchParams = array( ':' . $primaryKeyField => $primaryKey );
				$dbModel = $fixtureModel::model()->find( $searchCondition, $searchParams );

				foreach ( $fixture as $fieldName => $fieldValue )
				{
					print "Checking if field $fieldName equals $fieldValue". PHP_EOL;
					if ( is_bool( $dbModel->{$fieldName} ) )
					{
						$fieldValue = ( $fieldValue ? true : false );
					}
					$this->assertEquals( $fieldValue, $dbModel->{$fieldName} );
				}
			}
		}		
	}
	
	public function getFixtureManager()
	{
		// The standard Yii fixture manager doesn't use Behaviors for the inserts
		// Use our specialized fixture manager that uses the models themselves for inserting the fixtures
		return Yii::app()->getComponent('oafixture');
	}
	
}
