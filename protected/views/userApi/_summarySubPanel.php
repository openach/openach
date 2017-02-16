<ul data-role="listview" data-inset="true" data-theme="a" data-split-icon="gear" data-split-theme="a">
	<li data-role="list-divider">API User</li>
	<li>
		<a data-role="simpledialog-link" href="#">
		<img src="/images/icons/large/services.png" />
		<h3><?= $model->originator_info->originator_info_name; ?></h3>
		<p><?= $model->user_api_token; ?><?= $model->user_api_status == 'disabled' ? '(disabled)' : ''; ?></p>
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
</ul>

