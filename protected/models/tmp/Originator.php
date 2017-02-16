<?php

/**
 * This is the model class for table "originator".
 *
 * The followings are the available columns in table 'originator':
 * @property string $originator_id
 * @property string $originator_datetime
 * @property string $originator_user_id
 * @property string $originator_name
 * @property string $originator_identification
 * @property string $originator_address
 * @property string $originator_city
 * @property string $originator_state_province
 * @property string $originator_postal_code
 * @property string $originator_country_code
 */
class Originator extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Originator the static model class
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
		return 'originator';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('originator_id, originator_datetime, originator_user_id', 'required'),
			array('originator_id, originator_user_id', 'length', 'max'=>36),
			array('originator_name, originator_address, originator_city, originator_state_province, originator_postal_code', 'length', 'max'=>35),
			array('originator_identification', 'length', 'max'=>10),
			array('originator_country_code', 'length', 'max'=>2),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('originator_id, originator_datetime, originator_user_id, originator_name, originator_identification, originator_address, originator_city, originator_state_province, originator_postal_code, originator_country_code', 'safe', 'on'=>'search'),
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
			'originator_id' => 'Originator',
			'originator_datetime' => 'Originator Datetime',
			'originator_user_id' => 'Originator User',
			'originator_name' => 'Originator Name',
			'originator_identification' => 'Originator Identification',
			'originator_address' => 'Originator Address',
			'originator_city' => 'Originator City',
			'originator_state_province' => 'Originator State Province',
			'originator_postal_code' => 'Originator Postal Code',
			'originator_country_code' => 'Originator Country Code',
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

		$criteria->compare('originator_id',$this->originator_id,true);

		$criteria->compare('originator_datetime',$this->originator_datetime,true);

		$criteria->compare('originator_user_id',$this->originator_user_id,true);

		$criteria->compare('originator_name',$this->originator_name,true);

		$criteria->compare('originator_identification',$this->originator_identification,true);

		$criteria->compare('originator_address',$this->originator_address,true);

		$criteria->compare('originator_city',$this->originator_city,true);

		$criteria->compare('originator_state_province',$this->originator_state_province,true);

		$criteria->compare('originator_postal_code',$this->originator_postal_code,true);

		$criteria->compare('originator_country_code',$this->originator_country_code,true);

		return new CActiveDataProvider('Originator', array(
			'criteria'=>$criteria,
		));
	}
}
