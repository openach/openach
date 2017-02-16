<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

class FedACHDirectoryConfig extends ODConfig 
{
	// default config to enable use with ODReader
	public $directoryUrl = 'https://www.frbservices.org/EPaymentsDirectory/FedACHdir.txt';
}

class FedACHDirectoryFileReader extends ODReader
{
	protected $directoryRecordModel;
	
	protected function initReaderChain()
	{
		$this->readerChain[] = $this->directoryRecordModel;
	}
	protected function initRecordModels()
	{
		$this->directoryRecordModel = new FedACHDirectoryRecord( $this->config );
	}
}

class FedACHDirectoryRecord extends OARecord
{

	protected function initRecordFields()
	{
		$this->addField( 
			array(
				new ODDataFieldName( 'fedach_routing_number' ),
				new ODFieldRulePadRight( 9, ' ' ),
				new ODFieldRuleLength( 9 )
			)
		);

		$this->addField(
			array(
				new ODDataFieldName( 'fedach_office_code' ),
				new ODFieldRulePadRight( 1, ' ' ),
				new ODFieldRuleLength( 1 )
			)
		);

		$this->addField(
			array(
				new ODDataFieldName( 'fedach_servicing_frb_number' ),
				new ODFieldRulePadRight( 9, ' ' ),
				new ODFieldRuleLength( 9 )
			)
		);

		$this->addField(
			array(
				new ODDataFieldName( 'fedach_record_type_code' ),
				new ODFieldRulePadRight( 1, ' ' ),
				new ODFieldRuleLength( 1 )
			)
		);

		$this->addField(
			array(
				new ODDataFieldName( 'fedach_change_date' ),
				new ODFieldRulePadRight( 6, ' ' ),
				new ODFieldRuleLength( 6 )
			)
		);

		$this->addField(
			array(
				new ODDataFieldName( 'fedach_new_routing_number' ),
				new ODFieldRulePadRight( 9, ' ' ),
				new ODFieldRuleLength( 9 )
			)
		);

		$this->addField(
			array(
				new ODDataFieldName( 'fedach_customer_name' ),
				new ODFieldRulePadRight( 36, ' ' ),
				new ODFieldRuleLength( 36 )
			)
		);

		$this->addField(
			array(
				new ODDataFieldName( 'fedach_address' ),
				new ODFieldRulePadRight( 36, ' ' ),
				new ODFieldRuleLength( 36 )
			)
		);

		$this->addField(
			array(
				new ODDataFieldName( 'fedach_city' ),
				new ODFieldRulePadRight( 20, ' ' ),
				new ODFieldRuleLength( 20 )
			)
		);

		$this->addField(
			array(
				new ODDataFieldName( 'fedach_state_province' ),
				new ODFieldRulePadRight( 2, ' ' ),
				new ODFieldRuleLength( 2 )
			)
		);

		$this->addField(
			array(
				new ODDataFieldName( 'fedach_postal_code' ),
				new ODFieldRulePadRight( 5, ' ' ),
				new ODFieldRuleLength( 5 )
			)
		);

		$this->addField(
			array(
				new ODDataFieldName( 'fedach_postal_code_extension' ),
				new ODFieldRulePadRight( 4, ' ' ),
				new ODFieldRuleLength( 4 )
			)
		);

		$this->addField(
			array(
				new ODDataFieldName( 'fedach_phone_number' ),
				new ODFieldRulePadRight( 10, ' ' ),
				new ODFieldRuleLength( 10 )
			)
		);

		$this->addField(
			array(
				new ODDataFieldName( 'fedach_institution_status_code' ),
				new ODFieldRulePadRight( 1, ' ' ),
				new ODFieldRuleLength( 1 )
			)
		);

		$this->addField(
			array(
				new ODDataFieldName( 'fedach_data_view_code' ),
				new ODFieldRulePadRight( 1, ' ' ),
				new ODFieldRuleLength( 1 )
			)
		);

	}
	
	public function remapDataSource( OADataSource $dataSource )
	{
		// TODO: Map any meaningful incoming bank confirmation fields to internal fields
		$fieldRemap = array();
		$dataSource->remapFields( $fieldRemap );
	}

	protected function readerHasValidDataSource()
	{
		return true;
	}

	protected function recordValidToProcess( $recordLine )
	{
		return true;
	}

	protected function dataSource()
	{
		return new FedACH();
	}

}
