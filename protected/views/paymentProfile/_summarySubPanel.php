<ul class="small-thumb" data-role="listview" data-split-icon="gear" data-split-theme="c" data-inset="true" data-theme="a">
	<li data-role="list-divider">Payment Profile</li>
	<li class="header-thumb">
		<a href="<?= $this->createUrl( 'paymentProfile/view', array( 'id' => $model->payment_profile_id ) ); ?>">
		<img src="/images/icons/large/customer.png" />
		<h3><?= $model->displayCustomer(); ?></h3>
		<p><?= $model->displayEmailAddress(); ?></p>
		<p><?= $model->displayExternalId(); ?></p>
		<span class="ui-li-count"><?= $model->payment_profile_status; ?></span>
		</a><a data-rel="dialog" href="<?= $this->createUrl( 'paymentProfile/update', array( 'id' => $model->payment_profile_id ) ); ?>">Edit Payment Profile</a>
	</li>
</ul>

