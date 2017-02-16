<?php
$this->breadcrumbs=array(
	'Payment Types'=>array('index'),
	$model->payment_type_id,
);

$this->stockMenus( array() );

$this->renderPartial( '/originatorInfo/_summarySubPanel', array( 'model'=>$model->originator_info ) );
$this->renderPartial( '_summarySubPanel', array( 'model'=>$model ) );

?>

<div data-role="collapsible-set" data-theme="b" data-content-theme="a">
	<div data-role="collapsible">
		<?php $this->renderPartial( '/externalAccount/list', array( 'items'=>$model->external_accounts, 'parent_id'=>$model->payment_type_id ) ); ?>
	</div>
	<div data-role="collapsible" data-collapsed="false">
		<?php $this->renderPartial( '/paymentSchedule/listByExternalAccount', array( 'external_accounts'=>$model->external_accounts, 'parent_id'=>$model->payment_type_id ) ); ?>
	</div>
</div>

