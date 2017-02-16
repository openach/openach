<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'OpenACH',
	'theme'=>'mobile',

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

	'modules'=>array(
	),

	// application components
	'components'=>array(
		// Load securityManager settings from security.php
		'securityManager' => require( __DIR__.'/security.php' ),
		'user'=>array(
			// enable cookie-based authentication
			'class' => 'OAWebUser',
			'allowAutoLogin'=>true,
		),
		// uncomment the following to enable URLs in path-format
		'urlManager'=>array(
			'urlFormat'=>'path',
			//'rules'=>array(
			//	'<controller:\w+>/<id:\d+>'=>'<controller>/view',
			//	'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
			//	'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			//),
			'showScriptName'=>false,
		),
		// Load the DB config from db.php
		'db'=>require( __DIR__.'/db.php' ),
		'authManager'=>array(
			'class' => 'OADbAuthManager',
			'connectionID'=>'db',
		),
		'clientScript'=>array(
			'class'=>'CAdvancedClientScript',
		),
		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),
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

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>CMap::mergeArray(
		require( __DIR__ . '/params.php' ),
		CMap::mergeArray(
			require( __DIR__ . '/constants/ach.php' ),
			require( __DIR__ . '/constants/enum.php' )
		)
	),

	// Controller Map (used to enable/disable extensions)
	'controllerMap'=>CMap::mergeArray(
		require( __DIR__ . '/extensions.php' ),
		require( __DIR__ . '/controllers.php' )
	),
);
