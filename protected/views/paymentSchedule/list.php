<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

?>
<h2>Payment Schedules</h2>

<ul data-role="listview" data-inset="false" data-split-icon="gear" data-split-theme="a" data-count-theme="a" class="payment_schedule-items">
<?php foreach ( $items as $item ): ?>
<li>
	<a data-rel="dialog" href="<?php echo $this->createUrl( 'paymentSchedule/update', array( 'id' => $item->payment_schedule_id ) ); ?>">
	<h3><?= $item->payment_schedule_frequency; ?></h3>
	<h4><?= $item->external_account->external_account_name; ?></h4>
	<p><?= $item->payment_schedule_amount; ?></p>
	<span class="ui-li-count"><?php echo CHtml::encode($item->payment_schedule_status); ?></span>
	</a>
</li>
<?php endforeach; ?>
</ul>
