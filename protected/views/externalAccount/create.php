<?php
$this->breadcrumbs=array(
	'External Accounts'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Bank Account', 'url'=>array('index')),
	array('label'=>'Manage Bank Account', 'url'=>array('admin')),
);

?>

<h1>Create Bank Account</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
