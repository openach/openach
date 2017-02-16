<?php
$this->breadcrumbs=array(
	'Payment Profiles'=>array('index'),
	$model->payment_profile_id=>array('view','id'=>$model->payment_profile_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List PaymentProfile', 'url'=>array('index')),
	array('label'=>'Create PaymentProfile', 'url'=>array('create')),
	array('label'=>'View PaymentProfile', 'url'=>array('view', 'id'=>$model->payment_profile_id)),
	array('label'=>'Manage PaymentProfile', 'url'=>array('admin')),
);
?>

<h1>Update <?= $model->displayCustomer(); ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model, 'create'=>false)); ?>
