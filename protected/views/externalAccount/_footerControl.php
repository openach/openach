<?php
$params = array( 'parent_id' => $parent_id );
if ( isset( $originator_info_id ) )
{
	$params['originator_info_id'] = $originator_info_id;
}
?>
	<li class="list-footer-control" data-theme="<?= ( count( $items ) == 0 ) ? 'e' : 'a'; ?>" data-icon="plus">
		<a data-rel="dialog" href="<?= $this->createUrl( 'externalAccount/create', $params ); ?>">
			<h4><?= ( count( $items ) == 0 ) ? 'Next Step: ' : ''; ?>Add a Bank Account</h4>
		</a>
	</li>

