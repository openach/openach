<div class="form">

<?php $form=$this->beginWidget('OAActiveForm', array(
	'id'=>'payment-type-form',
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'payment_type_name'); ?>
		<?php echo $form->textField($model,'payment_type_name',array('size'=>50,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'payment_type_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'payment_type_description'); ?>
		<?php echo $form->textArea($model,'payment_type_description',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'payment_type_description'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'payment_type_transaction_type'); ?>
		<?php echo $form->listBox($model,'payment_type_transaction_type', $model->getTransactionTypeOptions(),
				array( /*'data-theme'=>'d',*/ 'data-icon'=>'gear', 'data-inline'=>'true', 'data-native-menu'=>'false' )
			 ); ?>
		<?php echo $form->error($model,'payment_type_transaction_type'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'payment_type_external_account_id'); ?>
		<?php echo $form->listBox($model,'payment_type_external_account_id', $model->originator_info->getExternalAccountOptions(),
				array( /*'data-theme'=>'d',*/ 'data-icon'=>'gear', 'data-inline'=>'true', 'data-native-menu'=>'false' )
			 ); ?>
		<?php echo $form->error($model,'payment_type_external_account_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'payment_type_status'); ?>
		<?php echo $form->listBox($model,'payment_type_status', $model->getStatusOptions(),
				array( /*'data-theme'=>'d',*/ 'data-icon'=>'gear', 'data-inline'=>'true', 'data-native-menu'=>'false' )
			 ); ?>
		<?php echo $form->error($model,'payment_type_status'); ?>
	</div>

	<div class="row">
		<?php echo $form->hiddenField($model,'payment_type_originator_info_id',array('size'=>36,'maxlength'=>36)); ?>
		<?php echo $form->error($model,'payment_type_originator_info_id'); ?>
	</div>


	<div class="row buttons">
		<fieldset class="ui-grid-a">
			<div class="ui-block-a"><?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array( 'data-theme'=>'b') ); ?></div>
			<div class="ui-block-b"><?php echo CHtml::link('Cancel', Yii::app()->createUrl( 'paymentType/view', array( 'id'=>$model->payment_type_id ) ), array('data-role'=>'button', 'data-rel'=>'back')); ?></div>
		</fieldset>
	</div>

	<?php echo CHtml::hiddenField('parent_id', $model->payment_type_originator_info_id); ?>

<?php $this->endWidget(); ?>

</div><!-- form -->
