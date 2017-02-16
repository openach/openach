<div class="wide form">

<?php $form=$this->beginWidget('OAActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'payment_schedule_id'); ?>
		<?php echo $form->textField($model,'payment_schedule_id',array('size'=>36,'maxlength'=>36)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'payment_schedule_status'); ?>
		<?php echo $form->textField($model,'payment_schedule_status',array('size'=>9,'maxlength'=>9)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'payment_schedule_amount'); ?>
		<?php echo $form->textField($model,'payment_schedule_amount',array('size'=>19,'maxlength'=>19)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'payment_schedule_currency_code'); ?>
		<?php echo $form->textField($model,'payment_schedule_currency_code',array('size'=>3,'maxlength'=>3)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'payment_schedule_next_date'); ?>
		<?php echo $form->textField($model,'payment_schedule_next_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'payment_schedule_frequency'); ?>
		<?php echo $form->textField($model,'payment_schedule_frequency',array('size'=>7,'maxlength'=>7)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'payment_schedule_end_date'); ?>
		<?php echo $form->textField($model,'payment_schedule_end_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'payment_schedule_remaining_occurrences'); ?>
		<?php echo $form->textField($model,'payment_schedule_remaining_occurrences'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->
