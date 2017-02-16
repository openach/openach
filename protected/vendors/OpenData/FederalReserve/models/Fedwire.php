<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

/**
 * This is the model class for table "fedwire".
 *
 * The followings are the available columns in table 'fedwire':
 * @property string $fedwire_routing_number
 * @property string $fedwire_telegraphic_name
 * @property string $fedwire_customer_name
 * @property string $fedwire_state_province
 * @property string $fedwire_city
 * @property string $fedwire_funds_transfer_status
 * @property string $fedwire_settlement_only_status
 * @property string $fedwire_securities_transfer_status
 * @property string $fedwire_revision_date
 */
class Fedwire extends ODDataSource
{
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'fedwire_routing_number' => 'Fedwire Routing Number',
			'fedwire_telegraphic_name' => 'Fedwire Telegraphic Name',
			'fedwire_customer_name' => 'Fedwire Customer Name',
			'fedwire_state_province' => 'Fedwire State Province',
			'fedwire_city' => 'Fedwire City',
			'fedwire_funds_transfer_status' => 'Fedwire Funds Transfer Status',
			'fedwire_settlement_only_status' => 'Fedwire Settlement Only Status',
			'fedwire_securities_transfer_status' => 'Fedwire Securities Transfer Status',
			'fedwire_revision_date' => 'Fedwire Revision Date',
		);
	}

	public function tableName()
	{
		return 'fedwire';
	}
}
