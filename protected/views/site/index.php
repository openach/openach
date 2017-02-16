<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

$this->stockMenus( array() );

$this->pageTitle=Yii::app()->name;

$randIndex = array_rand( Yii::app()->params['FrontPageQuotes'] );
$randQuote = Yii::app()->params['FrontPageQuotes'][$randIndex];

?>

		<h1>Welcome to <i><?php echo CHtml::encode(Yii::app()->name); ?></i></h1>
		<h2><?= $randQuote; ?></h2>
		<p>For more details, please visit <a href="http://openach.com/">OpenACH.com</a></p>
		<div style="text-align: center;"><img src="/images/ach_symbol_med.png" style="position:relative" /></div>

