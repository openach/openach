<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

class OfacAltConfig extends ODConfig 
{
	// default config to enable use with ODReader
	public $directoryUrl = 'http://www.treasury.gov/ofac/downloads/alt.ff';
}

class OfacAltFileReader extends ODReader
{
	protected $directoryRecordModel;
	
	protected function initReaderChain()
	{
		$this->readerChain[] = $this->directoryRecordModel;
	}
	protected function initRecordModels()
	{
		$this->directoryRecordModel = new OfacAltRecord( $this->config );
	}
}

class OfacAltRecord extends ODRecord
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
				new ODDataFieldName( 'ofac_alt_ent_num' ),
				new ODFieldRulePadLeft( 10, ' ' ),
				new ODFieldRuleLength( 10 )
			)
		);

		$this->addField(
			array(
				new ODDataFieldName( 'ofac_alt_num' ),
				new ODFieldRulePadLeft( 10, ' ' ),
				new ODFieldRuleLength( 10 )
			)
		);

		$this->addField(
			array(
				new ODDataFieldName( 'ofac_alt_type' ),
				new ODFieldRulePadRight( 8, ' ' ),
				new ODFieldRuleLength( 8 )
			)
		);

		$this->addField(
			array(
				new ODDataFieldName( 'ofac_alt_name' ),
				new ODFieldRulePadRight( 350, ' ' ),
				new ODFieldRuleLength( 350 )
			)
		);

		$this->addField(
			array(
				new ODDataFieldName( 'ofac_alt_remarks' ),
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
		return new OfacAlt();
	}

}
