<?php

/**
 * This is the model class for table "odfi_branch".
 *
 * The followings are the available columns in table 'odfi_branch':
 * @property string $odfi_branch_id
 * @property string $odfi_branch_datetime
 * @property string $odfi_branch_odfi_branch_id
 * @property string $odfi_branch_friendly_name
 * @property string $odfi_branch_name
 * @property string $odfi_branch_city
 * @property string $odfi_branch_state_province
 * @property string $odfi_branch_country_code
 * @property string $odfi_branch_dfi_id
 * @property string $odfi_branch_dfi_id_qualifier
 * @property string $odfi_branch_go_dfi_id
 * @property string $odfi_branch_status
 */
class ODFIBranch extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return ODFIBranch the static model class
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
		return 'odfi_branch';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('odfi_branch_id, odfi_branch_datetime, odfi_branch_odfi_branch_id', 'required'),
			array('odfi_branch_id, odfi_branch_odfi_branch_id', 'length', 'max'=>36),
			array('odfi_branch_friendly_name', 'length', 'max'=>50),
			array('odfi_branch_name, odfi_branch_city, odfi_branch_state_province', 'length', 'max'=>35),
			array('odfi_branch_country_code, odfi_branch_dfi_id_qualifier', 'length', 'max'=>2),
			array('odfi_branch_dfi_id', 'length', 'max'=>125),
			array('odfi_branch_go_dfi_id', 'length', 'max'=>9),
			array('odfi_branch_status', 'length', 'max'=>8),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('odfi_branch_id, odfi_branch_datetime, odfi_branch_odfi_branch_id, odfi_branch_friendly_name, odfi_branch_name, odfi_branch_city, odfi_branch_state_province, odfi_branch_country_code, odfi_branch_dfi_id, odfi_branch_dfi_id_qualifier, odfi_branch_go_dfi_id, odfi_branch_status', 'safe', 'on'=>'search'),
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
			'odfi_branch_id' => 'Odfi Branch',
			'odfi_branch_datetime' => 'Odfi Branch Datetime',
			'odfi_branch_odfi_branch_id' => 'Odfi Branch Odfi Branch',
			'odfi_branch_friendly_name' => 'Odfi Branch Friendly Name',
			'odfi_branch_name' => 'Odfi Branch Name',
			'odfi_branch_city' => 'Odfi Branch City',
			'odfi_branch_state_province' => 'Odfi Branch State Province',
			'odfi_branch_country_code' => 'Odfi Branch Country Code',
			'odfi_branch_dfi_id' => 'Odfi Branch Dfi',
			'odfi_branch_dfi_id_qualifier' => 'Odfi Branch Dfi Id Qualifier',
			'odfi_branch_go_dfi_id' => 'Odfi Branch Go Dfi',
			'odfi_branch_status' => 'Odfi Branch Status',
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

		$criteria->compare('odfi_branch_id',$this->odfi_branch_id,true);

		$criteria->compare('odfi_branch_datetime',$this->odfi_branch_datetime,true);

		$criteria->compare('odfi_branch_odfi_branch_id',$this->odfi_branch_odfi_branch_id,true);

		$criteria->compare('odfi_branch_friendly_name',$this->odfi_branch_friendly_name,true);

		$criteria->compare('odfi_branch_name',$this->odfi_branch_name,true);

		$criteria->compare('odfi_branch_city',$this->odfi_branch_city,true);

		$criteria->compare('odfi_branch_state_province',$this->odfi_branch_state_province,true);

		$criteria->compare('odfi_branch_country_code',$this->odfi_branch_country_code,true);

		$criteria->compare('odfi_branch_dfi_id',$this->odfi_branch_dfi_id,true);

		$criteria->compare('odfi_branch_dfi_id_qualifier',$this->odfi_branch_dfi_id_qualifier,true);

		$criteria->compare('odfi_branch_go_dfi_id',$this->odfi_branch_go_dfi_id,true);

		$criteria->compare('odfi_branch_status',$this->odfi_branch_status,true);

		return new CActiveDataProvider('ODFIBranch', array(
			'criteria'=>$criteria,
		));
	}
}