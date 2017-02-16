<?php

/**
 * This is the model class for table "fedach".
 *
 * The followings are the available columns in table 'fedach':
 * @property string $fedach_routing_number
 * @property string $fedach_office_code
 * @property string $fedach_servicing_frb_number
 * @property string $fedach_record_type_code
 * @property string $fedach_change_date
 * @property string $fedach_new_routing_number
 * @property string $fedach_customer_name
 * @property string $fedach_address
 * @property string $fedach_city
 * @property string $fedach_state_province
 * @property string $fedach_postal_code
 * @property string $fedach_postal_code_extension
 * @property string $fedach_phone_number
 * @property string $fedach_institution_status_code
 * @property string $fedach_data_view_code
 */
class FedACH extends OADataSource
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return FedACH the static model class
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
		return 'fedach';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('fedach_routing_number, fedach_office_code, fedach_servicing_frb_number, fedach_record_type_code, fedach_change_date, fedach_new_routing_number, fedach_customer_name, fedach_address, fedach_city, fedach_institution_status_code, fedach_data_view_code', 'required'),
			array('fedach_routing_number, fedach_servicing_frb_number, fedach_new_routing_number', 'length', 'max'=>9),
			array('fedach_office_code, fedach_record_type_code, fedach_institution_status_code, fedach_data_view_code', 'length', 'max'=>1),
			array('fedach_change_date', 'length', 'max'=>6),
			array('fedach_customer_name, fedach_address', 'length', 'max'=>36),
			array('fedach_city', 'length', 'max'=>20),
			array('fedach_state_province', 'length', 'max'=>2),
			array('fedach_postal_code', 'length', 'max'=>5),
			array('fedach_postal_code_extension', 'length', 'max'=>4),
			array('fedach_phone_number', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('fedach_routing_number, fedach_office_code, fedach_servicing_frb_number, fedach_record_type_code, fedach_change_date, fedach_new_routing_number, fedach_customer_name, fedach_address, fedach_city, fedach_state_province, fedach_postal_code, fedach_postal_code_extension, fedach_phone_number, fedach_institution_status_code, fedach_data_view_code', 'safe', 'on'=>'search'),
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
			'fedach_routing_number' => 'Fedach Routing Number',
			'fedach_office_code' => 'Fedach Office Code',
			'fedach_servicing_frb_number' => 'Fedach Servicing Frb Number',
			'fedach_record_type_code' => 'Fedach Record Type Code',
			'fedach_change_date' => 'Fedach Change Date',
			'fedach_new_routing_number' => 'Fedach New Routing Number',
			'fedach_customer_name' => 'Fedach Customer Name',
			'fedach_address' => 'Fedach Address',
			'fedach_city' => 'Fedach City',
			'fedach_state_province' => 'Fedach State Province',
			'fedach_postal_code' => 'Fedach Postal Code',
			'fedach_postal_code_extension' => 'Fedach Postal Code Extension',
			'fedach_phone_number' => 'Fedach Phone Number',
			'fedach_institution_status_code' => 'Fedach Institution Status Code',
			'fedach_data_view_code' => 'Fedach Data View Code',
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

		$criteria->compare('fedach_routing_number',$this->fedach_routing_number,true);
		$criteria->compare('fedach_office_code',$this->fedach_office_code,true);
		$criteria->compare('fedach_servicing_frb_number',$this->fedach_servicing_frb_number,true);
		$criteria->compare('fedach_record_type_code',$this->fedach_record_type_code,true);
		$criteria->compare('fedach_change_date',$this->fedach_change_date,true);
		$criteria->compare('fedach_new_routing_number',$this->fedach_new_routing_number,true);
		$criteria->compare('fedach_customer_name',$this->fedach_customer_name,true);
		$criteria->compare('fedach_address',$this->fedach_address,true);
		$criteria->compare('fedach_city',$this->fedach_city,true);
		$criteria->compare('fedach_state_province',$this->fedach_state_province,true);
		$criteria->compare('fedach_postal_code',$this->fedach_postal_code,true);
		$criteria->compare('fedach_postal_code_extension',$this->fedach_postal_code_extension,true);
		$criteria->compare('fedach_phone_number',$this->fedach_phone_number,true);
		$criteria->compare('fedach_institution_status_code',$this->fedach_institution_status_code,true);
		$criteria->compare('fedach_data_view_code',$this->fedach_data_view_code,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
