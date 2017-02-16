<ul data-role="listview" data-inset="true" data-theme="a" data-split-icon="gear" data-split-theme="a">
	<li data-role="list-divider">Bank</li>
	<li data-split-icon="gear" data-split-theme="a">
		<a href="<?php echo $this->createUrl( 'odfiBranch/view', array( 'id' => $model->odfi_branch_id ) ); ?>">
		<img src="/images/icons/large/bank.png" />
		<h3><?= $model->odfi_branch_friendly_name; ?></h3>
		<p><?= $model->displayAddress(); ?></p>
		</a><a data-rel="dialog" href="<?php echo $this->createUrl( 'odfiBranch/update', array( 'id' => $model->odfi_branch_id ) ); ?>">Edit Bank</a>
	</li>
	<li class="list-footer-control" data-theme="a" data-icon="arrow-r">
		<a data-role="simpledialog-link" href="#">
			<h4>View Details</h4>
		</a>
		<div class="simpledialog-content">
			<ul class="small-thumb" data-role="listview" data-inset="false" data-theme="a">
				<li data-role="list-divider"><?= $model->odfi_branch_name; ?></li>
				<li><img src="/images/icons/openach.png" /><?= $model->displayRoutingNumber(); ?></li>
				<li><img src="/images/icons/plugin.png" /><?= $model->displayPlugin(); ?></li>
				<li><img src="/images/icons/status.png" /><?= $model->displayStatus(); ?></li>
				<li><img src="/images/icons/globe.png" /><?= $model->displayGatewayDfi(); ?></li>
			</ul>
		</div>
	</li>
</ul>


