<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

class OAPPDDetailRecord extends OADetailRecord
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
				new ODDataFieldName( 'ach_entry_detail_receiving_dfi_id' ),
				new ODFieldRuleEnforceNumeric(),
				new ODFieldRulePadLeft( 8, ' ' ),
				new ODFieldRuleLength( 8 ),
			)
		);
		$this->addField(
			array(
				new ODDataFieldName( 'ach_entry_detail_receiving_dfi_id_check_digit' ),
				new ODFieldRuleEnforceNumeric(),
				new ODFieldRulePadLeft( 1, ' ' ),
				new ODFieldRuleLength( 1 ),
			)
		);

		$this->addField(
			array(
				new ODDataFieldName( 'ach_entry_detail_dfi_account_number' ),
				new ODFieldRulePadRight( 17, ' ' ),
				new ODFieldRuleLength( 17 ),
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
				new ODDataFieldName( 'ach_entry_detail_individual_id_number' ),
				new ODFieldRulePrepend( 'OA' ),
				new ODFieldRulePadRight( 15, ' ' ),
				new ODFieldRuleLength( 15 ),
			)
		);

		$this->addField(
			array(
				new ODDataFieldName( 'ach_entry_detail_individual_name' ),
				new ODFieldRulePadRight( 22, ' ' ),
				new ODFieldRuleLength( 22 ),
			)
		);
		
		$this->addField(
			array(
				new ODDataFieldName( 'ach_entry_detail_discretionary_data' ),
				new ODStaticFieldValue( '  ' ),
				new ODFieldRuleLength( 2 ),
			)
		);

		$this->addField(
			array(
				new ODDataFieldName( 'ach_entry_detail_addenda_record_indicator' ),
				new ODFieldRulePadRight( 1, '0' ),
				new ODFieldRuleLength( 1 ),
			)
		);		
				
		$this->addField(
			array(
				new ODDataFieldName( 'ach_entry_detail_trace_number' ),
				//new ODFieldRulePadLeft( 8, '0' ),
				new OAFieldRuleTraceFormatter( $this->config ), // NOTE, this is an OpenACH Field Formatter
				new ODFieldRuleLength( 15 ),
			)
		);				
	}
	
	protected function initAddendaRecords()
	{
		$this->addendaRecords = array(
				new OAPPDReturnAddendaRecord( $this->config ),
				new OAPPDChangeAddendaRecord( $this->config ),
			);
	}

	public function getStandardEntryClass()
	{
		return 'PPD';
	}

	protected function prepareAddendaDataSource( $dataSource )
	{
		return;
	}
}
