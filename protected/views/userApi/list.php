<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

?>
<ul data-role="listview" data-inset="true" data-split-icon="gear" data-split-theme="a" data-count-theme="a" class="userapi-items">
<?php if ( count( $items ) > 0 ): ?>
	<li data-role="list-divider"><?= ( count( $items ) == 1 ) ? 'API User' : 'API Users'; ?></li>
<?php endif; ?>
<?php foreach ( $items as $model ): ?>
	<li>
		<a data-role="simpledialog-link" href="#">
		<img src="/images/icons/large/services.png" />
		<h3><?= $model->originator_info->originator_info_name; ?></h3>
		<p><code><?= $model->user_api_token; ?></code><?= $model->user_api_status == 'disabled' ? '(disabled)' : ''; ?></p>
		</a>
		<div class="simpledialog-content">
			<ul class="small-thumb" data-role="listview" data-inset="false" data-theme="a">
				<li data-role="list-divider"><?= $model->originator_info->originator_info_name; ?></li>
				<li><img src="/images/icons/lock.png" />Token: <code><?= $model->user_api_token; ?></code></li>
				<li><img src="/images/icons/key.png" />Key: <code><?= $model->user_api_key; ?></code></li>
				<li><img src="/images/icons/status.png" /><?= $model->user_api_status; ?></li>
			</ul>
		</div>
	</li>
<?php endforeach; ?>
</ul>
