<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/


class OAIATFirstAddendaRecord extends OAIATAddendaRecord
{
	const ADDENDA_TYPE_CODE = '10';

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
				new ODDataFieldName( 'ach_addenda_type_code' ),
				new ODStaticFieldValueEnforced( self::ADDENDA_TYPE_CODE ),
				new ODFieldRuleEnforceNumeric(),
				new ODFieldRuleLength( 2 ),
			)
		);

		$this->addField(
			array(
				new ODDataFieldName( 'ach_entry_iat_transaction_type_code' ),
				new ODFieldRulePadLeft( 3, ' ' ),
				new ODFieldRuleLength( 3 ),
			)
		);

		$this->addField(
			array(
				new ODDataFieldName( 'ach_entry_iat_foreign_payment_amount' ),
				new ODFieldRulePadLeft( 18, ' ' ),
				new ODFieldRuleLength( 18 ),
			)
		);

		$this->addField(
			array(
				new ODDataFieldName( 'ach_entry_iat_foreign_trace_number' ),
				new ODFieldRulePadLeft( 22, ' ' ),
				new ODFieldRuleLength( 22 ),
			)
		);

		$this->addField(
			array(
				new ODDataFieldName( 'ach_entry_detail_individual_name' ),
				new ODFieldRulePadRight( 35, ' ' ),
				new ODFieldRuleLength( 35 ),
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
				new ODDataFieldName( 'ach_entry_detail_sequence_number' ),
				new ODFieldRuleEnforceNumeric(),
				new ODFieldRulePadLeft( 7, '0' ),
				new ODFieldRuleLength( 7 ),
			)
		);

	}
}


