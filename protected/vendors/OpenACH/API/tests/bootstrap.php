<?php

set_include_path( PATH_SEPARATOR . get_include_path() . PATH_SEPARATOR . dirname( __FILE__ ) );

include_once( 'OAApiTestCase.php' );
$apiConfig = new OAClientConfigIni('..'); // Assumes config is up one directory from where the SDK lives

// The following will only invoke if run from within a full OpenACH install, but not a stand-alone SDK instance.
// change the following paths if necessary
$yiit=dirname(__FILE__).'/../../../../../yii/framework/yiit.php';
$config=dirname(__FILE__).'/../../../../config/main.php';

if ( file_exists( $yiit ) && file_exists( $config ) && stripos( $apiConfig->endpointUrl, 'test.openach.com' ) !== FALSE )
{
	echo PHP_EOL.PHP_EOL;
	echo '!!!!!!!!!!!                WARNING               !!!!!!!!!!!!!' . PHP_EOL;
	echo 'This test is being run from within a full OpenACH Installation.' . PHP_EOL;
	echo 'Test records will be both created and deleted!' . PHP_EOL.PHP_EOL;

	require_once($yiit);

	Yii::createWebApplication($config);
}

