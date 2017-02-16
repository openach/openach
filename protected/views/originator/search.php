<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

$this->breadcrumbs=array(
	'Originators'=>array('index'),
	'Manage',
);

$this->stockMenus( array( 'list','create' ) );

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('originator-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Search Originators</h1>

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

<?php $this->showOAListView( $dataProvider,  array( 'originator_name', 'originator_city', 'originator_state_province' ) ); ?>

