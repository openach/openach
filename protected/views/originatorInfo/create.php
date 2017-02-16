<?php
$this->breadcrumbs=array(
	'Originator Infos'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List OriginatorInfo', 'url'=>array('index')),
	array('label'=>'Manage OriginatorInfo', 'url'=>array('admin')),
);

// set the parent for the record
$model->originator_info_originator_id = $parent_id;

?>

<h1>Create Origination Account</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model,'parent_id'=>$parent_id)); ?>
