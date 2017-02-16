<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

?>
<ul data-role="listview" data-inset="true" data-split-icon="gear" data-split-theme="a" data-count-theme="a" class="ach_file-items">
<?php if ( count( $items ) > 0 ): ?>
	<li data-role="list-divider"><?= ( count( $items ) == 1 ) ? 'ACH File' : 'ACH Files'; ?></li>
<?php endif; ?>
<?php foreach ( $items as $item ): ?>
	<li>
		<a href="<?php echo $this->createUrl( 'achFile/view', array( 'id' => $item->ach_file_id ) ); ?>">
		<img src="/images/icons/large/achfile.png" />
		<h3><?= $item->displayFileId(); ?></h3>
		<p><?= $item->displayDebits(); ?></p>
		<p><?= $item->displayCredits(); ?></p>
		<span class="ui-li-count"><?= $item->displayStatus(); ?></span>
		</a>
	</li>
<?php endforeach; ?>
</ul>

