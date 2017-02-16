<?php
$this->breadcrumbs=array(
	'Origination Accounts'=>array('index'),
	$model->originator_info_id=>array('view','id'=>$model->originator_info_id),
	'Update',
);

?>

<h1>Update <?php echo $model->originator_info_name; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
