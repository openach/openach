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
		<?php echo $form->label($model,'role_name'); ?>
		<?php echo $form->textField($model,'role_name',array('size'=>16,'maxlength'=>16)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'role_description'); ?>
		<?php echo $form->textArea($model,'role_description',array('rows'=>6, 'cols'=>50)); ?>
	</div>
<!--
	<div class="row">
		<?php echo $form->label($model,'role_max_originator'); ?>
		<?php echo $form->textField($model,'role_max_originator'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'role_max_odfi'); ?>
		<?php echo $form->textField($model,'role_max_odfi'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'role_max_daily_xfers'); ?>
		<?php echo $form->textField($model,'role_max_daily_xfers'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'role_max_daily_files'); ?>
		<?php echo $form->textField($model,'role_max_daily_files'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'role_max_daily_batches'); ?>
		<?php echo $form->textField($model,'role_max_daily_batches'); ?>
	</div>
-->
	<div class="row">
		<?php echo $form->label($model,'role_iat_enabled'); ?>
		<?php echo $form->checkBox($model,'role_iat_enabled'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search', array('data-inline'=>'true','data-theme'=>'b')); ?>
		<?php echo CHtml::resetButton('Clear', array('data-inline'=>'true') ); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->
