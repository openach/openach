<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

/**
 * This is the model class for table "user_api".
 *
 * The followings are the available columns in table 'user_api':
 * @property string $user_api_user_id
 * @property string $user_api_datetime
 * @property string $user_api_originator_info_id
 * @property string $user_api_token
 * @property string $user_api_key
 * @property string $user_api_status
 */
class UserApi extends OADataSource
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return UserRole the static model class
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
		return 'user_api';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_api_user_id, user_api_datetime, user_api_originator_info_id, user_api_token, user_api_key, user_api_status', 'required'),
			array('user_api_user_id, user_api_originator_info_id', 'length', 'max'=>36),
			array('user_api_token, user_api_key', 'length', 'max'=>48),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('user_api_user_id, user_api_originator_info_id, user_api_token, user_api_key', 'safe', 'on'=>'search'),
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
			'user' => array(
				self::BELONGS_TO,
				'User',
				'user_api_user_id'
			),
			'originator_info' => array(
				self::BELONGS_TO,
				'OriginatorInfo',
				'user_api_originator_info_id',
			),
		);
	}

	public function behaviors()
	{
		return array(
			'CDatetimeBehavior' => array(
				'class' => 'application.behaviors.CDatetimeBehavior',
				'attributeList' => array(
					'user_api_datetime',
				),
			),
			'CApiKeyBehavior' => array(
				'class' => 'application.behaviors.CApiKeyBehavior',
				'attributeList' => array(
					'user_api_token',
					'user_api_key',
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
			'user_api_user_id' => 'User API User',
			'user_api_originator_info_id' => 'Origination Account',
			'user_api_token' => 'API Token',
			'user_api_key' => 'API Key',
			'user_api_status' => 'Status',
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

		$criteria->compare('user_api_user_id',$this->user_api_user_id,true);
		$criteria->compare('user_api_originator_info_id',$this->user_api_originator_info_id,true);
		$criteria->compare('user_api_token',$this->user_api_token,true);
		$criteria->compare('user_api_status',$this->user_api_status,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}
