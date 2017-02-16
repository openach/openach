<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('originator_info_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->originator_info_id), array('view', 'id'=>$data->originator_info_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('originator_info_datetime')); ?>:</b>
	<?php echo CHtml::encode($data->originator_info_datetime); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('originator_info_odfi_branch_id')); ?>:</b>
	<?php echo CHtml::encode($data->originator_info_odfi_branch_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('originator_info_originator_id')); ?>:</b>
	<?php echo CHtml::encode($data->originator_info_originator_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('originator_info_name')); ?>:</b>
	<?php echo CHtml::encode($data->originator_info_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('originator_info_description')); ?>:</b>
	<?php echo CHtml::encode($data->originator_info_description); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('originator_info_identification')); ?>:</b>
	<?php echo CHtml::encode($data->originator_info_identification); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('originator_info_address')); ?>:</b>
	<?php echo CHtml::encode($data->originator_info_address); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('originator_info_city')); ?>:</b>
	<?php echo CHtml::encode($data->originator_info_city); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('originator_info_state_province')); ?>:</b>
	<?php echo CHtml::encode($data->originator_info_state_province); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('originator_info_postal_code')); ?>:</b>
	<?php echo CHtml::encode($data->originator_info_postal_code); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('originator_info_country_code')); ?>:</b>
	<?php echo CHtml::encode($data->originator_info_country_code); ?>
	<br />

	*/ ?>

</div>