<?php
$this->breadcrumbs=array(
	'Payment Schedules'=>array('index'),
	'Manage',
);

$this->stockMenus( array( 'create', 'list' ) );

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('payment-schedule-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Payment Schedules</h1>

<div data-role="collapsible" class="search-form">
	<h3>Search Options</h3>
<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->showOAListView( $model->search(),  array( 'payment_schedule_status', 'payment_schedule_amount','payment_schedule_next_date','payment_schedule_frequency' ) ); ?>

