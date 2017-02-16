<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/


class OAIATSeventhAddendaRecord extends OAIATAddendaRecord
{
	const ADDENDA_TYPE_CODE = '16';

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
				new ODDataFieldConcat(
					array(
					    'ach_entry_iat_receiver_city',
					    'ach_entry_iat_receiver_state_province'
					), '*' ),
				new ODFieldRuleAppend( "\\" ),
				new ODFieldRulePadRight( 35, ' ' ),
				new ODFieldRuleLength( 35 ),
			)
		);

		$this->addField(
			array(
				new ODDataFieldConcat(
					array(
					    'ach_entry_iat_receiver_country',
					    'ach_entry_iat_receiver_postal_code'
					), '*' ),
				new ODFieldRuleAppend( "\\" ),
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
