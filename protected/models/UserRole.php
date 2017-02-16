<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

/**
 * This is the model class for table "user_role".
 *
 * The followings are the available columns in table 'user_role':
 * @property string $user_role_user_id
 * @property string $user_role_role_id
 */
class UserRole extends OADataSource
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
		return 'user_role';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_role_user_id, user_role_role_id', 'required'),
			array('user_role_user_id, user_role_role_id', 'length', 'max'=>36),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('user_role_user_id, user_role_role_id', 'safe', 'on'=>'search'),
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

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'user_role_user_id' => 'User Role User',
			'user_role_role_id' => 'User Role Role',
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

		$criteria->compare('user_role_user_id',$this->user_role_user_id,true);
		$criteria->compare('user_role_role_id',$this->user_role_role_id,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}
