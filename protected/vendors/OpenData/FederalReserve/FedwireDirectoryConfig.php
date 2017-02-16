<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

class FedwireDirectoryConfig extends ODConfig 
{
	// default config to enable use with ODReader
	public $directoryUrl = 'https://www.frbservices.org/EPaymentsDirectory/fpddir.txt';
}

class FedwireDirectoryFileReader extends ODReader
{
	protected $directoryRecordModel;
	
	protected function initReaderChain()
	{
		$this->readerChain[] = $this->directoryRecordModel;
	}
	protected function initRecordModels()
	{
		$this->directoryRecordModel = new FedwireDirectoryRecord( $this->config );
	}
}

class FedwireDirectoryRecord extends OARecord
{

	protected function initRecordFields()
	{
		$this->addField( 
			array(
				new ODDataFieldName( 'fedwire_routing_number' ),
				new ODFieldRulePadRight( 9, ' ' ),
				new ODFieldRuleLength( 9 )
			)
		);

		$this->addField(
			array(
				new ODDataFieldName( 'fedwire_telegraphic_name' ),
				new ODFieldRulePadRight( 18, ' ' ),
				new ODFieldRuleLength( 18 )
			)
		);

		$this->addField(
			array(
				new ODDataFieldName( 'fedwire_customer_name' ),
				new ODFieldRulePadRight( 36, ' ' ),
				new ODFieldRuleLength( 36 )
			)
		);

		$this->addField(
			array(
				new ODDataFieldName( 'fedwire_state_province' ),
				new ODFieldRulePadRight( 2, ' ' ),
				new ODFieldRuleLength( 2 )
			)
		);

		$this->addField(
			array(
				new ODDataFieldName( 'fedwire_city' ),
				new ODFieldRulePadRight( 25, ' ' ),
				new ODFieldRuleLength( 25 )
			)
		);

		$this->addField(
			array(
				new ODDataFieldName( 'fedwire_funds_transfer_status' ),
				new ODFieldRulePadRight( 1, ' ' ),
				new ODFieldRuleLength( 1 )
			)
		);

		$this->addField(
			array(
				new ODDataFieldName( 'fedwire_settlement_only_status' ),
				new ODFieldRulePadRight( 1, ' ' ),
				new ODFieldRuleLength( 1 )
			)
		);

		$this->addField(
			array(
				new ODDataFieldName( 'fedwire_securities_transfer_status' ),
				new ODFieldRulePadRight( 1, ' ' ),
				new ODFieldRuleLength( 1 )
			)
		);

		$this->addField(
			array(
				new ODDataFieldName( 'fedwire_revision_date' ),
				new ODFieldRulePadRight( 8, ' ' ),
				new ODFieldRuleLength( 8 )
			)
		);


	}
	
	public function remapDataSource( ODDataSource $dataSource )
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
		return new Fedwire();
	}

}
