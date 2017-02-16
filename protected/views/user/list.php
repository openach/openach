<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

?>
<ul data-role="listview" data-inset="true" data-split-icon="gear" data-split-theme="a" data-count-theme="a" class="user-items">
<?php if ( count( $items ) > 0 ): ?>
	<li data-role="list-divider"><?= ( count( $items ) == 1 ) ? 'User' : 'Users'; ?></li>
<?php endif; ?>
<?php foreach ( $items as $item ): ?>
	<li>
		<a href="<?php echo $this->createUrl( 'user/view', array( 'id' => $item->user_id ) ); ?>">
		<img src="/images/icons/large/user.png" />
		<h3><?= $item->user_login; ?></h3>
		<p><?= $item->displayName(); ?></p>
		</a><a data-rel="dialog" href="<?php echo $this->createUrl( 'user/update', array( 'id' => $item->user_id ) ); ?>">Edit User</a>
	</li>
<?php endforeach; ?>
</ul>
