<?php

set_include_path( get_include_path() . ':' . dirname(__FILE__) );
require_once(dirname(__FILE__).'/../vendor/autoload.php');
// change the following paths if necessary
$yiic=dirname(__FILE__).'/../vendor/yiisoft/yii/framework/yiic.php';
$config=dirname(__FILE__).'/config/console.php';

require_once($yiic);
