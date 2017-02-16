<?php
$this->breadcrumbs=array(
	'Payment Schedules'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Payment Schedule', 'url'=>array('index')),
	array('label'=>'Manage Payment Schedule', 'url'=>array('admin')),
);

?>

<h1>Create Payment Schedule</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model, 'paymentProfile'=>$paymentProfile ) );?>
