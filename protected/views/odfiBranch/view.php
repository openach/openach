<?php
$this->breadcrumbs=array(
	'Odfi Branches'=>array('index'),
	$model->odfi_branch_id,
);

$this->stockMenus( array() );

$this->renderPartial( '/originator/_summarySubPanel', array( 'model'=>$model->originator ) );
$this->renderPartial( '_summarySubPanel', array( 'model'=>$model, 'data-theme'=>'f' ) );
if ( Yii::app()->user->model()->hasRole( 'administrator' ) ):
	$this->renderPartial( '/pluginConfig/list', array( 'dataProvider'=>$model->getBankConfig()->getDataProvider(), 'parent_id'=>$model->odfi_branch_id ) );
endif;
$this->renderPartial( '/originatorInfo/list', array( 'items'=>$model->originator_info, 'parent_id'=>$model->odfi_branch_originator_id ) );

