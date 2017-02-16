<?php
$this->breadcrumbs=array(
	'Payment Types'=>array('index'),
	'Create',
);

$this->stockMenus( array( 'list', 'search' ) );

// set the parent for the record
$model->payment_type_originator_info_id = $parent_id;
?>

<h1>New Payment Type</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model, 'create'=>true)); ?>
