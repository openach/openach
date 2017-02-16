<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

/**
 * This is the model class for table "ofac_add".
 *
 * The followings are the available columns in table 'ofac_add':
 * @property integer $ofac_add_ent_num
 * @property integer $ofac_add_num
 * @property string $ofac_add_address
 * @property string $ofac_add_city
 * @property string $ofac_add_state_province
 * @property string $ofac_add_postal_code
 * @property string $ofac_add_country
 * @property string $ofac_add_remarks
 */
class OfacAdd extends OADataSource
{
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'ofac_add_ent_num' => 'Ofac Add Ent Num',
			'ofac_add_num' => 'Ofac Add Num',
			'ofac_add_address' => 'Ofac Add Address',
			'ofac_add_city' => 'Ofac Add City',
			'ofac_add_state_province' => 'Ofac Add State Province',
			'ofac_add_postal_code' => 'Ofac Add Postal Code',
			'ofac_add_country' => 'Ofac Add Country',
			'ofac_add_remarks' => 'Ofac Add Remarks',
		);
	}
}
