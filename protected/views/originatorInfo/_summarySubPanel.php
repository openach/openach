<ul data-role="listview" data-inset="true" data-theme="a" data-split-icon="gear" data-split-theme="a">
	<li data-role="list-divider">Origination Account</li>
	<li data-split-icon="gear" data-split-theme="a">
		<a href="<?php echo $this->createUrl( 'originatorInfo/view', array( 'id' => $model->originator_info_id ) ); ?>">
		<img src="/images/icons/large/business.png" />
		<h3><?= $model->originator_info_name; ?></h3>
		<p><?= $model->displayAddress(); ?></p>
		<p>Processed Via: <?= $model->displayOdfiBranchName(); ?></p></a><a data-rel="dialog" href="<?php echo $this->createUrl( 'originatorInfo/update', array( 'id' => $model->originator_info_id ) ); ?>">Edit Origination Account</a>
	</li>
</ul>

