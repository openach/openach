<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

/**
 * This is the model class for table "ofac_alt".
 *
 * The followings are the available columns in table 'ofac_alt':
 * @property integer $ofac_alt_ent_num
 * @property integer $ofac_alt_num
 * @property string $ofac_alt_type
 * @property string $ofac_alt_name
 * @property string $ofac_alt_remarks
 */
class OfacAlt extends CActiveRecord
{
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'ofac_alt_ent_num' => 'Ofac Alt Ent Num',
			'ofac_alt_num' => 'Ofac Alt Num',
			'ofac_alt_type' => 'Ofac Alt Type',
			'ofac_alt_name' => 'Ofac Alt Name',
			'ofac_alt_remarks' => 'Ofac Alt Remarks',
		);
	}
}
