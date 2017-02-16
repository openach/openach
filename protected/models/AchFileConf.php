<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

/**
 * This is the model class for table "ach_file_conf".
 *
 * The followings are the available columns in table 'ach_file_conf':
 * @property string $ach_file_conf_id
 * @property string $ach_file_conf_datetime
 * @property string $ach_file_conf_odfi_branch_id
 * @property string $ach_file_conf_status
 * @property string $ach_file_conf_date
 * @property string $ach_file_conf_time
 * @property string $ach_file_conf_batch_count
 * @property string $ach_file_conf_batch_item_count
 * @property string $ach_file_conf_block_count
 * @property string $ach_file_conf_error_message_number
 * @property string $ach_file_conf_error_message
 * @property string $ach_file_conf_total_debits
 * @property string $ach_file_conf_total_credits
 */
class AchFileConf extends OADataSource
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return AchFileConf the static model class
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
		return 'ach_file_conf';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ach_file_conf_id, ach_file_conf_datetime, ach_file_conf_odfi_branch_id', 'required'),
			array('ach_file_conf_id, ach_file_conf_odfi_branch_id', 'length', 'max'=>36),
			array('ach_file_conf_status, ach_file_conf_error_message_number', 'length', 'max'=>10),
			array('ach_file_conf_date, ach_file_conf_time, ach_file_conf_batch_count, ach_file_conf_block_count', 'length', 'max'=>6),
			array('ach_file_conf_batch_item_count', 'length', 'max'=>4),
			array('ach_file_conf_total_debits, ach_file_conf_total_credits', 'length', 'max'=>12),
			array('ach_file_conf_error_message', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('ach_file_conf_id, ach_file_conf_datetime, ach_file_conf_odfi_branch_id, ach_file_conf_status, ach_file_conf_date, ach_file_conf_time, ach_file_conf_batch_count, ach_file_conf_batch_item_count, ach_file_conf_block_count, ach_file_conf_error_message_number, ach_file_conf_error_message, ach_file_conf_total_debits, ach_file_conf_total_credits', 'safe', 'on'=>'search'),
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
					'ach_file_conf_id',
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
			'ach_file_conf_id' => 'Ach File Conf',
			'ach_file_conf_datetime' => 'Ach File Conf Datetime',
			'ach_file_conf_odfi_branch_id' => 'Ach File Conf Odfi Branch',
			'ach_file_conf_status' => 'Ach File Conf Status',
			'ach_file_conf_date' => 'Ach File Conf Date',
			'ach_file_conf_time' => 'Ach File Conf Time',
			'ach_file_conf_batch_count' => 'Ach File Conf Batch Count',
			'ach_file_conf_batch_item_count' => 'Ach File Conf Batch Item Count',
			'ach_file_conf_block_count' => 'Ach File Conf Block Count',
			'ach_file_conf_error_message_number' => 'Ach File Conf Error Message Number',
			'ach_file_conf_error_message' => 'Ach File Conf Error Message',
			'ach_file_conf_total_debits' => 'Ach File Conf Total Debits',
			'ach_file_conf_total_credits' => 'Ach File Conf Total Credits',
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

		$criteria->compare('ach_file_conf_id',$this->ach_file_conf_id,true);
		$criteria->compare('ach_file_conf_datetime',$this->ach_file_conf_datetime,true);
		$criteria->compare('ach_file_conf_odfi_branch_id',$this->ach_file_conf_odfi_branch_id,true);
		$criteria->compare('ach_file_conf_status',$this->ach_file_conf_status,true);
		$criteria->compare('ach_file_conf_date',$this->ach_file_conf_date,true);
		$criteria->compare('ach_file_conf_time',$this->ach_file_conf_time,true);
		$criteria->compare('ach_file_conf_batch_count',$this->ach_file_conf_batch_count,true);
		$criteria->compare('ach_file_conf_batch_item_count',$this->ach_file_conf_batch_item_count,true);
		$criteria->compare('ach_file_conf_block_count',$this->ach_file_conf_block_count,true);
		$criteria->compare('ach_file_conf_error_message_number',$this->ach_file_conf_error_message_number,true);
		$criteria->compare('ach_file_conf_error_message',$this->ach_file_conf_error_message,true);
		$criteria->compare('ach_file_conf_total_debits',$this->ach_file_conf_total_debits,true);
		$criteria->compare('ach_file_conf_total_credits',$this->ach_file_conf_total_credits,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}
