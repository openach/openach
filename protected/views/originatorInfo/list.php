<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

?>
<ul data-role="listview" data-inset="true" data-split-icon="gear" data-split-theme="a" data-count-theme="a" class="originator_info-items">
<?php if ( count( $items ) > 0 ): ?>
	<li data-role="list-divider">Origination Accounts</li>
<?php endif; ?>
<?php foreach ( $items as $item ): ?>
	<li>
		<a href="<?php echo $this->createUrl( 'originatorInfo/view', array( 'id' => $item->originator_info_id ) ); ?>">
		<img src="/images/icons/large/business.png" />
		<h3><?= $item->originator_info_name; ?></h3>
		<p><?= $item->originator_info_description; ?></p>
		</a><a data-rel="dialog" href="<?php echo $this->createUrl( 'originatorInfo/update', array( 'id' => $item->originator_info_id ) ); ?>">Edit Account</a>
	</li>
<?php endforeach; ?>
<?php $this->renderPartial( '//originatorInfo/_footerControl', array( 'items'=>$items, 'parent_id'=>$parent_id ) ); ?>
</ul>
