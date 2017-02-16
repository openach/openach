<ul class="small-thumb" data-role="listview" data-split-icon="gear" data-split-theme="c" data-inset="true" data-theme="a">
	<li data-role="list-divider">Payment Type</li>
	<li class="header-thumb">
		<a href="<?= $this->createUrl( 'paymentType/view', array( 'id' => $model->payment_type_id ) ); ?>">
		<img src="/images/icons/large/customer.png" />
		<h3><?= $model->payment_type_name; ?></h3>
		<span class="ui-li-count"><?= $model->payment_type_status; ?></span>
		</a><a data-rel="dialog" href="<?= $this->createUrl( 'paymentType/update', array( 'id' => $model->payment_type_id ) ); ?>">Edit Payment Type</a>
	</li>
</ul>

