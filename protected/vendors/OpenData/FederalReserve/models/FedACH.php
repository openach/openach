<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

/**
 * This is the model class for table "fedach".
 *
 * The followings are the available columns in table 'fedach':
 * @property string $fedach_routing_number
 * @property string $fedach_office_code
 * @property string $fedach_servicing_frb_number
 * @property string $fedach_record_type_code
 * @property string $fedach_change_date
 * @property string $fedach_new_routing_number
 * @property string $fedach_customer_name
 * @property string $fedach_address
 * @property string $fedach_city
 * @property string $fedach_state_province
 * @property string $fedach_postal_code
 * @property string $fedach_postal_code_extension
 * @property string $fedach_phone_number
 * @property string $fedach_institution_status_code
 * @property string $fedach_data_view_code
 */
class FedACH extends ODDataSource
{
	public function attributeLabels()
	{
		return array(
			'fedach_routing_number' => 'Fedach Routing Number',
			'fedach_office_code' => 'Fedach Office Code',
			'fedach_servicing_frb_number' => 'Fedach Servicing Frb Number',
			'fedach_record_type_code' => 'Fedach Record Type Code',
			'fedach_change_date' => 'Fedach Change Date',
			'fedach_new_routing_number' => 'Fedach New Routing Number',
			'fedach_customer_name' => 'Fedach Customer Name',
			'fedach_address' => 'Fedach Address',
			'fedach_city' => 'Fedach City',
			'fedach_state_province' => 'Fedach State Province',
			'fedach_postal_code' => 'Fedach Postal Code',
			'fedach_postal_code_extension' => 'Fedach Postal Code Extension',
			'fedach_phone_number' => 'Fedach Phone Number',
			'fedach_institution_status_code' => 'Fedach Institution Status Code',
			'fedach_data_view_code' => 'Fedach Data View Code',
		);
	}

	public function tableName()
	{
		return 'fedach';
	}
}
