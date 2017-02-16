<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license * online at http://openach.com/community/license.txt
 ********************************************************************************/


abstract class OAReturnAddendaRecord extends OAAddendaRecord
{
	const ADDENDA_TYPE_CODE = '99';
	
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
				new ODDataFieldName( 'ach_entry_return_return_reason_code' ),
				new ODFieldRuleLength( 3 ),
			)
		);

		$this->addField(
			array(
				new ODDataFieldName( 'ach_entry_return_reassigned_trace_number' ),
				new ODFieldRuleEnforceNumeric(),
				new ODFieldRulePadLeft( 15, '0' ),
				new ODFieldRuleLength( 15 ),
			)
		);

		$this->addField(
			array(
				new ODDataFieldName( 'ach_entry_return_date_of_death' ),
				new ODFieldRulePadLeft( 6, '0' ),
				new ODFieldRuleLength( 6 ),
			)
		);

		$this->addField(
			array(
				new ODDataFieldName( 'ach_entry_return_original_dfi_id' ),
				new ODFieldRuleEnforceNumeric(),
				new ODFieldRulePadLeft( 8, '0' ),
				new ODFieldRuleLength( 8 ),
			)
		);

		$this->addField(
			array(
				new ODDataFieldName( 'ach_entry_return_addenda_information' ),
				new ODFieldRulePadRight( 44, ' ' ),
				new ODFieldRuleLength( 44 ),
			)
		);

		$this->addField(
			array(
				new ODDataFieldName( 'ach_entry_return_trace_number' ),
				new ODFieldRuleEnforceNumeric(),
				new ODFieldRulePadLeft( 15, '0' ),
				new ODFieldRuleLength( 15 ),
			)
		);

	}

	public function build( OADataSource $dataSource )
	{
		// Never build this type of record
		return false;
	}

}
