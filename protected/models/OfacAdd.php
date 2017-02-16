<?php

/**
 * This is the model class for table "ofac_add".
 *
 * The followings are the available columns in table 'ofac_add':
 * @property integer $ofac_add_ent_num
 * @property integer $ofac_add_num
 * @property string $ofac_add_address
 * @property string $ofac_add_city
 * @property string $ofac_add_state_province
 * @property string $ofac_add_postal_code
 * @property string $ofac_add_country
 * @property string $ofac_add_remarks
 */
class OfacAdd extends OADataSource
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return OfacAdd the static model class
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
		return 'ofac_add';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ofac_add_ent_num, ofac_add_num', 'required' ),
			array('ofac_add_ent_num, ofac_add_num', 'numerical', 'integerOnly'=>true),
			array('ofac_add_address', 'length', 'max'=>750),
			array('ofac_add_city, ofac_add_state_province, ofac_add_postal_code', 'length', 'max'=>116),
			array('ofac_add_country', 'length', 'max'=>250),
			array('ofac_add_remarks', 'length', 'max'=>200),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('ofac_add_ent_num, ofac_add_num, ofac_add_address, ofac_add_city, ofac_add_state_province, ofac_add_postal_code, ofac_add_country, ofac_add_remarks', 'safe', 'on'=>'search'),
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
			'ofac_add_ent_num' => 'Ofac Add Ent Num',
			'ofac_add_num' => 'Ofac Add Num',
			'ofac_add_address' => 'Ofac Add Address',
			'ofac_add_city' => 'Ofac Add City',
			'ofac_add_state_province' => 'Ofac Add State Province',
			'ofac_add_postal_code' => 'Ofac Add Postal Code',
			'ofac_add_country' => 'Ofac Add Country',
			'ofac_add_remarks' => 'Ofac Add Remarks',
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

		$criteria->compare('ofac_add_ent_num',$this->ofac_add_ent_num);
		$criteria->compare('ofac_add_num',$this->ofac_add_num);
		$criteria->compare('ofac_add_address',$this->ofac_add_address,true);
		$criteria->compare('ofac_add_city',$this->ofac_add_city,true);
		$criteria->compare('ofac_add_state_province',$this->ofac_add_state_province,true);
		$criteria->compare('ofac_add_postal_code',$this->ofac_add_postal_code,true);
		$criteria->compare('ofac_add_country',$this->ofac_add_country,true);
		$criteria->compare('ofac_add_remarks',$this->ofac_add_remarks,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
