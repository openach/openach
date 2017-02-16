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
		<?php echo $form->label($model,'user_login'); ?>
		<?php echo $form->textField($model,'user_login',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'user_first_name'); ?>
		<?php echo $form->textField($model,'user_first_name',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'user_last_name'); ?>
		<?php echo $form->textField($model,'user_last_name',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'user_email_address'); ?>
		<?php echo $form->textField($model,'user_email_address',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'user_status'); ?>
		<?php echo $form->textField($model,'user_status',array('size'=>9,'maxlength'=>9)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search', array('data-inline'=>'true','data-theme'=>'b')); ?>
		<?php echo CHtml::resetButton('Clear', array('data-inline'=>'true') ); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->
