<?php

/**
 * This is the model class for table "external_account".
 *
 * The followings are the available columns in table 'external_account':
 * @property string $external_account_id
 * @property string $external_account_datetime
 * @property string $external_account_originator_id
 * @property string $external_account_name
 * @property string $external_account_bank
 * @property string $external_account_holder
 * @property string $external_account_country_code
 * @property string $external_account_dfi_id
 * @property string $external_account_dfi_id_qualifier
 * @property string $external_account_number
 * @property string $external_account_billing_address
 * @property string $external_account_billing_city
 * @property string $external_account_billing_state_province
 * @property string $external_account_billing_postal_code
 * @property string $external_account_billing_country
 * @property integer $external_account_business
 * @property string $external_account_verification_status
 * @property string $external_account_status
 */
class ExternalAccount extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return ExternalAccount the static model class
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
		return 'external_account';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('external_account_id, external_account_datetime, external_account_originator_id', 'required'),
			array('external_account_business', 'numerical', 'integerOnly'=>true),
			array('external_account_id, external_account_originator_id', 'length', 'max'=>36),
			array('external_account_name, external_account_bank, external_account_holder, external_account_dfi_id, external_account_number', 'length', 'max'=>125),
			array('external_account_country_code, external_account_dfi_id_qualifier, external_account_billing_country', 'length', 'max'=>2),
			array('external_account_billing_address, external_account_billing_city, external_account_billing_state_province, external_account_billing_postal_code', 'length', 'max'=>35),
			array('external_account_verification_status', 'length', 'max'=>9),
			array('external_account_status', 'length', 'max'=>7),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('external_account_id, external_account_datetime, external_account_originator_id, external_account_name, external_account_bank, external_account_holder, external_account_country_code, external_account_dfi_id, external_account_dfi_id_qualifier, external_account_number, external_account_billing_address, external_account_billing_city, external_account_billing_state_province, external_account_billing_postal_code, external_account_billing_country, external_account_business, external_account_verification_status, external_account_status', 'safe', 'on'=>'search'),
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
			'external_account_id' => 'External Account',
			'external_account_datetime' => 'External Account Datetime',
			'external_account_originator_id' => 'External Account Originator',
			'external_account_name' => 'External Account Name',
			'external_account_bank' => 'External Account Bank',
			'external_account_holder' => 'External Account Holder',
			'external_account_country_code' => 'External Account Country Code',
			'external_account_dfi_id' => 'External Account Dfi',
			'external_account_dfi_id_qualifier' => 'External Account Dfi Id Qualifier',
			'external_account_number' => 'External Account Number',
			'external_account_billing_address' => 'External Account Billing Address',
			'external_account_billing_city' => 'External Account Billing City',
			'external_account_billing_state_province' => 'External Account Billing State Province',
			'external_account_billing_postal_code' => 'External Account Billing Postal Code',
			'external_account_billing_country' => 'External Account Billing Country',
			'external_account_business' => 'External Account Business',
			'external_account_verification_status' => 'External Account Verification Status',
			'external_account_status' => 'External Account Status',
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

		$criteria->compare('external_account_datetime',$this->external_account_datetime,true);

		$criteria->compare('external_account_originator_id',$this->external_account_originator_id,true);

		$criteria->compare('external_account_name',$this->external_account_name,true);

		$criteria->compare('external_account_bank',$this->external_account_bank,true);

		$criteria->compare('external_account_holder',$this->external_account_holder,true);

		$criteria->compare('external_account_country_code',$this->external_account_country_code,true);

		$criteria->compare('external_account_dfi_id',$this->external_account_dfi_id,true);

		$criteria->compare('external_account_dfi_id_qualifier',$this->external_account_dfi_id_qualifier,true);

		$criteria->compare('external_account_number',$this->external_account_number,true);

		$criteria->compare('external_account_billing_address',$this->external_account_billing_address,true);

		$criteria->compare('external_account_billing_city',$this->external_account_billing_city,true);

		$criteria->compare('external_account_billing_state_province',$this->external_account_billing_state_province,true);

		$criteria->compare('external_account_billing_postal_code',$this->external_account_billing_postal_code,true);

		$criteria->compare('external_account_billing_country',$this->external_account_billing_country,true);

		$criteria->compare('external_account_business',$this->external_account_business);

		$criteria->compare('external_account_verification_status',$this->external_account_verification_status,true);

		$criteria->compare('external_account_status',$this->external_account_status,true);

		return new CActiveDataProvider('ExternalAccount', array(
			'criteria'=>$criteria,
		));
	}
}