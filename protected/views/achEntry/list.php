<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

?>
<h2>Transactions</h2>

<ul data-role="listview" data-filter="true" data-inset="true" data-split-icon="gear" data-split-theme="a" data-count-theme="a" class="ach_entry-items">
<?php $nCount = 0; foreach ( $items as $item ): ?>
<?php $nCount++; $evenOddClass = ( $nCount % 2 ) ? 'ui-bar-e' : 'ui-bar-d'; ?>
<li>
	<a href="#" data-role="simpledialog-link">
	<p class="float-left col-3"><strong>#<?php echo $item->ach_entry_detail_individual_id_number; ?></strong></p>
	<p class="float-left col-6"><strong><?php echo $item->ach_entry_detail_individual_name; ?></strong></p>
	<p class="float-left col-6">$<?php echo number_format( $item->ach_entry_detail_amount / 100, 2); ?></p>
	</a>
	<div class="simpledialog-content" data-source="ajax" data-path="/achEntry/view" data-model-id="<?= $item->ach_entry_id; ?>"></div>
</li>
<?php endforeach; ?>
</ul>
