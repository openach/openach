<?php
$this->breadcrumbs=array(
	'Plugin Config'=>array('index'),
	$model->plugin_config_id=>array('view','id'=>$model->plugin_config_id),
	'Update',
);

$this->menu=array();
?>

<h1>Update <?php echo $model->plugin_config_key; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
