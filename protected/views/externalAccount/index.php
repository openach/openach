<?php
$this->breadcrumbs=array(
	'Bank Accounts',
);

$this->menu=array(
	array('label'=>'Create Bank Account', 'url'=>array('create')),
	array('label'=>'Manage Bank Account', 'url'=>array('admin')),
);
?>

<h1>Bank Accounts</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
