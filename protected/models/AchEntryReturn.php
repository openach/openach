<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

/**
 * This is the model class for table "ach_entry_return".
 *
 * The followings are the available columns in table 'ach_entry_return':
 * @property string $ach_entry_return_id
 * @property string $ach_entry_return_datetime
 * @property string $ach_entry_return_odfi_branch_id
 * @property string $ach_entry_return_ach_entry_id
 * @property string $ach_entry_return_reassigned_trace_number
 * @property string $ach_entry_return_date_of_death
 * @property string $ach_entry_return_original_dfi_id
 * @property string $ach_entry_return_trace_number
 * @property string $ach_entry_return_return_reason_code
 * @property string $ach_entry_return_change_code
 * @property string $ach_entry_return_corrected_data
 * @property string $ach_entry_return_addenda_information
 */
class AchEntryReturn extends OADataSource
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return AchEntryReturn the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'ach_entry_return';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ach_entry_return_id, ach_entry_return_datetime, ach_entry_return_odfi_branch_id, ach_entry_return_ach_entry_id', 'required'),
			array('ach_entry_return_id, ach_entry_return_odfi_branch_id, ach_entry_return_ach_entry_id', 'length', 'max'=>36),
			array('ach_entry_return_reassigned_trace_number, ach_entry_return_trace_number', 'length', 'max'=>15),
			array('ach_entry_return_date_of_death', 'length', 'max'=>6),
			array('ach_entry_return_original_dfi_id', 'length', 'max'=>8),
			array('ach_entry_return_return_reason_code, ach_entry_return_change_code', 'length', 'max'=>3),
			array('ach_entry_return_corrected_data', 'length', 'max'=>29),
			array('ach_entry_return_addenda_information', 'length', 'max'=>44),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('ach_entry_return_id, ach_entry_return_datetime, ach_entry_return_odfi_branch_id, ach_entry_return_ach_entry_id, ach_entry_return_reassigned_trace_number, ach_entry_return_date_of_death, ach_entry_return_original_dfi_id, ach_entry_return_trace_number, ach_entry_return_return_reason_code, ach_entry_return_change_code, ach_entry_return_corrected_data, ach_entry_return_addenda_information', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}


	public function behaviors(){
		return array(
			'CUuidKeyBehavior' => array(
				'class' => 'application.behaviors.CUuidKeyBehavior',
				'attributeList' => array (
					'ach_entry_return_id',
				),
			),
			'CDatetimeBehavior' => array(
				'class' => 'application.behaviors.CDatetimeBehavior',
				'attributeList' => array(
					'ach_entry_return_datetime',
				),
			),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'ach_entry_return_id' => 'Ach Entry Return',
			'ach_entry_return_datetime' => 'Ach Entry Return Datetime',
			'ach_entry_return_odfi_branch_id' => 'Ach Entry Return Odfi Branch',
			'ach_entry_return_ach_entry_id' => 'Ach Entry Return Ach Entry',
			'ach_entry_return_reassigned_trace_number' => 'Ach Entry Return Reassigned Trace Number',
			'ach_entry_return_date_of_death' => 'Ach Entry Return Date Of Death',
			'ach_entry_return_original_dfi_id' => 'Ach Entry Return Original Dfi',
			'ach_entry_return_trace_number' => 'Ach Entry Return Trace Number',
			'ach_entry_return_return_reason_code' => 'Ach Entry Return Return Reason Code',
			'ach_entry_return_change_code' => 'Ach Entry Return Change Code',
			'ach_entry_return_corrected_data' => 'Ach Entry Return Corrected Data',
			'ach_entry_return_addenda_information' => 'Ach Entry Return Addenda Information',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('ach_entry_return_id',$this->ach_entry_return_id,true);
		$criteria->compare('ach_entry_return_datetime',$this->ach_entry_return_datetime,true);
		$criteria->compare('ach_entry_return_odfi_branch_id',$this->ach_entry_return_odfi_branch_id,true);
		$criteria->compare('ach_entry_return_ach_entry_id',$this->ach_entry_return_ach_entry_id,true);
		$criteria->compare('ach_entry_return_reassigned_trace_number',$this->ach_entry_return_reassigned_trace_number,true);
		$criteria->compare('ach_entry_return_date_of_death',$this->ach_entry_return_date_of_death,true);
		$criteria->compare('ach_entry_return_original_dfi_id',$this->ach_entry_return_original_dfi_id,true);
		$criteria->compare('ach_entry_return_trace_number',$this->ach_entry_return_trace_number,true);
		$criteria->compare('ach_entry_return_return_reason_code',$this->ach_entry_return_return_reason_code,true);
		$criteria->compare('ach_entry_return_change_code',$this->ach_entry_return_change_code,true);
		$criteria->compare('ach_entry_return_corrected_data',$this->ach_entry_return_corrected_data,true);
		$criteria->compare('ach_entry_return_addenda_information',$this->ach_entry_return_addenda_information,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}

	public function createFromEntry( AchEntry $achEntry )
	{
		$this->ach_entry_return_odfi_branch_id = $achEntry->ach_entry_odfi_branch_id;
		$this->ach_entry_return_ach_entry_id = $achEntry->ach_entry_id;
		$this->ach_entry_return_reassigned_trace_number = $achEntry->ach_entry_return_reassigned_trace_number;
		$this->ach_entry_return_date_of_death = $achEntry->ach_entry_return_date_of_death;
		$this->ach_entry_return_original_dfi_id = $achEntry->ach_entry_return_original_dfi_id;
		$this->ach_entry_return_trace_number = $achEntry->ach_entry_return_trace_number;
		$this->ach_entry_return_return_reason_code = $achEntry->ach_entry_return_return_reason_code;
		$this->ach_entry_return_change_code = $achEntry->ach_entry_return_change_code;
		$this->ach_entry_return_corrected_data = $achEntry->ach_entry_return_corrected_data;
		$this->ach_entry_return_addenda_information = $achEntry->ach_entry_return_addenda_information;

		return $this;
	}
}
