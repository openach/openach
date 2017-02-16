<div class="wide form">

<?php $form=$this->beginWidget('OAActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'payment_profile_external_id'); ?>
		<?php echo $form->textField($model,'payment_profile_external_id',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'payment_profile_first_name'); ?>
		<?php echo $form->textField($model,'payment_profile_first_name',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'payment_profile_last_name'); ?>
		<?php echo $form->textField($model,'payment_profile_last_name',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'payment_profile_email_address'); ?>
		<?php echo $form->textField($model,'payment_profile_email_address',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'payment_profile_status'); ?>
		<?php echo $form->listBox($model,'payment_profile_status',array('enabled'=>'enabled','suspended'=>'suspended'),
				array( /*'data-theme'=>'d',*/ 'data-icon'=>'gear', 'data-inline'=>'true', 'data-native-menu'=>'false' )
			 ); ?>
		<?php echo $form->error($model,'payment_profile_status'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search', array('data-inline'=>'true','data-theme'=>'b')); ?>
		<?php echo CHtml::resetButton('Clear', array('data-inline'=>'true') ); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->
