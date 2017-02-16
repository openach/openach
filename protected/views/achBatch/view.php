<?php
$this->breadcrumbs=array(
	'Ach Batches'=>array('index'),
	$model->ach_batch_id,
);

$this->stockMenus( array(  ) );

$this->renderPartial( '/achFile/_summarySubPanel', array( 'model'=>$model->ach_file ) );
$this->renderPartial( '_summarySubPanel', array( 'model'=>$model ) );
$this->renderPartial( '/achEntry/list', array( 'items'=>$achEntryProvider ) );


