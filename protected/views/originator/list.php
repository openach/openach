<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

?>
<ul data-role="listview" data-inset="true" data-split-icon="gear" data-split-theme="a" data-count-theme="a" class="originator-items">
<?php if ( count( $items ) > 0 ): ?>
	<li data-role="list-divider"><?= ( count( $items ) == 1 ) ? 'Originator' : 'Originators'; ?></li>
<?php endif; ?>

<?php foreach ( $items as $item ): ?>
	<li>
		<a href="<?php echo $this->createUrl( 'originator/view', array( 'id' => $item->originator_id ) ); ?>">
		<img src="/images/icons/large/originator.png" />
		<h3><?php echo $item->originator_name; ?></h3>
		<p><strong><?= $item->displayAddress(); ?></strong></p>
		</a>
	</li>
<?php endforeach; ?>
	<li class="list-footer-control" data-theme="<?= ( count( $items ) == 0 ) ? 'e' : 'a'; ?>" data-icon="plus">
		<a data-rel="dialog" href="<?= $this->createUrl( 'originator/create', array( 'parent_id' => $user->user_id ) ); ?>">
			<h4>Add an Originatior</h4>
		</a>
	</li>

</ul>
