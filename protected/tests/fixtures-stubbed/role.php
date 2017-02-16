<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

return array(
'Role_1' => array(
	'role_id' =>'dd8705ae-b798-11e0-b684-00163e4c6b77',
	'role_name' =>'administrator',
	'role_description' =>'System administrator',
	'role_max_originator' =>'0',
	'role_max_odfi' =>'0',
	'role_max_daily_xfers' =>'0',
	'role_max_daily_files' =>'0',
	'role_max_daily_batches' =>'0',
	'role_iat_enabled' =>'0',
),
'Role_2' => array(
	'role_id' =>'e145441c-b798-11e0-b684-00163e4c6b77',
	'role_name' =>'basic_no_iat',
	'role_description' =>'Basic origination with one ODFI, and one file per day, unlimited batches, no IAT',
	'role_max_originator' =>'1',
	'role_max_odfi' =>'1',
	'role_max_daily_xfers' =>'1',
	'role_max_daily_files' =>'1',
	'role_max_daily_batches' =>'-1',
	'role_iat_enabled' =>'0',
),
'Role_3' => array(
	'role_id' =>'e75ff8f6-b798-11e0-b684-00163e4c6b77',
	'role_name' =>'basic_iat',
	'role_description' =>'Basic origination with one ODFI, and one file per day, unlimited batches, with IAT',
	'role_max_originator' =>'1',
	'role_max_odfi' =>'1',
	'role_max_daily_xfers' =>'1',
	'role_max_daily_files' =>'1',
	'role_max_daily_batches' =>'-1',
	'role_iat_enabled' =>'1',
),
'Role_4' => array(
	'role_id' =>'ea513212-b798-11e0-b684-00163e4c6b77',
	'role_name' =>'advanced_no_iat',
	'role_description' =>'Advanced origination with unlimited ODFIs, unlimited files per day, unlimited batches, no IAT',
	'role_max_originator' =>'-1',
	'role_max_odfi' =>'-1',
	'role_max_daily_xfers' =>'-1',
	'role_max_daily_files' =>'-1',
	'role_max_daily_batches' =>'-1',
	'role_iat_enabled' =>'0',
),
'Role_5' => array(
	'role_id' =>'ed767742-b798-11e0-b684-00163e4c6b77',
	'role_name' =>'advanced_iat',
	'role_description' =>'Advanced origination with unlimited ODFIs, unlimited files per day, unlimited batches, with IAT',
	'role_max_originator' =>'-1',
	'role_max_odfi' =>'-1',
	'role_max_daily_xfers' =>'-1',
	'role_max_daily_files' =>'-1',
	'role_max_daily_batches' =>'-1',
	'role_iat_enabled' =>'1',
),
);
