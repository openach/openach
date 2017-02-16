<ul data-role="listview" data-inset="true" data-theme="a" data-split-icon="gear" data-split-theme="a">
	<li data-role="list-divider">Batch</li>
	<li data-split-icon="gear" data-split-theme="a">
		<a href="<?php echo $this->createUrl( 'achBatch/view', array( 'id' => $model->ach_batch_id ) ); ?>">
		<img src="/images/icons/large/achbatch.png" />
		<h3><?= $model->displayDescription(); ?></h3>
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
				<li data-role="list-divider"><?= $model->displayDescription(); ?></li>
				<li><img src="/images/icons/business.png" /><?= $model->ach_batch_header_company_name; ?></li>
				<li><img src="/images/icons/id.png" /><?= $model->ach_batch_header_company_identification; ?></li>
				<li><img src="/images/icons/schedule.png" /><?= $model->getEffectiveDateTime()->format( 'm/d/Y' ); ?>
				<li><img src="/images/icons/total.png" /><?= $model->displayCredits(); ?></li>
				<li><img src="/images/icons/total.png" /><?= $model->displayDebits(); ?></li>
				<li><img src="/images/icons/openach.png" /><?= $model->displayEntryHash(); ?></li>
				<li><img src="/images/icons/bank.png" /><?= $model->ach_file->odfi_branch->odfi_branch_name; ?></li>
				<li><img src="/images/icons/plugin.png" /><?= $model->ach_file->odfi_branch->displayPlugin(); ?></li>
				<li><img src="/images/icons/status.png" /><?= $model->ach_file->displayStatus(); ?></li>
				<li><img src="/images/icons/count.png" /><?= $model->displayEntryAddendaCount(); ?></li>
				<li><img src="/images/icons/business.png" /><?= $model->ach_batch_header_company_name; ?></li>
				<li><img src="/images/icons/id.png" /><?= $model->ach_batch_header_company_identification; ?></li>
			</ul>
		</div>
	</li>
</ul>

