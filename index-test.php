<?php
/**
 * This is the bootstrap file for test application.
 * This file should be removed when the application is deployed for production.
 */

include(dirname(__FILE__).'/vendor/autoload.php');

// change the following paths if necessary
$config=dirname(__FILE__).'/protected/config/test.php';

// remove the following line when in production mode
defined('YII_DEBUG') or define('YII_DEBUG',true);

Yii::createWebApplication($config)->run();
