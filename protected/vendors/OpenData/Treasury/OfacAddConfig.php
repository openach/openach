<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

class OfacAddConfig extends ODConfig 
{
	// default config to enable use with ODReader
	public $directoryUrl = 'http://www.treasury.gov/ofac/downloads/add.ff';
}

class OfacAddFileReader extends ODReader
{
	protected $directoryRecordModel;
	
	protected function initReaderChain()
	{
		$this->readerChain[] = $this->directoryRecordModel;
	}
	protected function initRecordModels()
	{
		$this->directoryRecordModel = new OfacAddRecord( $this->config );
	}
}

class OfacAddRecord extends ODRecord
{

	protected function filterData( $data )
	{
		if ( trim( $data ) == '-0-' || trim( $data ) == "''" )
		{
			return '';
		}
		else
		{
			return $data;
		}
	}

	protected function initRecordFields()
	{

		$this->addField(
			array(
				new ODDataFieldName( 'ofac_add_ent_num' ),
				new ODFieldRulePadLeft( 10, ' ' ),
				new ODFieldRuleLength( 10 )
			)
		);

		$this->addField(
			array(
				new ODDataFieldName( 'ofac_add_num' ),
				new ODFieldRulePadLeft( 10, ' ' ),
				new ODFieldRuleLength( 10 )
			)
		);

		$this->addField(
			array(
				new ODDataFieldName( 'ofac_add_address' ),
				new ODFieldRulePadRight( 750, ' ' ),
				new ODFieldRuleLength( 750 )
			)
		);

		$this->addField(
			array(
				new ODDataFieldConcat(
					array(
					    'ofac_add_city',
					    'ofac_add_state_province',
					    'ofac_add_postal_code'
					), ',' ),
				new ODFieldRulePadRight( 116, ' ' ),
				new ODFieldRuleLength( 116 ),
			)
		);

		$this->addField(
			array(
				new ODDataFieldName( 'ofac_add_country' ),
				new ODFieldRulePadRight( 250, ' ' ),
				new ODFieldRuleLength( 250 )
			)
		);

		$this->addField(
			array(
				new ODDataFieldName( 'ofac_add_remarks' ),
				new ODFieldRulePadRight( 200, ' ' ),
				new ODFieldRuleLength( 200 )
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
		$trimmedLine = trim( $recordLine );
		if ( $trimmedLine == '-0-' || ! $trimmedLine || $trimmedLine == chr( 26 ) )
		{
			return false;
		}
		else
		{
			return true;
		}
	}

	protected function dataSource()
	{
		return new OfacAdd();
	}

}
