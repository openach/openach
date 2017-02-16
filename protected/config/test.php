<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

return CMap::mergeArray(
	require(dirname(__FILE__).'/main.php'),
	array(
		'components'=>array(
			'fixture'=>array(
				'class'=>'system.test.CDbFixtureManager',
			),
			'oafixture'=>array(
				'class'=>'application.tests.OADbFixtureManager',
			),
			// uncomment the following to use a MySQL database
			/*
			'db'=>array(
				'connectionString' => 'mysql:host=localhost;dbname=openach_test',
				'emulatePrepare' => true,
				'username' => 'openach_test',
				'password' => 'password',
				'charset' => 'utf8',
				'enableParamLogging' => true,
			), */
			// uncomment the following to use a Postgresql database
			'db'=>array(
				'connectionString' => 'pgsql:host=localhost;port=5432;dbname=openach_test',
				'emulatePrepare' => true,
				'username' => 'openach_test',
				'password' => 'openach_test',
				'class' => 'system.db.CDbConnection',
				'driverMap' => array( 'pgsql' => 'application.tests.CPgsqlTestSchema' ),
			),

		),
		'params'=>array(
			// Test the loading of external data sources?
			'ODReaderTestCase'=>array(
				// Test the loading of external data sources
				// (Fedwire, FedACH, OFAC, etc.)
				'loadExternalSources' => false,
				//'loadExternalSources' => true,
			),
			'AchReaderTest'=>array(
				// Save records read in from the file
				'saveRecords' => false,
				//'saveRecords' => true,
			),
		),

	)
);
