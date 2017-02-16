<ul data-role="listview" data-inset="true" data-theme="a" data-split-icon="gear" data-split-theme="a">
	<li data-role="list-divider">Transaction</li>
	<li data-split-icon="gear" data-split-theme="a">
		<a href="<?php echo $this->createUrl( 'achEntry/view', array( 'id' => $model->ach_entry_id ) ); ?>">
		<img src="/images/icons/large/transaction.png" />
		<h3><?= $model->displayCustomer(); ?></h3>
		<p><?= $model->displayAmount(); ?></p>
		</a>
	</li>
	<li class="list-footer-control" data-theme="a" data-icon="arrow-r">
		<a data-role="simpledialog-link" href="#">
			<h4>View Details</h4>
		</a>
		<div class="simpledialog-content">

			<ul class="small-thumb" data-role="listview" data-inset="false" data-theme="a">
				<li data-role="list-divider">Details</li>
				<li class="customer">
					<img src="/images/icons/customer.png" />
					<h3><?= $model->displayCustomer(); ?></h3>
				</li>
				<li><img src="/images/icons/detail.png" /><?= $model->ach_batch->displayDescription(); ?></li>
				<li><img src="/images/icons/receipt.png" /><?= $model->displayReceiptNumber(); ?></li>
				<li><img src="/images/icons/clock.png" /><?= $model->displayDate(); ?></li>
				<li><img src="/images/icons/status.png" /><?= $model->displayStatus(); ?></li>
				<li><img src="/images/icons/echeck.png" /><?= $model->displayAccountNumber(); ?></li>
			</ul>
		</div>
	</li>
</ul>

