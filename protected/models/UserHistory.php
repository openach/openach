<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

/**
 * This is the model class for table "user_history".
 *
 * The followings are the available columns in table 'user_history':
 * @property string $user_history_id
 * @property string $user_history_user_id
 * @property string $user_history_datetime
 * @property string $user_history_event_type
 * @property string $user_history_additional_info
 */
class UserHistory extends OADataSource
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return UserHistory the static model class
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
		return 'user_history';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_history_id, user_history_user_id, user_history_datetime', 'required'),
			array('user_history_id, user_history_user_id', 'length', 'max'=>36),
			array('user_history_event_type', 'length', 'max'=>16),
			array('user_history_additional_info', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('user_history_id, user_history_user_id, user_history_datetime, user_history_event_type, user_history_additional_info', 'safe', 'on'=>'search'),
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
					'user_history_id',
				),
			),
			'CValidateOwnershipBehavior' => array(
				'class' => 'application.behaviors.CValidateOwnershipBehavior',
				'modelList' => array (
					'User' => 'user_history_user_id',
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
			'user_history_id' => 'User History',
			'user_history_user_id' => 'User History User',
			'user_history_datetime' => 'User History Datetime',
			'user_history_event_type' => 'User History Event Type',
			'user_history_additional_info' => 'User History Additional Info',
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

		$criteria->compare('user_history_id',$this->user_history_id,true);
		$criteria->compare('user_history_user_id',$this->user_history_user_id,true);
		$criteria->compare('user_history_datetime',$this->user_history_datetime,true);
		$criteria->compare('user_history_event_type',$this->user_history_event_type,true);
		$criteria->compare('user_history_additional_info',$this->user_history_additional_info,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}
