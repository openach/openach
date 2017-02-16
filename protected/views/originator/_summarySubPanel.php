<ul data-role="listview" data-inset="true" data-divider-theme="a" data-theme="a" data-split-icon="gear" data-split-theme="a">
	<li data-role="list-divider">Originator</li>
	<li data-split-icon="gear" data-split-theme="a">
		<a href="<?php echo $this->createUrl( 'originator/view', array( 'id' => $model->originator_id ) ); ?>">
		<img src="/images/icons/large/originator.png" />
		<h3><?= $model->originator_name; ?></h3>
		<p><?= $model->displayAddress(); ?></p>
		</a><a data-rel="dialog" href="<?php echo $this->createUrl( 'originator/update', array( 'id' => $model->originator_id ) ); ?>">Edit Originator</a>
	</li>
</ul>

