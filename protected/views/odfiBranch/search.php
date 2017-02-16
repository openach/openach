<?php
$this->breadcrumbs=array(
	'Odfi Branches'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List OdfiBranch', 'url'=>array('index')),
	array('label'=>'Create OdfiBranch', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('odfi-branch-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Odfi Branches</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'odfi-branch-grid',
	'dataProvider'=>$dataProvider,
	'filter'=>$model,
	'columns'=>array(
		'odfi_branch_id',
		'odfi_branch_datetime',
		'odfi_branch_originator_id',
		'odfi_branch_friendly_name',
		'odfi_branch_name',
		'odfi_branch_city',
		/*
		'odfi_branch_state_province',
		'odfi_branch_country_code',
		'odfi_branch_dfi_id',
		'odfi_branch_dfi_id_qualifier',
		'odfi_branch_go_dfi_id',
		'odfi_branch_status',
		'odfi_branch_plugin',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
