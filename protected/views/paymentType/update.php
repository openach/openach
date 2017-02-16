<?php
$this->breadcrumbs=array(
	'Payment Types'=>array('index'),
	$model->payment_type_id=>array('view','id'=>$model->payment_type_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Payment Type', 'url'=>array('index')),
	array('label'=>'Create Payment Type', 'url'=>array('create')),
	array('label'=>'View Payment Type', 'url'=>array('view', 'id'=>$model->payment_type_id)),
	array('label'=>'Manage Payment Type', 'url'=>array('admin')),
);
?>

<h1>Update <?= $model->payment_type_name; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model,'create'=>false)); ?>
