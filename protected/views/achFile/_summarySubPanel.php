<ul data-role="listview" data-inset="true" data-theme="a" data-split-icon="gear" data-split-theme="a">
	<li data-role="list-divider">File</li>
	<li data-split-icon="gear" data-split-theme="a">
		<a href="<?php echo $this->createUrl( 'achFile/view', array( 'id' => $model->ach_file_id ) ); ?>">
		<img src="/images/icons/large/achfile.png" />
		<h3><?= $model->displayFileId(); ?></h3>
		<p><?= $model->displayDebits(); ?></p>
		<p><?= $model->displayCredits(); ?></p>
		</a>
	</li>
	<li class="list-footer-control" data-theme="a" data-icon="arrow-r">
		<a data-role="simpledialog-link" href="#">
			<h4>View Details</h4>
		</a>
		<div class="simpledialog-content">
			<ul class="small-thumb" data-role="listview" data-inset="false" data-theme="a">
				<li data-role="list-divider"><?= $model->displayFileId(); ?></li>
				<li><img src="/images/icons/total.png" /><?= $model->displayCredits(); ?></li>
				<li><img src="/images/icons/total.png" /><?= $model->displayDebits(); ?></li>
				<li><img src="/images/icons/openach.png" /><?= $model->displayEntryHash(); ?></li>
				<li><img src="/images/icons/bank.png" /><?= $model->odfi_branch->odfi_branch_name; ?></li>
				<li><img src="/images/icons/plugin.png" /><?= $model->odfi_branch->displayPlugin(); ?></li>
				<li><img src="/images/icons/status.png" /><?= $model->displayStatus(); ?></li>
				<li><img src="/images/icons/achbatch.png" /><?= $model->displayBatchCount(); ?></li>
				<li><img src="/images/icons/transaction.png" /><?= $model->displayEntryAddendaCount(); ?></li>
			</ul>
		</div>
	</li>
</ul>

