<?php

/**
 * This is the model class for table "role".
 *
 * The followings are the available columns in table 'role':
 * @property string $role_id
 * @property string $role_name
 * @property string $role_description
 * @property integer $role_max_originator
 * @property integer $role_max_odfi
 * @property integer $role_max_daily_xfers
 * @property integer $role_max_daily_files
 * @property integer $role_max_daily_batches
 * @property integer $role_iat_enabled
 */
class Role extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Role the static model class
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
		return 'role';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('role_id, role_name', 'required'),
			array('role_max_originator, role_max_odfi, role_max_daily_xfers, role_max_daily_files, role_max_daily_batches, role_iat_enabled', 'numerical', 'integerOnly'=>true),
			array('role_id', 'length', 'max'=>36),
			array('role_name', 'length', 'max'=>16),
			array('role_description', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('role_id, role_name, role_description, role_max_originator, role_max_odfi, role_max_daily_xfers, role_max_daily_files, role_max_daily_batches, role_iat_enabled', 'safe', 'on'=>'search'),
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
			'role_id' => 'Role',
			'role_name' => 'Role Name',
			'role_description' => 'Role Description',
			'role_max_originator' => 'Role Max Originator',
			'role_max_odfi' => 'Role Max Odfi',
			'role_max_daily_xfers' => 'Role Max Daily Xfers',
			'role_max_daily_files' => 'Role Max Daily Files',
			'role_max_daily_batches' => 'Role Max Daily Batches',
			'role_iat_enabled' => 'Role Iat Enabled',
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

		$criteria->compare('role_id',$this->role_id,true);

		$criteria->compare('role_name',$this->role_name,true);

		$criteria->compare('role_description',$this->role_description,true);

		$criteria->compare('role_max_originator',$this->role_max_originator);

		$criteria->compare('role_max_odfi',$this->role_max_odfi);

		$criteria->compare('role_max_daily_xfers',$this->role_max_daily_xfers);

		$criteria->compare('role_max_daily_files',$this->role_max_daily_files);

		$criteria->compare('role_max_daily_batches',$this->role_max_daily_batches);

		$criteria->compare('role_iat_enabled',$this->role_iat_enabled);

		return new CActiveDataProvider('Role', array(
			'criteria'=>$criteria,
		));
	}
}