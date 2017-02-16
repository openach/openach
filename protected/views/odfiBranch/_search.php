<div class="wide form">

<?php $form=$this->beginWidget('OAActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'odfi_branch_id'); ?>
		<?php echo $form->textField($model,'odfi_branch_id',array('size'=>36,'maxlength'=>36)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'odfi_branch_datetime'); ?>
		<?php echo $form->textField($model,'odfi_branch_datetime'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'odfi_branch_originator_id'); ?>
		<?php echo $form->textField($model,'odfi_branch_originator_id',array('size'=>36,'maxlength'=>36)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'odfi_branch_friendly_name'); ?>
		<?php echo $form->textField($model,'odfi_branch_friendly_name',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'odfi_branch_name'); ?>
		<?php echo $form->textField($model,'odfi_branch_name',array('size'=>35,'maxlength'=>35)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'odfi_branch_city'); ?>
		<?php echo $form->textField($model,'odfi_branch_city',array('size'=>35,'maxlength'=>35)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'odfi_branch_state_province'); ?>
		<?php echo $form->textField($model,'odfi_branch_state_province',array('size'=>35,'maxlength'=>35)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'odfi_branch_country_code'); ?>
		<?php echo $form->textField($model,'odfi_branch_country_code',array('size'=>2,'maxlength'=>2)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'odfi_branch_dfi_id'); ?>
		<?php echo $form->textField($model,'odfi_branch_dfi_id',array('size'=>60,'maxlength'=>125)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'odfi_branch_dfi_id_qualifier'); ?>
		<?php echo $form->textField($model,'odfi_branch_dfi_id_qualifier',array('size'=>2,'maxlength'=>2)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'odfi_branch_go_dfi_id'); ?>
		<?php echo $form->textField($model,'odfi_branch_go_dfi_id',array('size'=>9,'maxlength'=>9)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'odfi_branch_status'); ?>
		<?php echo $form->textField($model,'odfi_branch_status',array('size'=>8,'maxlength'=>8)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'odfi_branch_plugin'); ?>
		<?php echo $form->textField($model,'odfi_branch_plugin',array('size'=>36,'maxlength'=>36)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->
