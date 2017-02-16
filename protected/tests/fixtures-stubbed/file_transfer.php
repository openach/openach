<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

return array(
'FileTransfer_1' => array(
	'file_transfer_id' => UUID::mint()->string,
	'file_transfer_datetime' =>'2011-08-02 17:01:26',
	'file_transfer_file_id' => '1df32e82-b582-4d42-80bb-a12059181c73',
	'file_transfer_model' => 'AchFile',
	'file_transfer_status' => 'pending',
	'file_transfer_plugin' =>'USBank',
	'file_transfer_message' =>'',
),
'FileTransfer_2' => array(
	'file_transfer_id' => UUID::mint()->string,
	'file_transfer_datetime' =>'2011-08-01 17:01:26',
	'file_transfer_file_id' => '1df32e82-b582-4d42-80bb-a12059181c73',
	'file_transfer_model' => 'AchFile',
	'file_transfer_status' => 'failed',
	'file_transfer_plugin' =>'USBank',
	'file_transfer_message' =>'Network connection error.',
),
);
