<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

?>
<h2>Transfers</h2>

<ul data-role="listview" data-filter="true" data-inset="false" data-split-icon="gear" data-split-theme="a" data-count-theme="a" class="file_transfer-items">
<?php $nCount = 0; foreach ( $items as $item ): ?>
<?php $nCount++; $evenOddClass = ( $nCount % 2 ) ? 'ui-bar-e' : 'ui-bar-d'; ?>
<li>
	<a href="#" data-role="simpledialog-link">
	<p class="float-left col-3"><strong><?= $item->displayDate(); ?></strong></p>
	<p class="float-left col-5"><strong><?= $item->displayStatus(); ?></strong></p>
	<p class="float-left col-7"><?= $item->file_transfer_message; ?></p>
	</a>
	<div class="simpledialog-content" data-source="ajax" data-path="/fileTransfer/view" data-model-id="<?= $item->file_transfer_id; ?>"></div>
</li>
<?php endforeach; ?>
<?php if ( $nCount == 0 ) : ?>
<li><h3>No transfers found</h3></li>
<?php endif; ?>
</ul>
