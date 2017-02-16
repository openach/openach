<div class="wide form">

<?php $form=$this->beginWidget('OAActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'originator_info_id'); ?>
		<?php echo $form->textField($model,'originator_info_id',array('size'=>36,'maxlength'=>36)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'originator_info_datetime'); ?>
		<?php echo $form->textField($model,'originator_info_datetime'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'originator_info_odfi_branch_id'); ?>
		<?php echo $form->textField($model,'originator_info_odfi_branch_id',array('size'=>36,'maxlength'=>36)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'originator_info_originator_id'); ?>
		<?php echo $form->textField($model,'originator_info_originator_id',array('size'=>36,'maxlength'=>36)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'originator_info_name'); ?>
		<?php echo $form->textField($model,'originator_info_name',array('size'=>16,'maxlength'=>16)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'originator_info_description'); ?>
		<?php echo $form->textArea($model,'originator_info_description',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'originator_info_identification'); ?>
		<?php echo $form->textField($model,'originator_info_identification',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'originator_info_address'); ?>
		<?php echo $form->textField($model,'originator_info_address',array('size'=>35,'maxlength'=>35)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'originator_info_city'); ?>
		<?php echo $form->textField($model,'originator_info_city',array('size'=>35,'maxlength'=>35)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'originator_info_state_province'); ?>
		<?php echo $form->textField($model,'originator_info_state_province',array('size'=>35,'maxlength'=>35)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'originator_info_postal_code'); ?>
		<?php echo $form->textField($model,'originator_info_postal_code',array('size'=>35,'maxlength'=>35)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'originator_info_country_code'); ?>
		<?php echo $form->textField($model,'originator_info_country_code',array('size'=>2,'maxlength'=>2)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->
