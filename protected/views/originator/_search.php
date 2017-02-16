<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

?>
<div class="wide form">

<?php $form=$this->beginWidget('OAActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'originator_datetime'); ?>
		<?php echo $form->textField($model,'originator_datetime'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'originator_user_id'); ?>
		<?php echo $form->textField($model,'originator_user_id',array('size'=>36,'maxlength'=>36)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'originator_name'); ?>
		<?php echo $form->textField($model,'originator_name',array('size'=>35,'maxlength'=>35)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'originator_identification'); ?>
		<?php echo $form->textField($model,'originator_identification',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'originator_address'); ?>
		<?php echo $form->textField($model,'originator_address',array('size'=>35,'maxlength'=>35)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'originator_city'); ?>
		<?php echo $form->textField($model,'originator_city',array('size'=>35,'maxlength'=>35)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'originator_state_province'); ?>
		<?php echo $form->textField($model,'originator_state_province',array('size'=>35,'maxlength'=>35)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'originator_postal_code'); ?>
		<?php echo $form->textField($model,'originator_postal_code',array('size'=>35,'maxlength'=>35)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'originator_country_code'); ?>
		<?php echo $form->textField($model,'originator_country_code',array('size'=>2,'maxlength'=>2)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search', array('data-inline'=>'true','data-theme'=>'b')); ?>
		<?php echo CHtml::resetButton('Clear', array('data-inline'=>'true') ); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->
