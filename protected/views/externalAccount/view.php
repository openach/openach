<?php
$this->breadcrumbs=array(
	'Bank Account'=>array('index'),
	$model->external_account_id,
);

$this->stockMenus( array() );

$this->isDialog = true;
?>
<ul class="small-thumb" data-role="listview" data-inset="false" data-theme="a">
	<li data-role="list-divider">Bank Account</li>
	<li><img src="/images/icons/bank.png" /><?= $model->external_account_bank; ?></li>
	<li><img src="/images/icons/customer.png" /><?= $model->external_account_holder; ?></li>
	<li><img src="/images/icons/detail.png" /><?= $model->displayAddress(); ?></li>
	<li><img src="/images/icons/openach.png" /><?= $model->displayRoutingNumber(); ?></li>
	<li><img src="/images/icons/id.png" /><?= $model->displayAccountNumber(); ?></li>
	<li><img src="/images/icons/detail.png" /><?= $model->displayAccountType(); ?></li>
	<li><img src="/images/icons/globe.png" /><?= $model->displayCountry(); ?></li>
	<li><img src="/images/icons/status.png" /><?= $model->displayStatus(); ?></li>

</ul>

