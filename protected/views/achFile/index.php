<?php
$this->breadcrumbs=array(
	'Ach Files',
);

$this->stockMenus( array(  ) );

$this->renderPartial( '/originator/_summarySubPanel', array( 'model'=>$originator ) );
$this->renderPartial( '/achFile/list', array( 'items'=>$originator->ach_file, 'parent_id'=>$originatorInfo->originator_id ) );

