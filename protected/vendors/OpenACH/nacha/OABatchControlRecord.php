<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

class OABatchControlRecord extends OAControlRecord
{
	const RECORD_TYPE_CODE = 8;

	protected function initRecordFields()
	{
		$this->addField(
			array(
				new ODDataFieldName( 'ach_record_type_code' ),
				new ODStaticFieldValueEnforced( self::RECORD_TYPE_CODE ),
				new ODFieldRuleEnforceNumeric(),
				new ODFieldRuleLength( 1 ),
			)
		);

		$this->addField(
			array(
				new ODDataFieldName( 'ach_batch_header_service_class_code' ),
				new ODFieldRuleEnforceNumeric(),
				new ODFieldRulePadLeft( 3, ' ' ),
				new ODFieldRuleLength( 3 ),
			)
		);

		$this->addField(
			array(
				new ODDataFieldName( 'ach_batch_control_entry_addenda_count' ),
				new ODFieldRulePadLeft( 6, '0' ),
				new ODFieldRuleLength( 6 ),
			)
		);

		$this->addField(
			array(
				new ODDataFieldName( 'ach_batch_control_entry_hash' ),
				new ODFieldRulePadLeft( 10, '0' ),
				new ODFieldRuleLength( 10 ),
			)
		);

		$this->addField(
			array(
				new ODDataFieldName( 'ach_batch_control_total_debits' ),
				new ODFieldRulePadLeft( 12, '0' ),
				new ODFieldRuleLength( 12 ),
			)
		);

		$this->addField(
			array(
				new ODDataFieldName( 'ach_batch_control_total_credits' ),
				new ODFieldRulePadLeft( 12, '0' ),
				new ODFieldRuleLength( 12 ),
			)
		);

		$this->addField(
			array(
				new ODDataFieldName( 'ach_batch_header_company_identification' ),
				new ODFieldRulePadLeft( 10, ' ' ),
				new ODFieldRuleLength( 10 ),
			)
		);

		$this->addField(
			array(
				new ODDataFieldName( 'ach_batch_control_message_authentication_code' ),
				new ODFieldRulePadLeft( 19, ' ' ),
				new ODFieldRuleLength( 19 ),
			)
		);

		$this->addField(
			array(
				new ODDataFieldName( 'reserved' ),
				new ODFieldRulePadLeft( 6, ' ' ),
				new ODFieldRuleLength( 6 ),
			)
		);

		$this->addField(
			array(
				new ODDataFieldName( 'ach_batch_header_originating_dfi_id' ),
				new ODFieldRulePadLeft( 8, ' ' ),
				new ODFieldRuleLength( 8 ),
			)
		);

		$this->addField(
			array(
				new ODDataFieldName( 'ach_batch_header_batch_number' ),
				new ODFieldRulePadLeft( 7, '0' ),
				new ODFieldRuleLength( 7 ),
			)
		);

	}
}

