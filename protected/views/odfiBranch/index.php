<?php
$this->breadcrumbs=array(
	'Odfi Branches',
);

$this->menu=array(
	array('label'=>'Create OdfiBranch', 'url'=>array('create')),
	array('label'=>'Manage OdfiBranch', 'url'=>array('admin')),
);
?>

<h1>Odfi Branches</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
