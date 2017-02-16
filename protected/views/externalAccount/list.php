<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

$params = array( 'items'=>$items, 'parent_id'=>$parent_id );
if ( isset( $originator_info_id ) )
{
	$params['originator_info_id'] = $originator_info_id;
}
?>
<?php if ( $collapsible ): ?><h2>Bank Accounts</h2><?php endif; ?>

<ul data-role="listview" data-inset="<?= $collapsible ? 'false' : 'true'; ?>" data-split-icon="gear" data-split-theme="a" data-count-theme="a" class="external_account-items">
<?php if ( ! $collapsible && count( $items ) > 0 ): ?>
	<li data-role="list-divider"><?= ( count( $items ) == 1 ) ? 'Bank Account' : 'Bank Accounts'; ?></li>
<?php endif; ?>
<?php foreach ( $items as $item ): ?>
<li>
	<a href="#" data-role="simpledialog-link">
	<img src="/images/icons/large/bank.png" />
	<h3><?= $item->external_account_name; ?></h3>
	<p><?= $item->external_account_bank; ?></p>
	<span class="ui-li-count"><?php echo CHtml::encode($item->external_account_status); ?></span>
	</a><a data-rel="dialog" href="<?php echo $this->createUrl( 'externalAccount/update', array( 'id' => $item->external_account_id ) ); ?>">Edit Bank Account</a>
	<div class="simpledialog-content" data-source="ajax" data-path="/externalAccount/view" data-model-id="<?= $item->external_account_id; ?>"></div>
</li>
<?php endforeach; ?>
<?php $this->renderPartial( '//externalAccount/_footerControl', $params ); ?>
</ul>
