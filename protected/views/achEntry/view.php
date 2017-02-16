<?php
$this->breadcrumbs=array(
	'Ach Entries'=>array('index'),
	$model->ach_entry_id,
);

$this->isDialog = true;

$this->stockMenus( array() );

?>
<ul data-role="listview" data-inset="false" data-theme="a">
	<li data-role="list-divider">Transaction</li>
</ul>
<h1 class='entry-amount'><?= $model->displayAmount(); ?></h1>
<ul class="small-thumb" data-role="listview" data-inset="false" data-theme="a">
	<li data-role="list-divider">Details</li>
	<li class="customer">
		<img src="/images/icons/customer.png" />
		<h3><?= $model->displayCustomer(); ?></h3>
<?php if ( $model->external_account->hasAddress() ): ?>
		<p><?= $model->external_account->displayAddress(); ?></p>
<?php endif; ?>
	</li>
	<li><img src="/images/icons/detail.png" /><?= $model->ach_batch->displayDescription(); ?></li>
	<li><img src="/images/icons/receipt.png" /><?= $model->displayReceiptNumber(); ?></li>
	<li><img src="/images/icons/clock.png" /><?= $model->displayDate(); ?></li>
	<li><img src="/images/icons/status.png" /><?= $model->displayStatus(); ?></li>
	<li><img src="/images/icons/echeck.png" /><?= $model->displayAccountNumber(); ?></li>
</ul>
<div class="ui-grid-a">
	<div class="ui-block-a"><button type="submit" data-theme="c">Send Receipt</button></div>
	<div class="ui-block-b"><button type="submit" data-theme="c">Issue Refund</button></div>
</div>

