<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

class OAIATSixthAddendaRecord extends OAIATAddendaRecord
{
	const ADDENDA_TYPE_CODE = '15';

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
				new ODDataFieldName( 'ach_entry_detail_individual_id_number' ),
				new ODFieldRulePrepend( 'OA' ),
				new ODFieldRulePadRight( 15, ' ' ),
				new ODFieldRuleLength( 15 ),
			)
		);

		$this->addField(
			array(
				new ODDataFieldName( 'ach_entry_iat_receiver_street_addr' ),
				new ODFieldRulePadRight( 35, ' ' ),
				new ODFieldRuleLength( 35 ),
			)
		);

		$this->addField(
			array(
				new ODDataFieldName( 'reserved' ),
				new ODFieldRulePadLeft( 34, ' ' ),
				new ODFieldRuleLength( 34 ),
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

	}}

