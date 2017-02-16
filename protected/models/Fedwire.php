<?php

/**
 * This is the model class for table "fedwire".
 *
 * The followings are the available columns in table 'fedwire':
 * @property string $fedwire_routing_number
 * @property string $fedwire_telegraphic_name
 * @property string $fedwire_customer_name
 * @property string $fedwire_state_province
 * @property string $fedwire_city
 * @property string $fedwire_funds_transfer_status
 * @property string $fedwire_settlement_only_status
 * @property string $fedwire_securities_transfer_status
 * @property string $fedwire_revision_date
 */
class Fedwire extends OADataSource
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Fedwire the static model class
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
		return 'fedwire';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('fedwire_routing_number, fedwire_telegraphic_name, fedwire_customer_name, fedwire_funds_transfer_status, fedwire_securities_transfer_status', 'required'),
			array('fedwire_routing_number', 'length', 'max'=>9),
			array('fedwire_telegraphic_name', 'length', 'max'=>18),
			array('fedwire_customer_name', 'length', 'max'=>36),
			array('fedwire_state_province', 'length', 'max'=>2),
			array('fedwire_city', 'length', 'max'=>25),
			array('fedwire_funds_transfer_status, fedwire_settlement_only_status, fedwire_securities_transfer_status', 'length', 'max'=>1),
			array('fedwire_revision_date', 'length', 'max'=>8),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('fedwire_routing_number, fedwire_telegraphic_name, fedwire_customer_name, fedwire_state_province, fedwire_city, fedwire_funds_transfer_status, fedwire_settlement_only_status, fedwire_securities_transfer_status, fedwire_revision_date', 'safe', 'on'=>'search'),
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
			'fedwire_routing_number' => 'Fedwire Routing Number',
			'fedwire_telegraphic_name' => 'Fedwire Telegraphic Name',
			'fedwire_customer_name' => 'Fedwire Customer Name',
			'fedwire_state_province' => 'Fedwire State Province',
			'fedwire_city' => 'Fedwire City',
			'fedwire_funds_transfer_status' => 'Fedwire Funds Transfer Status',
			'fedwire_settlement_only_status' => 'Fedwire Settlement Only Status',
			'fedwire_securities_transfer_status' => 'Fedwire Securities Transfer Status',
			'fedwire_revision_date' => 'Fedwire Revision Date',
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

		$criteria->compare('fedwire_routing_number',$this->fedwire_routing_number,true);
		$criteria->compare('fedwire_telegraphic_name',$this->fedwire_telegraphic_name,true);
		$criteria->compare('fedwire_customer_name',$this->fedwire_customer_name,true);
		$criteria->compare('fedwire_state_province',$this->fedwire_state_province,true);
		$criteria->compare('fedwire_city',$this->fedwire_city,true);
		$criteria->compare('fedwire_funds_transfer_status',$this->fedwire_funds_transfer_status,true);
		$criteria->compare('fedwire_settlement_only_status',$this->fedwire_settlement_only_status,true);
		$criteria->compare('fedwire_securities_transfer_status',$this->fedwire_securities_transfer_status,true);
		$criteria->compare('fedwire_revision_date',$this->fedwire_revision_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
