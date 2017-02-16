<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

class OAPPDBatchHeaderRecord extends OABatchHeaderRecord
{
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
				new ODDataFieldName( 'ach_batch_header_company_name' ),
				new ODFieldRulePadRight( 16, ' ' ), 
				new ODFieldRuleLength( 16 ),
			)
		);

		$this->addField(
			array(
				new ODDataFieldName( 'ach_batch_header_discretionary_data' ),
				new ODFieldRulePadLeft( 20, ' ' ), 
				new ODFieldRuleLength( 20 ),
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
				new ODDataFieldName( 'ach_batch_header_standard_entry_class' ),
				new ODFieldRulePadLeft( 3, ' ' ), 
				new ODFieldRuleLength( 3 ),
			)
		);

		$this->addField(
			array(
				new ODDataFieldName( 'ach_batch_header_company_entry_description' ),
				new ODFieldRulePadRight( 10, ' ' ), 
				new ODFieldRuleLength( 10 ),
			)
		);

		$this->addField(
			array(
				new ODDataFieldName( 'ach_batch_header_company_descriptive_date' ),
				new ODFieldRulePadLeft( 6, ' ' ), 
				new ODFieldRuleLength( 6 ),
			)
		);

		$this->addField(
			array(
				new ODDataFieldName( 'ach_batch_header_effective_entry_date' ),
				new ODFieldRulePadLeft( 6, ' ' ), 
				new ODFieldRuleLength( 6 ),
			)
		);

		$this->addField(
			array(
				new ODDataFieldName( 'ach_batch_header_settlement_date' ),
				new ODFieldRulePadLeft( 3, ' ' ), 
				new ODFieldRuleLength( 3 ),
			)
		);

		$this->addField(
			array(
				new ODDataFieldName( 'ach_batch_header_originator_status_code' ),
				new ODFieldRuleLength( 1 ),
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
	public function getStandardEntryClass()
	{
		return 'PPD';
	}
}


