<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

return array(
	'sample1'=>array(
		'payment_schedule_id' => 'ad73d360-1d32-11e1-8fb7-91434d450a4a',
		'payment_schedule_external_account_id' => '96698fb8-bd4a-11e0-b684-00163e4c6b77',
		'payment_schedule_payment_type_id' => '60e421d8-a8a0-4a43-91a1-9955f0c3c5ad',
		'payment_schedule_status' => 'enabled',
		'payment_schedule_amount' => '100.00',
		'payment_schedule_currency_code' => 'USD',
		'payment_schedule_next_date' => '2011-12-15',
		'payment_schedule_frequency' => 'weekly',
		'payment_schedule_end_date' => '2013-12-15',
		'payment_schedule_remaining_occurrences' => '52',
	),
	'sample2'=>array(
		'payment_schedule_id' => UUID::mint()->string,
		'payment_schedule_external_account_id' => '27e18302-d81b-11e0-ac5c-001a4b4851e2',
		'payment_schedule_payment_type_id' => '60e421d8-a8a0-4a43-91a1-9955f0c3c5ad',
		'payment_schedule_status' => 'enabled',
		'payment_schedule_amount' => '53.21',
		'payment_schedule_currency_code' => 'USD',
		'payment_schedule_next_date' => '2011-12-31',
		'payment_schedule_frequency' => 'monthly',
		'payment_schedule_end_date' => '2013-11-30',
		'payment_schedule_remaining_occurrences' => '12',
	),
	'sample3'=>array(
		'payment_schedule_id' => '146164c0-1d38-11e1-950f-05bfe60aed0e',
		'payment_schedule_external_account_id' => '96698fb8-bd4a-11e0-b684-00163e4c6b77',
		'payment_schedule_payment_type_id' => '7eef80fd-05e7-4100-9503-0a7c50e710d1',
		'payment_schedule_status' => 'enabled',
		'payment_schedule_amount' => '15.00',
		'payment_schedule_currency_code' => 'USD',
		'payment_schedule_next_date' => '2010-11-15',
		'payment_schedule_frequency' => 'weekly',
		'payment_schedule_end_date' => '2013-11-15',
		'payment_schedule_remaining_occurrences' => '52',
	),
	'sample4'=>array(
		'payment_schedule_id' => UUID::mint()->string,
		'payment_schedule_external_account_id' => '27e18302-d81b-11e0-ac5c-001a4b4851e2',
		'payment_schedule_payment_type_id' => '60e421d8-a8a0-4a43-91a1-9955f0c3c5ad',
		'payment_schedule_status' => 'enabled',
		'payment_schedule_amount' => '141.62',
		'payment_schedule_currency_code' => 'USD',
		'payment_schedule_next_date' => '2011-10-31',
		'payment_schedule_frequency' => 'monthly',
		'payment_schedule_end_date' => '2013-11-30',
		'payment_schedule_remaining_occurrences' => '12',
	),
	'sample5'=>array(
		'payment_schedule_id' => UUID::mint()->string,
		'payment_schedule_external_account_id' => '2c0b79dc-671e-11e1-83b4-f23c91dfda4e',
		'payment_schedule_payment_type_id' => 'd24e7dc2-624f-11e1-83b4-f23c91dfda4e',
		'payment_schedule_status' => 'enabled',
		'payment_schedule_amount' => '15.00',
		'payment_schedule_currency_code' => 'USD',
		'payment_schedule_next_date' => '2010-11-15',
		'payment_schedule_frequency' => 'weekly',
		'payment_schedule_end_date' => '2013-11-15',
		'payment_schedule_remaining_occurrences' => '52',
	),
	'sample6'=>array(
		'payment_schedule_id' => UUID::mint()->string,
		'payment_schedule_external_account_id' => '2d0d15ca-671e-11e1-83b4-f23c91dfda4e',
		'payment_schedule_payment_type_id' => 'd24e7dc2-624f-11e1-83b4-f23c91dfda4e',
		'payment_schedule_status' => 'enabled',
		'payment_schedule_amount' => '141.62',
		'payment_schedule_currency_code' => 'USD',
		'payment_schedule_next_date' => '2011-10-31',
		'payment_schedule_frequency' => 'monthly',
		'payment_schedule_end_date' => '2013-11-30',
		'payment_schedule_remaining_occurrences' => '12',
	),

);

