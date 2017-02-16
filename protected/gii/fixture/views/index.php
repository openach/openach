<?php
$class=get_class($model);
Yii::app()->clientScript->registerScript('gii.model',"
$('#{$class}_modelClass').change(function(){
	$(this).data('changed',$(this).val()!='');
});
$('#{$class}_tableName').bind('keyup change', function(){
	var model=$('#{$class}_modelClass');
	var tableName=$(this).val();
	if(tableName.substring(tableName.length-1)!='*') {
		$('.form .row.model-class').show();
	}
	else {
		$('#{$class}_modelClass').val('');
		$('.form .row.model-class').hide();
	}
	if(!model.data('changed')) {
		var i=tableName.lastIndexOf('.');
		if(i>=0)
			tableName=tableName.substring(i+1);
		var tablePrefix=$('#{$class}_tablePrefix').val();
		if(tablePrefix!='' && tableName.indexOf(tablePrefix)==0)
			tableName=tableName.substring(tablePrefix.length);
		var modelClass='';
		$.each(tableName.split('_'), function() {
			if(this.length>0)
				modelClass+=this.substring(0,1).toUpperCase()+this.substring(1);
		});
		model.val(modelClass);
	}
});
$('.form .row.model-class').toggle($('#{$class}_tableName').val().substring($('#{$class}_tableName').val().length-1)!='*');
");
?>
<h1>Fixture Generator</h1>

<p>This generator generates a fixtures for the specified database table.</p>

<?php $form=$this->beginWidget('CCodeForm', array('model'=>$model)); ?>

	<div class="row">
		<?php 
			echo $form->labelEx($model,'modelPath');
			echo $form->textField($model,'modelPath', array('size'=>65)); 
		?>
		<div class="tooltip">
		This refers to the table name that a new model class should be generated for
		(e.g. <code>tbl_user</code>). It can contain schema name, if needed (e.g. <code>public.tbl_post</code>).
		You may also enter <code>*</code> (or <code>schemaName.*</code> for a particular DB schema)
		to generate a model class for EVERY table.
		</div>
		<?php echo $form->error($model,'modelPath'); ?>
	</div> 
	<div class="row">
		<?php 
			echo $form->labelEx($model,'rowsLimit'); 
			echo $form->dropDownList($model,'rowsLimit',array(
						''   => 'All',
						'10' => '10' ,
						'20' => '20' ,
						'30' => '30' ,
						'40' => '40' ,
						'50' => '50' ,
						'60' => '30' ,
						'70' => '70' ,
						'80' => '80' ,
			)); 
		?>
		<div class="tooltip">
			Generate <b>n</b> or <b>all</b> rows.
		</div>
		<?php echo $form->error($model,'modelPath'); ?>
	</div> 
	<div class="row sticky">
		<?php echo $form->labelEx($model,'fixturePath'); ?>
		<?php echo $form->textField($model,'fixturePath', array('size'=>65)); ?>
		<div class="tooltip">
			This refers to the directory that the new model class file should be generated under.
			It should be specified in the form of a path alias, for example, <code>application.models</code>.
		</div>
		<?php echo $form->error($model,'fixturePath'); ?>
	</div>

<?php $this->endWidget(); 