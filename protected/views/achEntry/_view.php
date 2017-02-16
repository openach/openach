<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('ach_entry_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->ach_entry_id), array('view', 'id'=>$data->ach_entry_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ach_entry_datetime')); ?>:</b>
	<?php echo CHtml::encode($data->ach_entry_datetime); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ach_entry_status')); ?>:</b>
	<?php echo CHtml::encode($data->ach_entry_status); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ach_entry_ach_batch_id')); ?>:</b>
	<?php echo CHtml::encode($data->ach_entry_ach_batch_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ach_entry_odfi_branch_id')); ?>:</b>
	<?php echo CHtml::encode($data->ach_entry_odfi_branch_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ach_entry_external_account_id')); ?>:</b>
	<?php echo CHtml::encode($data->ach_entry_external_account_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ach_entry_detail_transaction_code')); ?>:</b>
	<?php echo CHtml::encode($data->ach_entry_detail_transaction_code); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('ach_entry_detail_receiving_dfi_id')); ?>:</b>
	<?php echo CHtml::encode($data->ach_entry_detail_receiving_dfi_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ach_entry_detail_receiving_dfi_id_check_digit')); ?>:</b>
	<?php echo CHtml::encode($data->ach_entry_detail_receiving_dfi_id_check_digit); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ach_entry_detail_dfi_account_number')); ?>:</b>
	<?php echo CHtml::encode($data->ach_entry_detail_dfi_account_number); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ach_entry_detail_amount')); ?>:</b>
	<?php echo CHtml::encode($data->ach_entry_detail_amount); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ach_entry_detail_individual_id_number')); ?>:</b>
	<?php echo CHtml::encode($data->ach_entry_detail_individual_id_number); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ach_entry_detail_individual_name')); ?>:</b>
	<?php echo CHtml::encode($data->ach_entry_detail_individual_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ach_entry_detail_discretionary_data')); ?>:</b>
	<?php echo CHtml::encode($data->ach_entry_detail_discretionary_data); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ach_entry_detail_addenda_record_indicator')); ?>:</b>
	<?php echo CHtml::encode($data->ach_entry_detail_addenda_record_indicator); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ach_entry_detail_trace_number')); ?>:</b>
	<?php echo CHtml::encode($data->ach_entry_detail_trace_number); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ach_entry_addenda_type_code')); ?>:</b>
	<?php echo CHtml::encode($data->ach_entry_addenda_type_code); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ach_entry_addenda_payment_info')); ?>:</b>
	<?php echo CHtml::encode($data->ach_entry_addenda_payment_info); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ach_entry_iat_go_receiving_dfi_id')); ?>:</b>
	<?php echo CHtml::encode($data->ach_entry_iat_go_receiving_dfi_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ach_entry_iat_go_receiving_dfi_id_check_digit')); ?>:</b>
	<?php echo CHtml::encode($data->ach_entry_iat_go_receiving_dfi_id_check_digit); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ach_entry_iat_ofac_screening_indicator')); ?>:</b>
	<?php echo CHtml::encode($data->ach_entry_iat_ofac_screening_indicator); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ach_entry_iat_secondary_ofac_screening_indicator')); ?>:</b>
	<?php echo CHtml::encode($data->ach_entry_iat_secondary_ofac_screening_indicator); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ach_entry_iat_transaction_type_code')); ?>:</b>
	<?php echo CHtml::encode($data->ach_entry_iat_transaction_type_code); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ach_entry_iat_foreign_trace_number')); ?>:</b>
	<?php echo CHtml::encode($data->ach_entry_iat_foreign_trace_number); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ach_entry_iat_originator_name')); ?>:</b>
	<?php echo CHtml::encode($data->ach_entry_iat_originator_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ach_entry_iat_originator_street_addr')); ?>:</b>
	<?php echo CHtml::encode($data->ach_entry_iat_originator_street_addr); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ach_entry_iat_originator_city')); ?>:</b>
	<?php echo CHtml::encode($data->ach_entry_iat_originator_city); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ach_entry_iat_originator_state_province')); ?>:</b>
	<?php echo CHtml::encode($data->ach_entry_iat_originator_state_province); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ach_entry_iat_originator_postal_code')); ?>:</b>
	<?php echo CHtml::encode($data->ach_entry_iat_originator_postal_code); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ach_entry_iat_originator_country')); ?>:</b>
	<?php echo CHtml::encode($data->ach_entry_iat_originator_country); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ach_entry_iat_originating_dfi_name')); ?>:</b>
	<?php echo CHtml::encode($data->ach_entry_iat_originating_dfi_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ach_entry_iat_originating_dfi_id')); ?>:</b>
	<?php echo CHtml::encode($data->ach_entry_iat_originating_dfi_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ach_entry_iat_originating_dfi_id_qualifier')); ?>:</b>
	<?php echo CHtml::encode($data->ach_entry_iat_originating_dfi_id_qualifier); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ach_entry_iat_originating_dfi_country_code')); ?>:</b>
	<?php echo CHtml::encode($data->ach_entry_iat_originating_dfi_country_code); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ach_entry_iat_receiving_dfi_name')); ?>:</b>
	<?php echo CHtml::encode($data->ach_entry_iat_receiving_dfi_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ach_entry_iat_receiving_dfi_id')); ?>:</b>
	<?php echo CHtml::encode($data->ach_entry_iat_receiving_dfi_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ach_entry_iat_receiving_dfi_id_qualifier')); ?>:</b>
	<?php echo CHtml::encode($data->ach_entry_iat_receiving_dfi_id_qualifier); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ach_entry_iat_receiving_dfi_country_code')); ?>:</b>
	<?php echo CHtml::encode($data->ach_entry_iat_receiving_dfi_country_code); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ach_entry_iat_receiver_street_addr')); ?>:</b>
	<?php echo CHtml::encode($data->ach_entry_iat_receiver_street_addr); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ach_entry_iat_receiver_city')); ?>:</b>
	<?php echo CHtml::encode($data->ach_entry_iat_receiver_city); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ach_entry_iat_receiver_state_province')); ?>:</b>
	<?php echo CHtml::encode($data->ach_entry_iat_receiver_state_province); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ach_entry_iat_receiver_postal_code')); ?>:</b>
	<?php echo CHtml::encode($data->ach_entry_iat_receiver_postal_code); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ach_entry_iat_receiver_country')); ?>:</b>
	<?php echo CHtml::encode($data->ach_entry_iat_receiver_country); ?>
	<br />

	*/ ?>

</div>