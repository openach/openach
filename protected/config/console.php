<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

// This is the configuration for yiic console application.
// Any writable CConsoleApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'OpenACH',
	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'application.vendors.druuid.UUID',
		'application.vendors.OpenData.Reader.*',
		'application.vendors.OpenACH.nacha.*',
	),
	// application components
	'components'=>array(
		// Load Database settings from db.php
		'db'=>require(__DIR__.'/db.php'),
		// Load securityManager settings from security.php
		'securityManager' => require( __DIR__.'/security.php' ),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
			),
		),
	),

	'params'=>CMap::mergeArray(
		require( __DIR__ . '/params.php' ),
		CMap::mergeArray(
			require( __DIR__ . '/constants/ach.php' ),
			require( __DIR__ . '/constants/enum.php' )
		)
	),

);
