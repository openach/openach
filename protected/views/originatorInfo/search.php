<?php
$this->breadcrumbs=array(
	'Originator Infos'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List OriginatorInfo', 'url'=>array('index')),
	array('label'=>'Create OriginatorInfo', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('originator-info-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Originator Infos</h1>

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
	'id'=>'originator-info-grid',
	'dataProvider'=>$dataProvider,
	'filter'=>$model,
	'columns'=>array(
		'originator_info_id',
		'originator_info_datetime',
		'originator_info_odfi_branch_id',
		'originator_info_originator_id',
		'originator_info_name',
		'originator_info_description',
		/*
		'originator_info_identification',
		'originator_info_address',
		'originator_info_city',
		'originator_info_state_province',
		'originator_info_postal_code',
		'originator_info_country_code',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
