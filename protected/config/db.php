<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

// uncomment the following to use a Postgresql database
/*
return array(
	'connectionString' => 'pgsql:host=localhost;port=5432;dbname=openach',
	'emulatePrepare' => true,
	'username' => 'openach',
	'password' => 'openach',
);
*/

// uncomment the following to use a SQLite database
/*
return array(
	'connectionString' => 'sqlite:/full/path/to/protected/runtime/db/openach.db',
	'emulatePrepare' => true,
	'enableProfiling' => true,
       	'initSQLs' => array( 'PRAGMA foreign_keys=ON;' ),
);
*/
