<?php
$this->breadcrumbs=array(
	'Payment Types',
);

$this->stockMenus( array( /*'create', 'search'*/ ) );

$this->renderPartial( '/originatorInfo/_summarySubPanel', array( 'model'=>$originatorInfo ) );

?>
<ul data-role="listview" data-inset="true" data-split-icon="plus" data-theme="a" data-split-theme="a" class="header-listview" payment-type-header">
	<li><a href="<?php echo $this->createUrl( 'paymentType/index', array( 'originator_info_id' => $originatorInfo->originator_info_id ) ); ?>"><h1>Payment Types</h1></a><a data-rel="dialog" href="<?php echo $this->createUrl( 'paymentType/create', array( 'parent_id' => $originatorInfo->originator_info_id ) ); ?>">New Payment Type</a></li>
</ul>
<?php $this->showOAListView( $dataProvider,  array( /*'payment_type_name', 'payment_type_status' */) ); ?>

