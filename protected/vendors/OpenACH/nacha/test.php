<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

include_once( 'OAUtility.class.php' );
include_once( 'OABuilder.class.php' );
include_once( 'OARecord.class.php' );
include_once( 'OAField.class.php' );
include_once( 'OAPPDRecord.class.php' );
include_once( 'OAIATRecord.class.php' );

$config = new OAConfig();
$fileBuilder = new OAFileBuilder( $config );
$dataSource = new OAACHFile();
$fileBuilder->build( $dataSource );
