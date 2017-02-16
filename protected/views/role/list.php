<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

?>
<ul data-role="listview" data-inset="true" data-split-icon="gear" data-split-theme="a" data-count-theme="a" class="role-items">
<?php if ( count( $items ) > 0 ): ?>
	<li data-role="list-divider"><?= ( count( $items ) == 1 ) ? 'Role' : 'Roles'; ?></li>
<?php endif; ?>
<?php foreach ( $items as $item ): ?>
	<li>
		<a href="<?php echo $this->createUrl( 'role/view', array( 'id' => $item->role_id ) ); ?>">
		<img src="/images/icons/large/role.png" />
		<h3><?= $item->role_name; ?></h3>
		<p><?= $item->role_description; ?></p>
		</a>
	</li>
<?php endforeach; ?>
</ul>
