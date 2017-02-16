<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

?>
<h2>Batches</h2>
<?php $content = "test"; ?>
<?php for ( $i = 1; $i < 20; $i++ ) : ?>
<?php $gridTheme = ( $i % 2 ) ? 'ui-bar-d' : 'ui-bar-c'; ?>
		<div class="ui-grid-d">
			<div class="ui-block-a"><div class="ui-bar <?= $gridTheme; ?>"><?= $content; ?></div></div>
			<div class="ui-block-b"><div class="ui-bar <?= $gridTheme; ?>"><?= $content; ?></div></div>
			<div class="ui-block-c"><div class="ui-bar <?= $gridTheme; ?>"><?= $content; ?></div></div>
			<div class="ui-block-d"><div class="ui-bar <?= $gridTheme; ?>"><?= $content; ?></div></div>
			<div class="ui-block-e"><div class="ui-bar <?= $gridTheme; ?>"><?= $content; ?></div></div>
		</div><!-- /grid-c -->
<?php endfor; ?>

