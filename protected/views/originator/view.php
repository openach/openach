<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

$this->breadcrumbs=array(
	'Originators'=>array('index'),
	$model->originator_id,
);

//$this->stockMenus( array( 'list','create','edit','delete','search' ), $model->originator_id );
$this->stockMenus( array( ) );
$this->renderPartial( '_summarySubPanel', array( 'model'=>$model ) );
$this->renderPartial( '/odfiBranch/list', array( 'items'=>$model->odfi_branches, 'parent_id'=>$model->originator_id ) ); 

// OdfiBrances are required before creating any OriginatorInfo records
/*
if ( $model->odfi_branches )
{
	$this->renderPartial( '/originatorInfo/list', array( 'items'=>$model->originator_info, 'parent_id'=>$model->originator_id ) );
}
*/

