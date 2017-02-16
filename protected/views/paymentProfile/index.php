<?php
$this->breadcrumbs=array(
	'Payment Profiles',
);

$this->stockMenus( array( array( 'create', 'parent_id' => $originatorInfo->originator_info_id ) /*, 'search'*/ ) );

$this->renderPartial( '/originatorInfo/_summarySubPanel', array( 'model'=>$originatorInfo ) );

?>

<h1>Payment Profiles</h1>

<?php $this->showOAListView( $dataProvider,  array( 'payment_profile_last_name', 'payment_profile_email_address', 'payment_profile_status' ) ); ?>

