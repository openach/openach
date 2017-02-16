<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

class OfacSdnConfig extends ODConfig 
{
	// default config to enable use with ODReader
	public $directoryUrl = 'http://www.treasury.gov/ofac/downloads/sdn.ff';
}

class OfacSdnFileReader extends ODReader
{
	protected $directoryRecordModel;
	
	protected function initReaderChain()
	{
		$this->readerChain[] = $this->directoryRecordModel;
	}
	protected function initRecordModels()
	{
		$this->directoryRecordModel = new OfacSdnRecord( $this->config );
	}
}

class OfacSdnRecord extends ODRecord
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
				new ODDataFieldName( 'ofac_sdn_ent_num' ),
				new ODFieldRulePadLeft( 10, ' ' ),
				new ODFieldRuleLength( 10 )
			)
		);

		$this->addField(
			array(
				new ODDataFieldName( 'ofac_sdn_name' ),
				new ODFieldRulePadRight( 350, ' ' ),
				new ODFieldRuleLength( 350 )
			)
		);

		$this->addField(
			array(
				new ODDataFieldName( 'ofac_sdn_type' ),
				new ODFieldRulePadRight( 12, ' ' ),
				new ODFieldRuleLength( 12 )
			)
		);

		$this->addField(
			array(
				new ODDataFieldName( 'ofac_sdn_program' ),
				new ODFieldRulePadRight( 50, ' ' ),
				new ODFieldRuleLength( 50 )
			)
		);

		$this->addField(
			array(
				new ODDataFieldName( 'ofac_sdn_title' ),
				new ODFieldRulePadRight( 200, ' ' ),
				new ODFieldRuleLength( 200 )
			)
		);

		$this->addField(
			array(
				new ODDataFieldName( 'ofac_sdn_call_sign' ),
				new ODFieldRulePadRight( 8, ' ' ),
				new ODFieldRuleLength( 8 )
			)
		);

		$this->addField(
			array(
				new ODDataFieldName( 'ofac_sdn_vess_type' ),
				new ODFieldRulePadRight( 25, ' ' ),
				new ODFieldRuleLength( 25 )
			)
		);

		$this->addField(
			array(
				new ODDataFieldName( 'ofac_sdn_tonnage' ),
				new ODFieldRulePadRight( 14, ' ' ),
				new ODFieldRuleLength( 14 )
			)
		);

		$this->addField(
			array(
				new ODDataFieldName( 'ofac_sdn_grt' ),
				new ODFieldRulePadRight( 8, ' ' ),
				new ODFieldRuleLength( 8 )
			)
		);

		$this->addField(
			array(
				new ODDataFieldName( 'ofac_sdn_vess_flag' ),
				new ODFieldRulePadRight( 40, ' ' ),
				new ODFieldRuleLength( 40 )
			)
		);

		$this->addField(
			array(
				new ODDataFieldName( 'ofac_sdn_vess_owner' ),
				new ODFieldRulePadRight( 150, ' ' ),
				new ODFieldRuleLength( 150 )
			)
		);

		$this->addField(
			array(
				new ODDataFieldName( 'ofac_sdn_remarks' ),
				new ODFieldRulePadRight( 1000, ' ' ),
				new ODFieldRuleLength( 1000 )
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
		return new OfacSdn();
	}

}
