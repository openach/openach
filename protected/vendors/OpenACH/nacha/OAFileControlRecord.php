<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

class OAFileControlRecord extends OAControlRecord
{
	const RECORD_TYPE_CODE = 9;

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
				new ODDataFieldName( 'ach_file_control_batch_count' ),
				new ODFieldRulePadLeft( 6, '0' ),
				new ODFieldRuleLength( 6 ),
			)
		);

		$this->addField(
			array(
				new ODDataFieldName( 'ach_file_control_block_count' ),
				new ODFieldRulePadLeft( 6, '0' ),
				new ODFieldRuleLength( 6 ),
			)
		);

		$this->addField(
			array(
				new ODDataFieldName( 'ach_file_control_entry_addenda_count' ),
				new ODFieldRulePadLeft( 8, '0' ),
				new ODFieldRuleLength( 8 ),
			)
		);

		$this->addField(
			array(
				new ODDataFieldName( 'ach_file_control_entry_hash' ),
				new ODFieldRulePadLeft( 10, '0' ),
				new ODFieldRuleLength( 10 ),
			)
		);

		$this->addField(
			array(
				new ODDataFieldName( 'ach_file_control_total_debits' ),
				new ODFieldRulePadLeft( 12, '0' ),
				new ODFieldRuleLength( 12 ),
			)
		);

		$this->addField(
			array(
				new ODDataFieldName( 'ach_file_control_total_credits' ),
				new ODFieldRulePadLeft( 12, '0' ),
				new ODFieldRuleLength( 12 ),
			)
		);

		$this->addField(
			array(
				new ODDataFieldName( 'reserved' ),
				new ODFieldRulePadLeft( 39, ' ' ),
				new ODFieldRuleLength( 39 ),
			)
		);

	}
}
