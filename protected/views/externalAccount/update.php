<?php
$this->breadcrumbs=array(
	'Bank Account'=>array('index'),
	$model->external_account_id=>array('view','id'=>$model->external_account_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List OdfiBranch', 'url'=>array('index')),
	array('label'=>'Create OdfiBranch', 'url'=>array('create')),
	array('label'=>'View OdfiBranch', 'url'=>array('view', 'id'=>$model->external_account_id)),
	array('label'=>'Manage OdfiBranch', 'url'=>array('admin')),
);
?>

<h1>Update <?php echo $model->external_account_name; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>

