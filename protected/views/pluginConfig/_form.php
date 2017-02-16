<div class="form">

<?php $form=$this->beginWidget('OAActiveForm', array(
	'id'=>'plugin-config-form',
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo CHtml::label($model->plugin_config_key,'plugin_config_value'); ?>
		<?php //echo $form->textField($model,'plugin_config_value',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->textArea($model,'plugin_config_value',array('rows'=>5)); ?>
		<?php echo $form->error($model,'plugin_config_value'); ?>
	</div>

	<div class="row">
		<?php echo $form->hiddenField($model,'plugin_config_id',array('size'=>36,'maxlength'=>36)); ?>
		<?php echo $form->error($model,'plugin_config_id'); ?>
	</div>

	<div class="row buttons">
		<div class="ui-grid-a">
			<div class="ui-block-a"><?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('data-theme'=>'b') ); ?></div>
			<div class="ui-block-b"><?php echo CHtml::link('Cancel', Yii::app()->createUrl( $model->parentModel()->getViewPath() . '/view', array( 'id'=>$model->plugin_config_parent_id) ), array('data-role'=>'button', 'data-rel'=>'back')); ?></div>
		</div>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
