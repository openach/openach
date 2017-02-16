	<li class="list-footer-control" data-theme="<?= ( count( $items ) == 0 ) ? 'e' : 'a'; ?>" data-icon="plus">
		<a data-rel="dialog" href="<?= $this->createUrl( 'paymentType/create', array( 'parent_id' => $parent_id ) ); ?>">
			<h4><?= ( count( $items ) == 0 ) ? 'Next Step: ' : ''; ?>Add a Payment Type</h4>
		</a>
	</li>

