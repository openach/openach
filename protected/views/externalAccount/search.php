<?php
$this->breadcrumbs=array(
	'External Accounts'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List ExternalAccount', 'url'=>array('index')),
	array('label'=>'Create ExternalAccount', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('external-account-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage External Accounts</h1>

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
	'id'=>'external-account-grid',
	'dataProvider'=>$dataProvider,
	'filter'=>$model,
	'columns'=>array(
		'external_account_id',
		'external_account_datetime',
		'external_account_payment_profile_id',
		'external_account_type',
		'external_account_name',
		'external_account_bank',
		/*
		'external_account_holder',
		'external_account_country_code',
		'external_account_dfi_id',
		'external_account_dfi_id_qualifier',
		'external_account_number',
		'external_account_billing_address',
		'external_account_billing_city',
		'external_account_billing_state_province',
		'external_account_billing_postal_code',
		'external_account_billing_country',
		'external_account_business',
		'external_account_verification_status',
		'external_account_status',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
