<?php
$this->breadcrumbs=array(
	'Odfi Branches'=>array('index'),
	$model->odfi_branch_id=>array('view','id'=>$model->odfi_branch_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List OdfiBranch', 'url'=>array('index')),
	array('label'=>'Create OdfiBranch', 'url'=>array('create')),
	array('label'=>'View OdfiBranch', 'url'=>array('view', 'id'=>$model->odfi_branch_id)),
	array('label'=>'Manage OdfiBranch', 'url'=>array('admin')),
);
?>

<h1>Update <?php echo $model->odfi_branch_friendly_name; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
