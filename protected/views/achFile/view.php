<?php
$this->breadcrumbs=array(
	'Ach Files'=>array('index'),
	$model->ach_file_id,
);

$this->stockMenus( array() );

$this->renderPartial( '/originator/_summarySubPanel', array( 'model'=>$model->originator ) );
$this->renderPartial( '_summarySubPanel', array( 'model'=>$model ) );

?>

<div data-role="collapsible-set" data-theme="b" data-content-theme="a">
<?php if ( $model->file_transfer ) : ?>
	<div data-role="collapsible" data-collapsed="false">
		<?php $this->renderPartial( '/fileTransfer/list', array( 'items'=>$model->file_transfer ) ); ?>
	</div>
<?php endif; ?>
	<div data-role="collapsible">
		<?php $this->renderPartial( '/achBatch/list', array( 'items'=>$model->ach_batches ) ); ?>
	</div>
</div>

