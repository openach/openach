<?php
$this->breadcrumbs=array(
	'Ach Entries',
);

$this->menu=array(
	array('label'=>'Create AchEntry', 'url'=>array('create')),
	array('label'=>'Manage AchEntry', 'url'=>array('admin')),
);
?>

<h1>Ach Entries</h1>

<?php 
/*$this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
));
*/

$this->widget('ext.slickgrid.CSlickGrid', array(
        'dataProvider'=>$dataProvider,
        'htmlOptions'=>array( 'style'=>'width:909px;height:500px;' ),
        'slickgridOptions'=>array(
                'enableCellNavigation'=>false,
                'enableColumnReorder'=>true,
                'forceFitColumns'=>true,
        ),
        'slickgridPlugins'=>array(
                'rowselectionmodel'=>'grid.setSelectionModel(new Slick.RowSelectionModel());',
        ),
        'defaultColumnOptions'=>array(
        ),
        //'columns'=>array('data_field_one','data_field_two'),
	'columns'=>array('ach_entry_id','ach_entry_detail_amount','),
        'enableAjax'=>true,
	'ajaxDataUrl'=> '/' .Yii::app()->controller->getId().'/'.Yii::app()->controller->getAction()->getId(),
));
?>
