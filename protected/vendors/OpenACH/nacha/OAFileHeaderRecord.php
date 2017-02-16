<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

class OAFileHeaderRecord extends OAHeaderRecord
{

	const RECORD_TYPE_CODE = 1;

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
				new ODDataFieldName( 'ach_file_header_priority_code' ),
				new ODStaticFieldValue( '01' ),
				new ODFieldRulePadLeft( 2, '0' ),
				new ODFieldRuleLength( 2 ),
			)
		);

		$this->addField(
			array(
				new ODDataFieldName( 'ach_file_header_immediate_destination' ),
				new ODFieldRulePadLeft( 10, ' ' ),
				new ODFieldRuleLength( 10 ),
			)
		);

		$this->addField(
			array(
				new ODDataFieldName( 'ach_file_header_immediate_origin' ),
				new ODFieldRulePadLeft( 10, ' ' ),
				new ODFieldRuleLength( 10 ),
			)
		);

		$this->addField(
			array(
				new ODDataFieldName( 'ach_file_header_file_creation_date' ),
				new ODFieldRulePadLeft( 6, ' ' ),
				new ODFieldRuleLength( 6 ),
			)
		);

		$this->addField(
			array(
				new ODDataFieldName( 'ach_file_header_file_creation_time' ),
				new ODFieldRulePadLeft( 4, ' ' ),
				new ODFieldRuleLength( 4 ),
			)
		);

		$this->addField(
			array(
				new ODDataFieldName( 'ach_file_header_file_id_modifier' ),
				new ODFieldRulePadLeft( 1, ' ' ),
				new ODFieldRuleLength( 1 ),
			)
		);

		$this->addField(
			array(
				new ODDataFieldName( 'ach_file_header_record_size' ),
				new ODStaticFieldValue( '094' ),
				new ODFieldRulePadLeft( 3, ' ' ),
				new ODFieldRuleLength( 3 ),
			)
		);

		$this->addField(
			array(
				new ODDataFieldName( 'ach_file_header_blocking_factor' ),
				new ODStaticFieldValue( $this->config->getBlockingFactor() ),
				new ODFieldRulePadLeft( 2, ' ' ),
				new ODFieldRuleLength( 2 ),
			)
		);

		$this->addField(
			array(
				new ODDataFieldName( 'ach_file_header_format_code' ),
				new ODStaticFieldValue( '1' ),
				new ODFieldRulePadLeft( 1, ' ' ),
				new ODFieldRuleLength( 1 ),
			)
		);

		$this->addField(
			array(
				new ODDataFieldName( 'ach_file_header_immediate_destination_name' ),
				new ODFieldRulePadRight( 23, ' ' ),
				new ODFieldRuleLength( 23 ),
			)
		);

		$this->addField(
			array(
				new ODDataFieldName( 'ach_file_header_immediate_origin_name' ),
				new ODFieldRulePadRight( 23, ' ' ),
				new ODFieldRuleLength( 23 ),
			)
		);

		$this->addField(
			array(
				new ODDataFieldName( 'ach_file_header_reference_code' ),
				new ODFieldRulePadLeft( 8, ' ' ),
				new ODFieldRuleLength( 8 ),
			)
		);

	}

	protected function dataSource()
	{
		return new AchFile();
	}

	protected function readerHasValidDataSource()
	{
		return true; // The reader will never have a data source at this point so we always have to return true, or we'll get nowhere
	}

}


