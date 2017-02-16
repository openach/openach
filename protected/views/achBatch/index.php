<?php
$this->breadcrumbs=array(
	'Ach Batches',
);

$this->menu=array(
	array('label'=>'Create AchBatch', 'url'=>array('create')),
	array('label'=>'Manage AchBatch', 'url'=>array('admin')),
);
?>

<h1>Ach Batches</h1>

<?

$this->renderPartial( '/originator/_summarySubPanel', array( 'model'=>$originator ) );
$this->renderPartial( '/originatorInfo/_summarySubPanel', array( 'model'=>$originatorInfo ) );
$this->renderPartial( '/achBatch/list', array( 'items'=>$originatorInfo->ach_batches, 'parent_id'=>$originatorInfo->originator_info_id ) );

