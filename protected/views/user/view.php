<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

$this->breadcrumbs=array(
	'Users'=>array('index'),
	$model->user_id,
);

$this->stockMenus( array() ); 

$this->renderPartial( '_summarySubPanel', array( 'model'=>$model ) );
$this->renderPartial( '/userApi/list', array( 'items'=>$model->user_api ) );
$this->renderPartial( '/role/list', array( 'items'=>$model->roles ) );
$this->renderPartial( '/originator/list', array( 'items'=>$model->originators, 'user'=>$model ) );

