<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/


class OAIATDetailRecord extends OADetailRecord
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
				new ODDataFieldName( 'ach_entry_detail_transaction_code' ),
				new ODFieldRuleEnforceNumeric(),
				new ODFieldRulePadLeft( 2, 0 ), 
				new ODFieldRuleLength( 2 ),
			)
		);
		
		$this->addField(
			array(
				new ODDataFieldName( 'ach_entry_iat_go_receiving_dfi_id' ),
				new ODFieldRuleEnforceNumeric(),
				new ODFieldRulePadLeft( 8, ' ' ),
				new ODFieldRuleLength( 8 ),
			)
		);
		$this->addField(
			array(
				new ODDataFieldName( 'ach_entry_iat_go_receiving_dfi_id_check_digit' ),
				new ODFieldRuleEnforceNumeric(),
				new ODFieldRulePadLeft( 1, ' ' ),
				new ODFieldRuleLength( 1 ),
			)
		);

		$this->addField(
			array(
				new ODDataFieldName( 'ach_entry_detail_addenda_count' ),
				new ODFieldRulePadRight( 4, ' ' ),
				new ODFieldRuleLength( 4 ),
			)
		);

		$this->addField(
			array(
				new ODDataFieldName( 'reserved' ),
				new ODStaticFieldValue( ' ' ),
				new ODFieldRulePadRight( 13, ' ' ),
				new ODFieldRuleLength( 13 ),
			)
		);

		$this->addField(
			array(
				new ODDataFieldName( 'ach_entry_detail_amount' ),
				new ODFieldRuleFormatCurrency(),
				new ODFieldRulePadLeft( 10, 0 ),
				new ODFieldRuleLength( 10 ),
			)
		);

		$this->addField(
			array(
				new ODDataFieldName( 'ach_entry_detail_dfi_account_number' ),
				new ODFieldRulePadRight( 35, ' ' ),
				new ODFieldRuleLength( 35 ),
			)
		);

		$this->addField(
			array(
				new ODDataFieldName( 'reserved' ),
				new ODStaticFieldValue( ' ' ),
				new ODFieldRulePadRight( 2, ' ' ),
				new ODFieldRuleLength( 2 ),
			)
		);

		$this->addField(
			array(
				new ODDataFieldName( 'ach_entry_iat_ofac_screening_indicator' ),
				new ODFieldRulePadRight( 1, ' ' ),
				new ODFieldRuleLength( 1 ),
			)
		);

		$this->addField(
			array(
				new ODDataFieldName( 'ach_entry_iat_secondary_ofac_screening_indicator' ),
				new ODFieldRulePadRight( 1, ' ' ),
				new ODFieldRuleLength( 1 ),
			)
		);

		$this->addField(
			array(
				new ODDataFieldName( 'ach_entry_detail_addenda_record_indicator' ),
				new ODFieldRuleLength( 1 ),
			)
		);		
				
		$this->addField(
			array(
				new ODDataFieldName( 'ach_entry_detail_trace_number' ),
				new OAFieldRuleTraceFormatter( $this->config ), // NOTE, this is an OpenACH Field Formatter
				new ODFieldRulePadLeft( 15, ' ' ),
				new ODFieldRuleLength( 15 ),
			)
		);				
	}
	
	protected function initAddendaRecords()
	{
		$this->addendaRecords = array(
			new OAIATFirstAddendaRecord( $this->config ),
			new OAIATSecondAddendaRecord( $this->config ),
			new OAIATThirdAddendaRecord( $this->config ),
			new OAIATFourthAddendaRecord( $this->config ),
			new OAIATFifthAddendaRecord( $this->config ),
			new OAIATSixthAddendaRecord( $this->config ),
			new OAIATSeventhAddendaRecord( $this->config ),
			new OAIATReturnAddendaRecord( $this->config ),
			new OAIATChangeAddendaRecord( $this->config ),
		);
	}
	protected function getStandardEntryClass()
	{
		return 'IAT';
	}
	
	protected function prepareAddendaDataSource( $dataSource )
	{
		if ( ! $dataSource )
		{
			return;
		}

		if ( ! isset( $dataSource->ach_entry_detail_sequence_number ) && isset( $dataSource->ach_entry_detail_trace_number ) )
		{
			$dataSource->ach_entry_detail_sequence_number = substr( $dataSource->ach_entry_detail_trace_number, -7 );
		}

		return;
	}

}
