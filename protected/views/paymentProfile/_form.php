<div class="form">

<?php $form=$this->beginWidget('OAActiveForm', array(
	'id'=>'payment-profile-form',
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'payment_profile_external_id'); ?>
		<?php echo $form->textField($model,'payment_profile_external_id',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'payment_profile_external_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'payment_profile_password'); ?>
		<?php echo $form->textField($model,'payment_profile_password',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'payment_profile_password'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'payment_profile_first_name'); ?>
		<?php echo $form->textField($model,'payment_profile_first_name',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'payment_profile_first_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'payment_profile_last_name'); ?>
		<?php echo $form->textField($model,'payment_profile_last_name',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'payment_profile_last_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'payment_profile_email_address'); ?>
		<?php echo $form->textField($model,'payment_profile_email_address',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'payment_profile_email_address'); ?>
	</div>

<? if ( ! $create ) : ?>

<div data-role="collapsible-set" data-theme="c" data-content-theme="a">
	<div data-role="collapsible">
		<h3><?php echo $model->getAttributeLabel('payment_profile_security_question_1'); ?></h3>
		<div class="row">
			<?php echo $form->labelEx($model,'payment_profile_security_question_1', array('label'=>'Question')); ?>
			<?php echo $form->textField($model,'payment_profile_security_question_1',array('size'=>60,'maxlength'=>255)); ?>
			<?php echo $form->error($model,'payment_profile_security_question_1'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'payment_profile_security_answer_1', array('label'=>'Answer')); ?>
			<?php echo $form->textField($model,'payment_profile_security_answer_1',array('size'=>60,'maxlength'=>255)); ?>
			<?php echo $form->error($model,'payment_profile_security_answer_1'); ?>
		</div>
	</div>
	<div data-role="collapsible">
		<h3><?php echo $model->getAttributeLabel('payment_profile_security_question_2'); ?></h3>
		<div class="row">
			<?php echo $form->labelEx($model,'payment_profile_security_question_2', array('label'=>'Question')); ?>
			<?php echo $form->textField($model,'payment_profile_security_question_2',array('size'=>60,'maxlength'=>255)); ?>
			<?php echo $form->error($model,'payment_profile_security_question_2'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'payment_profile_security_answer_2', array('label'=>'Answer')); ?>
			<?php echo $form->textField($model,'payment_profile_security_answer_2',array('size'=>60,'maxlength'=>255)); ?>
			<?php echo $form->error($model,'payment_profile_security_answer_2'); ?>
		</div>
	</div>
	<div data-role="collapsible">
		<h3><?php echo $model->getAttributeLabel('payment_profile_security_question_3'); ?></h3>
		<div class="row">
			<?php echo $form->labelEx($model,'payment_profile_security_question_3', array('label'=>'Question')); ?>
			<?php echo $form->textField($model,'payment_profile_security_question_3',array('size'=>60,'maxlength'=>255)); ?>
			<?php echo $form->error($model,'payment_profile_security_question_3'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'payment_profile_security_answer_3', array('label'=>'Answer')); ?>
			<?php echo $form->textField($model,'payment_profile_security_answer_3',array('size'=>60,'maxlength'=>255)); ?>
			<?php echo $form->error($model,'payment_profile_security_answer_3'); ?>
		</div>
	</div>
</div>
<? endif; ?>

	<div class="row">
		<?php echo $form->labelEx($model,'payment_profile_status'); ?>
		<?php echo $form->listBox($model,'payment_profile_status',array('enabled'=>'enabled','suspended'=>'suspended'),
				array( /*'data-theme'=>'d',*/ 'data-icon'=>'gear', 'data-inline'=>'true', 'data-native-menu'=>'false' )
			 ); ?>
		<?php echo $form->error($model,'payment_profile_status'); ?>
	</div>

	<div class="row">
		<?php echo $form->hiddenField($model,'payment_profile_originator_info_id',array('size'=>36,'maxlength'=>36)); ?>
		<?php echo $form->error($model,'payment_profile_originator_info_id'); ?>
	</div>


	<div class="row buttons">
		<fieldset class="ui-grid-a">
			<div class="ui-block-a"><?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array( 'data-theme'=>'b') ); ?></div>
			<div class="ui-block-b"><?php echo CHtml::link('Cancel', Yii::app()->createUrl( 'paymentProfile/view', array( 'id'=>$model->payment_profile_id ) ), array('data-role'=>'button', 'data-rel'=>'back')); ?></div>
		</fieldset>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
