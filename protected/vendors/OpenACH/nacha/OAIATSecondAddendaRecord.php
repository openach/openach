<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

class OAIATSecondAddendaRecord extends OAIATAddendaRecord
{
	const ADDENDA_TYPE_CODE = '11';

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
				new ODDataFieldName( 'ach_entry_iat_originator_name' ),
				new ODFieldRulePadRight( 35, ' ' ),
				new ODFieldRuleLength( 35 ),
			)
		);

		$this->addField(
			array(
				new ODDataFieldName( 'ach_entry_iat_originator_street_addr' ),
				new ODFieldRulePadRight( 35, ' ' ),
				new ODFieldRuleLength( 35 ),
			)
		);

		$this->addField(
			array(
				new ODDataFieldName( 'reserved' ),
				new ODFieldRulePadLeft( 14, ' ' ),
				new ODFieldRuleLength( 14 ),
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


