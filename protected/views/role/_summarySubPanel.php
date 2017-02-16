<ul data-role="listview" data-inset="true" data-theme="a" data-split-icon="gear" data-split-theme="a">
	<li data-role="list-divider">Role</li>
	<li data-split-icon="gear" data-split-theme="a">
		<a href="<?php echo $this->createUrl( 'role/view', array( 'id' => $model->role_id ) ); ?>">
		<img src="/images/icons/large/role.png" />
		<h3><?= $model->role_name; ?></h3>
		<p><?= $model->role_description; ?></p>
		</a><a data-rel="dialog" href="<?php echo $this->createUrl( 'role/update', array( 'id' => $model->role_id ) ); ?>">Edit Role</a>
	</li>
	<li class="list-footer-control" data-theme="a" data-icon="arrow-r">
		<a data-role="simpledialog-link" href="#">
			<h4>View Details</h4>
		</a>
		<div class="simpledialog-content">
			<ul class="small-thumb" data-role="listview" data-inset="false" data-theme="a">
				<li data-role="list-divider"><?= $model->role_name; ?></li>
				<li><img src="/images/icons/originator.png" />Max Originators: <?= $model->role_max_originator; ?></li>
				<li><img src="/images/icons/bank.png" />Max ODFI Branches: <?= $model->role_max_odfi; ?></li>
				<li><img src="/images/icons/plugin.png" />Max Daily Transfers: <?= $model->role_max_daily_xfers; ?></li>
				<li><img src="/images/icons/achfile.png" />Max Daily Files: <?= $model->role_max_daily_files; ?></li>
				<li><img src="/images/icons/achbatch.png" />Max Daily Batches: <?= $model->role_max_daily_batches; ?></li>
				<li><img src="/images/icons/globe.png" />IAT Enabled: <?= $model->displayIATEnabled(); ?></li>
			</ul>
		</div>
	</li>
</ul>

