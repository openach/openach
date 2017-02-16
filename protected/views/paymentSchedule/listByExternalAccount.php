<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/
$items = array();
?>
<h2>Payment Schedules</h2>

<ul data-role="listview" data-inset="false" data-split-icon="gear" data-split-theme="a" data-count-theme="a" class="payment_schedule-items">
<?php foreach ( $external_accounts as $external_account ) : 
	if ( ! $external_account->payment_schedules )
	{
		continue;
	}
	$items = CMap::mergeArray( $items, $external_account->payment_schedules );
?>
	<?php foreach ( $external_account->payment_schedules as $item ): ?>
	<?php $this->renderPartial( '//paymentSchedule/_view', array( 'data'=>$item ) ); ?>
	<?php endforeach; ?>
<?php endforeach; ?>
<?php $this->renderPartial( '//paymentSchedule/_footerControl', array( 'items'=>$items, 'parent_id'=>$parent_id ) ); ?>
</ul>
