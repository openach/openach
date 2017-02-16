<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/
?>
<li>
	<a href="#" data-role="simpledialog-link">
	<img src="/images/icons/large/schedule.png" />
	<h3><?= $data->displayAmount(); ?> on <?= $data->displayNextDate(); ?></h3>
	<p><strong><?php echo $data->displayScheduleInfo(); ?></strong></p>
	<p>Customer: <?= $data->external_account->payment_profile->displayCustomer(); ?></p>
	<span class="ui-li-count"><?= $data->payment_schedule_status; ?></span>
	</a><a data-rel="dialog" href="<?php echo $this->createUrl( 'paymentSchedule/update', array( 'id' => $data->payment_schedule_id ) ); ?>">Edit Payment</a>
	<div class="simpledialog-content" data-source="ajax" data-path="/paymentSchedule/view" data-model-id="<?= $data->payment_schedule_id; ?>"></div>
</li>
