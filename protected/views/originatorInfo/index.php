<?php
$this->breadcrumbs=array(
	'Originator Infos',
);

$this->menu=array(
	array('label'=>'Create OriginatorInfo', 'url'=>array('create')),
	array('label'=>'Manage OriginatorInfo', 'url'=>array('admin')),
);
?>

<h1>Originator Infos</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
