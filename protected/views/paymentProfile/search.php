<?php
$this->breadcrumbs=array(
	'Payment Profiles'=>array('index'),
	'Manage',
);

$this->stockMenus( array( 'create', 'list' ) );

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('payment-profile-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Search Payment Profiles</h1>

<div data-role="collapsible" class="search-form">
	<h3>Search Options</h3>
<p>You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->showOAListView( $dataProvider,  array( 'payment_profile_last_name', 'payment_profile_email_address', 'payment_profile_status' ) ); ?>

