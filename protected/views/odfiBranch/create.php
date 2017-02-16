<?php
$this->breadcrumbs=array(
	'Banks'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List OdfiBranch', 'url'=>array('index')),
	array('label'=>'Manage OdfiBranch', 'url'=>array('admin')),
);
$model->odfi_branch_originator_id = $parent_id;
?>

<h1>Create Bank</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model,'parent_id'=>$parent_id)); ?>
