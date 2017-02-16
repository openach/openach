<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

include_once( 'OAUtility.class.php' );
include_once( 'OABuilder.php' );
include_once( 'OARecord.php' );
include_once( 'OAField.php' );
include_once( 'OAPPDRecord.php' );
include_once( 'OAIATRecord.php' );

$config = new OAConfig();
//$fileBuilder = new OAFileBuilder( $config );
$dataSource = new OAACHFile();
//$fileBuilder->build( $dataSource );

$ppdRecord = new OAPPDDetailRecord( $config );

$achFile = new SplFileObject( '../../../tests/misc/20110729A.ach' );

//$achLine = '627021200025998412345        0000112000A1190          SEBASTIAN MCDONALD      0042000010000141';

while ( $achLine = $achFile->fgets() )
{
	$dataSource = new OAACHFile();
	print $achLine . PHP_EOL;
	if ( $ppdRecord->parse( $achLine, $dataSource ) )
		var_dump( $dataSource );
}

