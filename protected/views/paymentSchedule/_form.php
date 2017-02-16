<div class="form">

<?php $form=$this->beginWidget('OAActiveForm', array(
	'id'=>'payment-schedule-form',
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

<?php if ( ! $model->isNewRecord ) : ?>
	<div class="row">
		<?php echo $form->labelEx($model,'payment_schedule_status'); ?>
		<?php echo $form->listBox($model,'payment_schedule_status',$model->getStatusOptions(),
				array( /*'data-theme'=>'d',*/ 'data-icon'=>'gear', 'data-inline'=>'true', 'data-native-menu'=>'false' )
			); ?>
		<?php echo $form->error($model,'payment_schedule_status'); ?>
	</div>
<?php endif; ?>
<?php if ( $model->isNewRecord ) : ?>
	<div class="row">
		<?php echo $form->labelEx($model,'payment_schedule_payment_type_id'); ?>
		<?php echo $form->listBox($model,'payment_schedule_payment_type_id', $paymentProfile->originator_info->getPaymentTypeOptions(),
				array( /*'data-theme'=>'d',*/ 'data-icon'=>'gear', 'data-inline'=>'true', 'data-native-menu'=>'false' )
			 ); ?>
		<?php echo $form->error($model,'payment_schedule_payment_type_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'payment_schedule_external_account_id'); ?>
		<?php echo $form->listBox($model,'payment_schedule_external_account_id', $paymentProfile->getExternalAccountOptions(),
				array( /*'data-theme'=>'d',*/ 'data-icon'=>'gear', 'data-inline'=>'true', 'data-native-menu'=>'false' )
			 ); ?>
		<?php echo $form->error($model,'payment_schedule_external_account_id'); ?>
	</div>
<?php endif; ?>

	<div class="row">
		<?php echo $form->labelEx($model,'payment_schedule_amount'); ?>
		<?php echo $form->currencyField($model,'payment_schedule_amount',array('size'=>19,'maxlength'=>19)); ?>
		<?php echo $form->error($model,'payment_schedule_amount'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'payment_schedule_frequency'); ?>
		<?php echo $form->listBox($model,'payment_schedule_frequency',$model->getFrequencyOptions(),
				array( /*'data-theme'=>'d',*/ 'data-icon'=>'gear', 'data-inline'=>'true', 'encode'=>false, 'data-native-menu'=>'false',
					'data-role'=>'hidewhen', 'data-options'=>'{"hide":"#end_date_row","whenEqual":"once"}' )
			); ?>
		<?php echo $form->error($model,'payment_schedule_frequency'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'payment_schedule_next_date'); ?>
		<?php echo $form->dateField($model,'payment_schedule_next_date'); ?>
		<?php echo $form->error($model,'payment_schedule_next_date'); ?>
	</div>

	<div class="row" id="end_date_row" class="row_payment_schedule_end_date">
		<?php echo $form->labelEx($model,'payment_schedule_end_date'); ?>
		<?php echo $form->dateField($model,'payment_schedule_end_date'); ?>
		<?php echo $form->error($model,'payment_schedule_end_date'); ?>
	</div>


	<div class="row">
		<?php echo $form->labelEx($model,'payment_schedule_currency_code'); ?>
		<?php echo $form->listBox($model,'payment_schedule_currency_code',$model->getCurrencyCodeOptions(),
				array( /*'data-theme'=>'d',*/ 'data-icon'=>'gear', 'data-inline'=>'true', 'data-native-menu'=>'false' )
			); ?>
		<?php echo $form->error($model,'payment_schedule_currency_code'); ?>
	</div>

<?php if ( false ) : ?>
	<div class="row" >
		<?php echo $form->labelEx($model,'payment_schedule_remaining_occurrences'); ?>
		<?php echo $form->textField($model,'payment_schedule_remaining_occurrences'); ?>
		<?php echo $form->error($model,'payment_schedule_remaining_occurrences'); ?>
	</div>

<?php endif; ?>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
