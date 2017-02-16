<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

abstract class OADetailRecord extends OAACHRecord
{

	const RECORD_TYPE_CODE = 6;

	protected function dataSource()
	{
		return new AchEntry();
	}

	protected $addendaRecords = array();

	public function __construct( $config )
	{
		parent::__construct( $config );
		$this->initAddendaRecords();
	}

	public function build( OADataSource $dataSource )
	{
		$detailRecord = parent::build( $dataSource );
		$this->builtRecord = array();
		$this->builtRecord[] = $detailRecord;

		$dataSource->ach_entry_detail_addenda_count = count( $this->addendaRecords );

		foreach ( $this->addendaRecords as $addendaRecord )
		{
			if ( $builtRecord = $addendaRecord->build( $dataSource ) )
			{
				$this->builtRecord[] = $builtRecord;
			}
		}

		return implode( $this->config->getLineDelimiter(), $this->builtRecord );
	}
	public function parse( $recordLine )
	{
		$dataSource = parent::parse( $recordLine );

		if ( $dataSource && $dataSource instanceof AchEntry && $dataSource->ach_entry_detail_addenda_record_indicator == '1' && $this->addendaRecords )
		{
			if ( $this->reader->getReader()->hasSourceFile() )
			{
				$fileReader = $this->reader->getReader();
			}
			else
			{
				return $dataSource;
			}
			// If we have addenda records to process, we can read the records directly from the file reader
			while( $addendaRecordLine = $fileReader->readLine() )
			{
				$validAddendaRecord = false;
				foreach ( $this->addendaRecords as $addendaRecord )
				{
					if ( $parsedRecord = $addendaRecord->parse( $addendaRecordLine ) )
					{
						$validAddendaRecord = true;
						$dataSource->merge( $parsedRecord );
					}
				}
				
				// If we still don't have a vaild addenda record, we need to send this line back to the reader
				// and then gracefully exit our readLine loop
				if ( ! $validAddendaRecord )
				{
                                        $this->reader->getReader()->setUnparsedRecord( $addendaRecordLine );
					break;
				}					
			}
		}
                return $dataSource;
}

	abstract protected function initAddendaRecords();
	abstract protected function getStandardEntryClass();
	abstract protected function prepareAddendaDataSource( $dataSource );

	protected function readerHasValidDataSource()
	{
		if ( $this->reader && $dataSource = $this->reader->getDataSource() )
		{
			if ( isset( $dataSource->ach_batch_header_standard_entry_class ) && $dataSource->ach_batch_header_standard_entry_class == $this->getStandardEntryClass() )
			{
				return true;
			}
		}
		return false;
	}

}


