<?php
$this->breadcrumbs=array(
	'Payment Schedules'=>array('index'),
	$model->payment_schedule_id=>array('view','id'=>$model->payment_schedule_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Payment Schedule', 'url'=>array('index')),
	array('label'=>'Create Payment Schedule', 'url'=>array('create')),
	array('label'=>'View Payment Schedule', 'url'=>array('view', 'id'=>$model->payment_schedule_id)),
	array('label'=>'Manage Payment Schedule', 'url'=>array('admin')),
);
?>

<h1>Update Payment Schedule</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
