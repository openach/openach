<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

$items = $dataProvider->getData();
?>
<?php if ( count( $items ) > 0 ): ?>
<div data-role="collapsible" data-inset="true" data-theme="b" data-content-theme="a" data-mini="true">
<h3>Plugin Config</h3>
<ul data-role="listview" data-inset="false" data-split-icon="gear" data-split-theme="a" data-count-theme="a" class="plugin_config-items" data-mini="true">
<?php foreach ( $items as $item ): ?>
	<li>
		<a data-rel="dialog" href="<?php echo $this->createUrl( 'pluginConfig/update', array( 'id' => $item->plugin_config_id ) ); ?>">
		<h3><?= $item->plugin_config_key; ?></h3>
		<p><?= stristr( $item->plugin_config_key, 'Password' ) ? '********' : $item->plugin_config_value; ?></p>
		</a><a data-rel="dialog" href="<?php echo $this->createUrl( 'pluginConfig/update', array( 'id' => $item->plugin_config_id ) ); ?>">Edit Item</a>
	</li>
<?php endforeach; ?>
</ul>
</div>
<?php endif; ?>
