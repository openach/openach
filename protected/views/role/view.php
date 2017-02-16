<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

$this->breadcrumbs=array(
	'Roles'=>array('index'),
	$model->role_id,
);

$this->stockMenus( array() );

$this->renderPartial( '_summarySubPanel', array( 'model'=>$model ) );
$this->renderPartial( '/user/list', array( 'items'=>$model->users, 'parent_id'=>$model->role_id ) );

