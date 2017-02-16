<div class="form">

<?php $form=$this->beginWidget('OAActiveForm', array(
	'id'=>'odfi-branch-form',
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'odfi_branch_friendly_name'); ?>
		<?php echo $form->textField($model,'odfi_branch_friendly_name',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'odfi_branch_friendly_name'); ?>
	</div>

	<div class="row">
		<div class="routing-number-container">
			<?php echo $form->labelEx($model,'odfi_branch_dfi_id'); ?>
			<?php echo $form->textField($model,'odfi_branch_dfi_id',array('size'=>60,'maxlength'=>125)); ?>
			<div id="routing-number-bank-name"><?= ( strlen( $model->odfi_branch_dfi_id ) == 9 && $model->odfi_branch_name ) ? $model->odfi_branch_name : ''; ?></div>
		</div>
		<?php echo $form->error($model,'odfi_branch_dfi_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'odfi_branch_dfi_id_qualifier'); ?>
		<?php echo $form->listBox($model,'odfi_branch_dfi_id_qualifier',$model->getDfiIdQualifierOptions(),
				array( /*'data-theme'=>'d',*/ 'data-icon'=>'gear', 'data-inline'=>'true', 'data-native-menu'=>'false' )
			); ?>
		<?php echo $form->error($model,'odfi_branch_plugin'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'odfi_branch_plugin'); ?>
		<?php echo $form->listBox($model,'odfi_branch_plugin',$model->getBankPluginOptions(),
				array( /*'data-theme'=>'d',*/ 'data-icon'=>'gear', 'data-inline'=>'true', 'data-native-menu'=>'false' )
			); ?>
		<?php echo $form->error($model,'odfi_branch_plugin'); ?>
	</div>
<?php if ( ! $model->getIsNewRecord() ) : ?>
	<div class="row">
		<?php echo $form->labelEx($model,'odfi_branch_status'); ?>
		<?php echo $form->listBox($model,'odfi_branch_status',array('enabled'=>'enabled','disabled'=>'disabled'),
				array( /*'data-theme'=>'d',*/ 'data-icon'=>'gear', 'data-inline'=>'true', 'data-native-menu'=>'false' )
			 ); ?>
		<?php echo $form->error($model,'odfi_branch_status'); ?>
	</div>
<?php endif; ?>

	<div data-role="collapsible">
		<h3>Advanced</h3>
		<div class="row">
			<?php echo $form->labelEx($model,'odfi_branch_name'); ?>
			<?php echo $form->textField($model,'odfi_branch_name',array('size'=>35,'maxlength'=>35)); ?>
			<?php echo $form->error($model,'odfi_branch_name'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'odfi_branch_city'); ?>
			<?php echo $form->textField($model,'odfi_branch_city',array('size'=>35,'maxlength'=>35)); ?>
			<?php echo $form->error($model,'odfi_branch_city'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'odfi_branch_state_province'); ?>
			<?php echo $form->textField($model,'odfi_branch_state_province',array('size'=>35,'maxlength'=>35)); ?>
			<?php echo $form->error($model,'odfi_branch_state_province'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'odfi_branch_country_code'); ?>
			<?php echo $form->listBox($model,'odfi_branch_country_code',$model->getCountryCodeOptions(),
					array( /*'data-theme'=>'d',*/ 'data-icon'=>'gear', 'data-inline'=>'true', 'data-native-menu'=>'false' )
				); ?>
			<?php echo $form->error($model,'odfi_branch_country_code'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'odfi_branch_go_dfi_id'); ?>
			<?php echo $form->textField($model,'odfi_branch_go_dfi_id',array('size'=>9,'maxlength'=>9)); ?>
			<?php echo $form->error($model,'odfi_branch_go_dfi_id'); ?>
		</div>
	</div>

	<div class="row">
		<?php echo $form->hiddenField($model,'odfi_branch_originator_id',array('size'=>36,'maxlength'=>36)); ?>
		<?php echo $form->error($model,'odfi_branch_originator_id'); ?>
	</div>

	<div class="row buttons">
		<div class="ui-grid-a">
			<div class="ui-block-a"><?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('data-theme'=>'b') ); ?></div>
			<div class="ui-block-b"><?php echo CHtml::link('Cancel', Yii::app()->createUrl( 'originator/view', array( 'id'=>$model->odfi_branch_originator_id) ), array('data-role'=>'button', 'data-rel'=>'back')); ?></div>
		</div>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
