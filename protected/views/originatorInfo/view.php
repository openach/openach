<?php
$this->breadcrumbs=array(
	'Origination Accounts'=>array('index'),
	$model->originator_info_id,
);

$this->stockMenus( array( ) );

$this->renderPartial( '/originator/_summarySubPanel', array( 'model'=>$model->originator ) );
$this->renderPartial( '_summarySubPanel', array( 'model'=>$model ) );
$this->renderPartial( '/externalAccount/list', array( 'collapsible' => false, 'originator_info_id' => $model->originator_info_id, 'items'=>$model->external_accounts, 'parent_id'=>$model->originator_info_id ) );
$this->renderPartial( '/paymentType/list', array( 'items'=>$model->payment_types, 'parent_id'=>$model->originator_info_id ) );
$this->widget( 'OriginatorInfoPanelNavigation', array( 'model'=>$model ) );

