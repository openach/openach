<?php
$this->stockMenus( array( 'create', 'search' ) );
?>

<h1>Payment Schedules</h1>

<?php $this->showOAListView( $dataProvider,  array( 'payment_schedule_status', 'payment_schedule_amount','payment_schedule_next_date','payment_schedule_frequency' ) ); ?>

