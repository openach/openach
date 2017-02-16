<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

?>
<div class="form">

<?php $form=$this->beginWidget('OAActiveForm', array(
	'id'=>'user-form',
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'user_login'); ?>
		<?php echo $form->textField($model,'user_login',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'user_login'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'user_password'); ?>
		<?php echo $form->passwordField($model,'user_password',array('size'=>32,'maxlength'=>32)); ?>
		<?php echo $form->error($model,'user_password'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'user_password_confirm'); ?>
		<?php echo $form->passwordField($model,'user_password_confirm',array('size'=>32,'maxlength'=>32)); ?>
		<?php echo $form->error($model,'user_password_confirm'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'user_first_name'); ?>
		<?php echo $form->textField($model,'user_first_name',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'user_first_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'user_last_name'); ?>
		<?php echo $form->textField($model,'user_last_name',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'user_last_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'user_email_address'); ?>
		<?php echo $form->textField($model,'user_email_address',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'user_email_address'); ?>
	</div>
<? if ( ! $create ) : ?>

<div data-role="collapsible-set" data-theme="c" data-content-theme="a">
	<div data-role="collapsible">
		<h3><?php echo $model->getAttributeLabel('user_security_question_1'); ?></h3>
		<div class="row">
			<?php echo $form->labelEx($model,'user_security_question_1', array('label'=>'Question')); ?>
			<?php echo $form->textField($model,'user_security_question_1',array('size'=>60,'maxlength'=>255)); ?>
			<?php echo $form->error($model,'user_security_question_1'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'user_security_answer_1', array('label'=>'Answer')); ?>
			<?php echo $form->textField($model,'user_security_answer_1',array('size'=>60,'maxlength'=>255)); ?>
			<?php echo $form->error($model,'user_security_answer_1'); ?>
		</div>
	</div>
	<div data-role="collapsible">
		<h3><?php echo $model->getAttributeLabel('user_security_question_2'); ?></h3>
		<div class="row">
			<?php echo $form->labelEx($model,'user_security_question_2', array('label'=>'Question')); ?>
			<?php echo $form->textField($model,'user_security_question_2',array('size'=>60,'maxlength'=>255)); ?>
			<?php echo $form->error($model,'user_security_question_2'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'user_security_answer_2', array('label'=>'Answer')); ?>
			<?php echo $form->textField($model,'user_security_answer_2',array('size'=>60,'maxlength'=>255)); ?>
			<?php echo $form->error($model,'user_security_answer_2'); ?>
		</div>
	</div>
	<div data-role="collapsible">
		<h3><?php echo $model->getAttributeLabel('user_security_question_3'); ?></h3>
		<div class="row">
			<?php echo $form->labelEx($model,'user_security_question_3', array('label'=>'Question')); ?>
			<?php echo $form->textField($model,'user_security_question_3',array('size'=>60,'maxlength'=>255)); ?>
			<?php echo $form->error($model,'user_security_question_3'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'user_security_answer_3', array('label'=>'Answer')); ?>
			<?php echo $form->textField($model,'user_security_answer_3',array('size'=>60,'maxlength'=>255)); ?>
			<?php echo $form->error($model,'user_security_answer_3'); ?>
		</div>
	</div>
</div>
<? endif; ?>

	<div class="row">
		<?php echo $form->labelEx($model,'user_status'); ?>
		<?php echo $form->listBox($model,'user_status',array('enabled'=>'enabled','suspended'=>'suspended'),
				array( /*'data-theme'=>'d',*/ 'data-icon'=>'gear', 'data-inline'=>'true', 'data-native-menu'=>'false' )
			 ); ?>
		<?php echo $form->error($model,'user_status'); ?>
	</div>

	<div class="row buttons">
		<div class="ui-grid-a">
			<div class="ui-block-a"><?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array( 'data-theme'=>'b') ); ?></div>
			<div class="ui-block-b"><?php echo CHtml::link('Cancel', Yii::app()->createUrl( 'user/view', array( 'id'=>$model->user_id ) ), array('data-role'=>'button', 'data-rel'=>'back')); ?></div>
		</div>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
