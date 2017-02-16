<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/
?>
<ul data-role="listview" data-inset="true" data-split-icon="gear" data-split-theme="a" data-count-theme="a" class="payment_type-items">
<?php if ( count( $items ) > 0 ): ?>
	<li data-role="list-divider"><?= ( count( $items ) == 1 ) ? 'Payment Type' : 'Payment Types'; ?></li>
<?php endif; ?>
<?php foreach ( $items as $item ): ?>
	<li>
		<a data-rel="dialog" href="<?php echo $this->createUrl( 'paymentType/update', array( 'id' => $item->payment_type_id ) ); ?>">
		<img src="/images/icons/large/paymenttype.png" />
		<h3><?= $item->payment_type_name; ?></h3>
		<p><?= $item->payment_type_description; ?></p>
		<?php if ( $item->external_account ) : ?><p>Using <?= $item->external_account->external_account_name; ?></p><?php endif; ?>
		<span class="ui-li-count"><?= $item->payment_type_status; ?></span>
		</a><a data-rel="dialog" href="<?php echo $this->createUrl( 'paymentType/update', array( 'id' => $item->payment_type_id ) ); ?>">Edit Payment Type</a>
	</li>
<?php endforeach; ?>
<?php $this->renderPartial( '//paymentType/_footerControl', array( 'items' => $items, 'parent_id' => $parent_id ) ); ?>
</ul>
