<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

/**
 * This is the model class for table "ofac_sdn".
 *
 * The followings are the available columns in table 'ofac_sdn':
 * @property integer $ofac_sdn_ent_num
 * @property string $ofac_sdn_name
 * @property string $ofac_sdn_type
 * @property string $ofac_sdn_program
 * @property string $ofac_sdn_title
 * @property string $ofac_sdn_call_sign
 * @property string $ofac_sdn_vess_type
 * @property string $ofac_sdn_tonnage
 * @property string $ofac_sdn_grt
 * @property string $ofac_sdn_vess_flag
 * @property string $ofac_sdn_vess_owner
 * @property string $ofac_sdn_remarks
 */
class OfacSdn extends OADataSource
{
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'ofac_sdn_ent_num' => 'Ofac Sdn Ent Num',
			'ofac_sdn_name' => 'Ofac Sdn Name',
			'ofac_sdn_type' => 'Ofac Sdn Type',
			'ofac_sdn_program' => 'Ofac Sdn Program',
			'ofac_sdn_title' => 'Ofac Sdn Title',
			'ofac_sdn_call_sign' => 'Ofac Sdn Call Sign',
			'ofac_sdn_vess_type' => 'Ofac Sdn Vess Type',
			'ofac_sdn_tonnage' => 'Ofac Sdn Tonnage',
			'ofac_sdn_grt' => 'Ofac Sdn Grt',
			'ofac_sdn_vess_flag' => 'Ofac Sdn Vess Flag',
			'ofac_sdn_vess_owner' => 'Ofac Sdn Vess Owner',
			'ofac_sdn_remarks' => 'Ofac Sdn Remarks',
		);
	}
}
