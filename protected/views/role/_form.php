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
	'id'=>'role-form',
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'role_name'); ?>
		<?php echo $form->textField($model,'role_name',array('size'=>16,'maxlength'=>16)); ?>
		<?php echo $form->error($model,'role_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'role_description'); ?>
		<?php echo $form->textArea($model,'role_description',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'role_description'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'role_max_originator'); ?>
		<?php echo $form->rangeField($model,'role_max_originator'); ?>
		<?php echo $form->error($model,'role_max_originator'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'role_max_odfi'); ?>
		<?php echo $form->rangeField($model,'role_max_odfi'); ?>
		<?php echo $form->error($model,'role_max_odfi'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'role_max_daily_xfers'); ?>
		<?php echo $form->rangeField($model,'role_max_daily_xfers'); ?>
		<?php echo $form->error($model,'role_max_daily_xfers'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'role_max_daily_files'); ?>
		<?php echo $form->rangeField($model,'role_max_daily_files'); ?>
		<?php echo $form->error($model,'role_max_daily_files'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'role_max_daily_batches'); ?>
		<?php echo $form->rangeField($model,'role_max_daily_batches'); ?>
		<?php echo $form->error($model,'role_max_daily_batches'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'role_iat_enabled'); ?>
		<?php echo $form->checkBox($model,'role_iat_enabled'); ?>
		<?php echo $form->error($model,'role_iat_enabled'); ?>
	</div>

	<div class="row buttons">
		<div class="ui-grid-a">
			<div class="ui-block-a"><?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('data-theme'=>'b') ); ?></div>
			<div class="ui-block-b"><?php echo CHtml::link('Cancel', Yii::app()->createUrl( 'role/view', array( 'id'=>$model->role_id ) ), array('data-role'=>'button', 'data-rel'=>'back')); ?></div>
		</div>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
