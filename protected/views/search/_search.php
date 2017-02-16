<div class="search form">

<?= CHtml::beginForm(); ?>
	<div data-role="fieldcontain" class="ui-hide-label">
		<?= CHtml::label('Search','query'); ?>
		<?= OAHtml::searchField( 'query', $query, array( ) ); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search', array( 'data-mini' => 'true' ) ); ?>
	</div>
<?= CHtml::endForm(); ?>

</div><!-- search-form -->
