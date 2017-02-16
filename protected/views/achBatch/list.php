<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

?>
<h2>Batches</h2>

<ul data-role="listview" data-filter="true" data-inset="true" data-split-icon="gear" data-split-theme="a" data-count-theme="a" class="ach_batch-items">
<?php foreach ( $items as $item ): ?>
<li>
	<a href="<?php echo $this->createUrl( 'achBatch/view', array( 'id' => $item->ach_batch_id ) ); ?>">
	<p class="float-left col-3"><strong>#<?php echo $item->ach_batch_header_discretionary_data; ?></strong></p>
	<p class="float-left col-4"><strong><?php echo $item->ach_batch_header_company_entry_description; ?></strong></p>
<?php if ( $item->ach_batch_control_total_credits != 0 ): ?>
	<p class="float-left col-5"><strong><?= $item->displayCredits(); ?></strong></p>
<?php else: ?>
	<p class="float-left col-5"><strong><?= $item->displayDebits(); ?></strong></p>
<?php endif; ?>
	<p class="ui-li-count"><?php echo $item->ach_batch_header_standard_entry_class; ?></p>
	</a>
</li>
<?php endforeach; ?>
</ul>
