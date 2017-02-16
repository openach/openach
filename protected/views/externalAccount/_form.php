<div class="form">

<?php $form=$this->beginWidget('OAActiveForm', array(
	'id'=>'external-account-form',
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'external_account_name'); ?>
		<?php echo $form->textField($model,'external_account_name',array('size'=>60,'maxlength'=>125)); ?>
		<?php echo $form->error($model,'external_account_name'); ?>
	</div>

	<div class="row">
		<div class="routing-number-container">
			<?php echo $form->labelEx($model,'external_account_dfi_id'); ?>
			<?php echo $form->textField($model,'external_account_dfi_id',array('size'=>60,'maxlength'=>125)); ?>
			<div id="routing-number-bank-name"><?= ( strlen( $model->external_account_dfi_id ) == 9 && $model->external_account_bank ) ? $model->external_account_bank : ''; ?></div>
			<?php echo $form->error($model,'external_account_dfi_id'); ?>
		</div>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'external_account_dfi_id_qualifier'); ?>
		<?php echo $form->listBox($model,'external_account_dfi_id_qualifier',$model->getDfiIdQualifierOptions(),
				array( /*'data-theme'=>'d',*/ 'data-icon'=>'gear', 'data-inline'=>'true', 'data-native-menu'=>'false' )
			); ?>
		<?php echo $form->error($model,'external_account_dfi_id_qualifier'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'external_account_type'); ?>
		<?php echo $form->listBox($model,'external_account_type',array('checking'=>'checking','savings'=>'savings'),
				array( /*'data-theme'=>'d',*/ 'data-icon'=>'gear', 'data-inline'=>'true', 'data-native-menu'=>'false' )
			 ); ?>
		<?php echo $form->error($model,'external_account_type'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'external_account_business'); ?>
		<?php echo $form->checkBox($model,'external_account_business'); ?>
		<?php echo $form->error($model,'external_account_business'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'external_account_holder'); ?>
		<?php echo $form->textField($model,'external_account_holder',array('size'=>60,'maxlength'=>125)); ?>
		<?php echo $form->error($model,'external_account_holder'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'external_account_number'); ?>
		<?php echo $form->textField($model,'external_account_number',array('size'=>60,'maxlength'=>125)); ?>
		<?php echo $form->error($model,'external_account_number'); ?>
	</div>

	<div data-role="collapsible">
		<h3>Billing Address</h3>

		<div class="row">
			<?php echo $form->labelEx($model,'external_account_billing_address'); ?>
			<?php echo $form->textField($model,'external_account_billing_address',array('size'=>35,'maxlength'=>35)); ?>
			<?php echo $form->error($model,'external_account_billing_address'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'external_account_billing_city'); ?>
			<?php echo $form->textField($model,'external_account_billing_city',array('size'=>35,'maxlength'=>35)); ?>
			<?php echo $form->error($model,'external_account_billing_city'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'external_account_billing_state_province'); ?>
			<?php echo $form->textField($model,'external_account_billing_state_province',array('size'=>35,'maxlength'=>35)); ?>
			<?php echo $form->error($model,'external_account_billing_state_province'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'external_account_billing_postal_code'); ?>
			<?php echo $form->textField($model,'external_account_billing_postal_code',array('size'=>35,'maxlength'=>35)); ?>
			<?php echo $form->error($model,'external_account_billing_postal_code'); ?>
		</div>


		<div class="row">
			<?php echo $form->labelEx($model,'external_account_billing_country'); ?>
			<?php echo $form->listBox($model,'external_account_billing_country',$model->getCountryCodeOptions(),
					array( /*'data-theme'=>'d',*/ 'data-icon'=>'gear', 'data-inline'=>'true', 'data-native-menu'=>'false' )
				); ?>
			<?php echo $form->error($model,'external_account_billing_country'); ?>
		</div>

	</div>

	<div data-role="collapsible">
		<h3>Advanced</h3>
		<div class="row">
			<?php echo $form->labelEx($model,'external_account_bank'); ?>
			<?php echo $form->textField($model,'external_account_bank',array('size'=>60,'maxlength'=>125)); ?>
			<?php echo $form->error($model,'external_account_bank'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'external_account_country_code'); ?>
			<?php echo $form->listBox($model,'external_account_country_code',$model->getCountryCodeOptions(),
					array( /*'data-theme'=>'d',*/ 'data-icon'=>'gear', 'data-inline'=>'true', 'data-native-menu'=>'false' )
				); ?>
			<?php echo $form->error($model,'external_account_country_code'); ?>
		</div>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

	<?php echo $form->hiddenField($model,'external_account_id'); ?>
	<?php echo $form->hiddenField($model,'external_account_datetime'); ?>
	<?php echo $form->hiddenField($model,'external_account_payment_profile_id'); ?>
	<?php echo $form->hiddenField($model,'external_account_allow_originator_payments'); ?>
	<?php echo $form->hiddenField($model,'external_account_originator_info_id'); ?>

<?php $this->endWidget(); ?>

</div><!-- form -->
