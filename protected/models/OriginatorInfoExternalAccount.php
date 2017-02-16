<?php

/**
 * This is the model class for table "originator_info_external_account".
 *
 * The followings are the available columns in table 'originator_info_external_account':
 * @property string $external_account_id
 * @property string $originator_info_id
 */
class OriginatorInfoExternalAccount extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return OriginatorInfoExternalAccount the static model class
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
		return 'originator_info_external_account';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('external_account_id, originator_info_id', 'required'),
			array('external_account_id, originator_info_id', 'length', 'max'=>36),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('external_account_id, originator_info_id', 'safe', 'on'=>'search'),
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

	public function behaviors()
	{
		return array(
			'CValidateOwnershipBehavior' => array(
				'class' => 'application.behaviors.CValidateOwnershipBehavior',
				'modelList' => array (
					'ExternalAccount' => 'external_account_id',
					'OriginatorInfo' => 'originator_info_id',
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
			'external_account_id' => 'External Account',
			'originator_info_id' => 'Originator Info',
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

		$criteria->compare('external_account_id',$this->external_account_id,true);
		$criteria->compare('originator_info_id',$this->originator_info_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
