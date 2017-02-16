<div class="wide form">

<?php $form=$this->beginWidget('OAActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'external_account_id'); ?>
		<?php echo $form->textField($model,'external_account_id',array('size'=>36,'maxlength'=>36)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'external_account_datetime'); ?>
		<?php echo $form->textField($model,'external_account_datetime'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'external_account_payment_profile_id'); ?>
		<?php echo $form->textField($model,'external_account_payment_profile_id',array('size'=>36,'maxlength'=>36)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'external_account_type'); ?>
		<?php echo $form->textField($model,'external_account_type',array('size'=>8,'maxlength'=>8)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'external_account_name'); ?>
		<?php echo $form->textField($model,'external_account_name',array('size'=>60,'maxlength'=>125)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'external_account_bank'); ?>
		<?php echo $form->textField($model,'external_account_bank',array('size'=>60,'maxlength'=>125)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'external_account_holder'); ?>
		<?php echo $form->textField($model,'external_account_holder',array('size'=>60,'maxlength'=>125)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'external_account_country_code'); ?>
		<?php echo $form->textField($model,'external_account_country_code',array('size'=>2,'maxlength'=>2)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'external_account_dfi_id'); ?>
		<?php echo $form->textField($model,'external_account_dfi_id',array('size'=>60,'maxlength'=>125)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'external_account_dfi_id_qualifier'); ?>
		<?php echo $form->textField($model,'external_account_dfi_id_qualifier',array('size'=>2,'maxlength'=>2)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'external_account_number'); ?>
		<?php echo $form->textField($model,'external_account_number',array('size'=>60,'maxlength'=>125)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'external_account_billing_address'); ?>
		<?php echo $form->textField($model,'external_account_billing_address',array('size'=>35,'maxlength'=>35)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'external_account_billing_city'); ?>
		<?php echo $form->textField($model,'external_account_billing_city',array('size'=>35,'maxlength'=>35)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'external_account_billing_state_province'); ?>
		<?php echo $form->textField($model,'external_account_billing_state_province',array('size'=>35,'maxlength'=>35)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'external_account_billing_postal_code'); ?>
		<?php echo $form->textField($model,'external_account_billing_postal_code',array('size'=>35,'maxlength'=>35)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'external_account_billing_country'); ?>
		<?php echo $form->textField($model,'external_account_billing_country',array('size'=>2,'maxlength'=>2)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'external_account_business'); ?>
		<?php echo $form->textField($model,'external_account_business'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'external_account_verification_status'); ?>
		<?php echo $form->textField($model,'external_account_verification_status',array('size'=>9,'maxlength'=>9)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'external_account_status'); ?>
		<?php echo $form->textField($model,'external_account_status',array('size'=>7,'maxlength'=>7)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->
