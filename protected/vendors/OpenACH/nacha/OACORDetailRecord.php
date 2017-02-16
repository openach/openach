<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

class OACORDetailRecord extends OAPPDDetailRecord
{

	protected function initAddendaRecords()
	{
		$this->addendaRecords = array(
				new OACORChangeAddendaRecord( $this->config ),
			);
	}

	public function getStandardEntryClass()
	{
		return 'COR';
	}

}
