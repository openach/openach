<div class="form">

<?php $form=$this->beginWidget('OAActiveForm', array(
	'id'=>'originator-info-form',
));

if ( ! $model->originator_info_identification )
{
	$model->originator_info_identification = $model->originator->originator_identification;
}

 ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'originator_info_odfi_branch_id'); ?>
		<?php echo $form->listBox($model,'originator_info_odfi_branch_id',$model->originator->getOdfiBranchOptions(),
				array( /*'data-theme'=>'d',*/ 'data-icon'=>'gear', 'data-inline'=>'true', 'data-native-menu'=>'false' )
			); ?>
		<?php echo $form->error($model,'originator_info_odfi_branch_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'originator_info_name'); ?>
		<?php echo $form->textField($model,'originator_info_name',array('size'=>16,'maxlength'=>16)); ?>
		<?php echo $form->error($model,'originator_info_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'originator_info_description'); ?>
		<?php echo $form->textArea($model,'originator_info_description',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'originator_info_description'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'originator_info_identification'); ?>
		<?php echo $form->textField($model,'originator_info_identification',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'originator_info_identification'); ?>
	</div>

	<div data-role="collapsible">
		<h3>Address</h3>

		<div class="row">
			<?php echo $form->labelEx($model,'originator_info_address'); ?>
			<?php echo $form->textField($model,'originator_info_address',array('size'=>35,'maxlength'=>35)); ?>
			<?php echo $form->error($model,'originator_info_address'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'originator_info_city'); ?>
			<?php echo $form->textField($model,'originator_info_city',array('size'=>35,'maxlength'=>35)); ?>
			<?php echo $form->error($model,'originator_info_city'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'originator_info_state_province'); ?>
			<?php echo $form->textField($model,'originator_info_state_province',array('size'=>35,'maxlength'=>35)); ?>
			<?php echo $form->error($model,'originator_info_state_province'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'originator_info_postal_code'); ?>
			<?php echo $form->textField($model,'originator_info_postal_code',array('size'=>35,'maxlength'=>35)); ?>
			<?php echo $form->error($model,'originator_info_postal_code'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'originator_info_country_code'); ?>
			<?php echo $form->listBox($model,'originator_info_country_code',$model->getCountryCodeOptions(),
					array( /*'data-theme'=>'d',*/ 'data-icon'=>'gear', 'data-inline'=>'true', 'data-native-menu'=>'false' )
				); ?>
			<?php echo $form->error($model,'originator_info_country_code'); ?>
		</div>
	</div>

	<div class="row">
		<?php echo $form->hiddenField($model,'originator_info_originator_id',array('size'=>36,'maxlength'=>36)); ?>
		<?php echo $form->error($model,'originator_info_originator_id'); ?>
	</div>

	<div class="row buttons">
		<div class="ui-grid-a">
			<div class="ui-block-a"><?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('data-theme'=>'b') ); ?></div>
			<div class="ui-block-b"><?php echo CHtml::link('Cancel', Yii::app()->createUrl( 'originator/view', array( 'id'=>$model->originator->originator_id ) ), array('data-role'=>'button', 'data-rel'=>'back')); ?></div>
		</div>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
