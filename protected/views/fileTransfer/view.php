<?php
$this->breadcrumbs=array(
	'Ach Entries'=>array('index'),
	$model->file_transfer_id,
);

$this->isDialog = true;

$this->stockMenus( array() );

?>
<ul class="small-thumb" data-role="listview" data-inset="false" data-theme="a">
	<li data-role="list-divider">File Transfer</li>
	<li><img src="/images/icons/achfile.png" /><?= $model->ach_file->displayFileId(); ?></li>
	<li><img src="/images/icons/clock.png" />Transfer Date: <?= $model->displayDate(); ?></li>
	<li><img src="/images/icons/plugin.png" /><?= $model->displayPlugin(); ?></li>
	<li><img src="/images/icons/status.png" /><?= $model->displayStatus(); ?></li>
	<li><img src="/images/icons/detail.png" /><?= $model->displayMessage(); ?></li>
</ul>
