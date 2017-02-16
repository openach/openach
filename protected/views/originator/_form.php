<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/
?>
<div class="form">

<?php $form=$this->beginWidget('OAActiveForm', array(
	'id'=>'originator-form',
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
<?php if ( Yii::app()->user->model()->hasRole( 'administrator' ) && $model->getIsNewRecord() ):

	$userLogin = '';
	if ( ! $model->originator_user_id )
	{
		$userModel = User::model()->findByPk( $model->originator_user_id );
		if ( $userModel )
		{
			$userLogin = $userModel->user_login;
		}
	}

 ?>
	<div class="row">
<?php 
	// If the user is an administrator and there is no originator_user_id set, then show the form fields for manual user entry
	$currentUser = Yii::app()->user->model();
	if ( $currentUser->hasRole('administrator') && ! $model->originator_user_id ) :
?>
		<?php echo $form->labelEx($model,'originator_user_id'); ?>
		<?php echo CHtml::textField('user_login', $userLogin ); ?>
<?php 
	endif;
?>
		<?php echo $form->hiddenField($model,'originator_user_id',array('size'=>36,'maxlength'=>36)); ?>
		<?php echo $form->error($model,'originator_user_id'); ?>
	</div>
<?php endif; ?>

	<div class="row">
		<?php echo $form->labelEx($model,'originator_name'); ?>
		<?php echo $form->textField($model,'originator_name',array('size'=>35,'maxlength'=>35)); ?>
		<?php echo $form->error($model,'originator_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'originator_identification'); ?>
		<?php echo $form->textField($model,'originator_identification',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'originator_identification'); ?>
	</div>

	<div data-role="collapsible">
		<h3>Address</h3>
		<div class="row">
			<?php echo $form->labelEx($model,'originator_address'); ?>
			<?php echo $form->textField($model,'originator_address',array('size'=>35,'maxlength'=>35)); ?>
			<?php echo $form->error($model,'originator_address'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'originator_city'); ?>
			<?php echo $form->textField($model,'originator_city',array('size'=>35,'maxlength'=>35)); ?>
			<?php echo $form->error($model,'originator_city'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'originator_state_province'); ?>
			<?php echo $form->textField($model,'originator_state_province',array('size'=>35,'maxlength'=>35)); ?>
			<?php echo $form->error($model,'originator_state_province'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'originator_postal_code'); ?>
			<?php echo $form->textField($model,'originator_postal_code',array('size'=>35,'maxlength'=>35)); ?>
			<?php echo $form->error($model,'originator_postal_code'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'originator_country_code'); ?>
			<?php echo $form->listBox($model,'originator_country_code',$model->getCountryCodeOptions(),
					array( /*'data-theme'=>'d',*/ 'data-icon'=>'gear', 'data-inline'=>'true', 'data-native-menu'=>'false' )
				); ?>
			<?php echo $form->error($model,'originator_country_code'); ?>
		</div>

	</div>
	<div class="row buttons">
		<div class="ui-grid-a">
			<div class="ui-block-a"><?php echo OAHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('data-theme'=>'b') ); ?></div>
			<div class="ui-block-b"><?php echo OAHtml::link('Cancel', Yii::app()->createUrl( 'originator/view', array( 'id'=>$model->originator_id ) ), array('data-role'=>'button', 'data-rel'=>'back')); ?></div>
		</div>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
