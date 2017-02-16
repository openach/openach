<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

?>
<ul data-role="listview" data-inset="true" data-split-icon="gear" data-split-theme="a" data-count-theme="a" class="odfi_branch-items">
<?php if ( count( $items ) > 0 ): ?>
	<li data-role="list-divider"><?= ( count( $items ) == 1 ) ? 'Bank' : 'Banks'; ?></li>
<?php endif; ?>
<?php foreach ( $items as $item ): ?>
	<li>
		<a href="<?php echo $this->createUrl( 'odfiBranch/view', array( 'id' => $item->odfi_branch_id ) ); ?>">
		<img src="/images/icons/large/bank.png" />
		<h3><?= $item->odfi_branch_friendly_name; ?></h3>
		<p><?= $item->odfi_branch_city . ', ' . $item->odfi_branch_state_province . ' ' . $item->odfi_branch_country_code; ?></p>
		</a><a data-rel="dialog" href="<?php echo $this->createUrl( 'odfiBranch/update', array( 'id' => $item->odfi_branch_id ) ); ?>">Edit Bank</a>
	</li>
<?php endforeach; ?>
<?php $this->renderPartial( '//odfiBranch/_footerControl', array( 'items' => $items, 'parent_id' => $parent_id ) ); ?>
</ul>
