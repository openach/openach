<?php
$this->breadcrumbs=array(
	'Payment Schedules'=>array('index'),
	$model->payment_schedule_id,
);
$this->stockMenus( array() );
$this->isDialog = true;
?>
<ul class="small-thumb" data-role="listview" data-inset="false" data-theme="a">
	<li data-role="list-divider">Payment Schedule</li>
	<li class="customer">
		<img src="/images/icons/schedule.png" />
		<h3><?= $model->displayAmount(); ?> on <?= $model->displayNextDate(); ?></h3>
		<p><?= $model->displayScheduleInfo(); ?></p>
	</li>
	<li data-role="list-divider">Details</li>
	<li><img src="/images/icons/customer.png" /><?= $model->external_account->payment_profile->displayCustomer(); ?></li>
	<li><img src="/images/icons/bank.png" /><?= $model->external_account->displayBankName(); ?></li>
	<li><img src="/images/icons/id.png" /><?= $model->external_account->displayAccountNumber() ; ?></li>
<?php if ( count ( $model->ach_entries ) > 0 ) : ?>
	<li data-role="list-divider">Transactions</li>
	<?php foreach ( $model->ach_entries as $ach_entry ): ?>
	<li>
		<a href="<?= $this->createUrl( 'achEntry/view', array( 'id' => $ach_entry->ach_entry_id ) ); ?>">
			<h3><?= $ach_entry->displayAmount(); ?></h3>
			<p><?= $ach_entry->displayDate(); ?></p>
			<p><?= $ach_entry->displayReceiptNumber(); ?></p>
			<span class="ui-li-aside"><?= $ach_entry->displayStatus(); ?></span>
		</a>
	</li>
	<?php endforeach; ?>
<?php endif; ?>
</ul>
