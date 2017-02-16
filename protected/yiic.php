<?php

set_include_path( get_include_path() . ':' . dirname(__FILE__) );
// change the following paths if necessary
$yiic=dirname(__FILE__).'/../yii/framework/yiic.php';
$config=dirname(__FILE__).'/config/console.php';

require_once($yiic);
