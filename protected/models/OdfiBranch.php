<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

/**
 * This is the model class for table "odfi_branch".
 *
 * The followings are the available columns in table 'odfi_branch':
 * @property string $odfi_branch_id
 * @property string $odfi_branch_datetime
 * @property string $odfi_branch_originator_id
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
class OdfiBranch extends OADataSource
{

	// Set default plugin as manual
	public $odfi_branch_plugin = 'Manual';
	// Set default DFI Id Qualifier as ABA Routing Number
	public $odfi_branch_dfi_id_qualifier = '01';

	public $bank_config;

	/**
	 * Returns the static model of the specified AR class.
	 * @return OdfiBranch the static model class
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
			array('odfi_branch_id, odfi_branch_originator_id, odfi_branch_name, odfi_branch_friendly_name, odfi_branch_dfi_id, odfi_branch_plugin', 'required'),
			array('odfi_branch_id, odfi_branch_originator_id', 'length', 'max'=>36),
			array('odfi_branch_friendly_name', 'length', 'max'=>50),
			array('odfi_branch_name, odfi_branch_city, odfi_branch_state_province', 'length', 'max'=>35),
			array('odfi_branch_country_code, odfi_branch_dfi_id_qualifier', 'length', 'max'=>2),
			array('odfi_branch_dfi_id', 'length', 'max'=>125),
			array('odfi_branch_go_dfi_id', 'length', 'max'=>9),
			array('odfi_branch_status', 'length', 'max'=>8),
			array('odfi_branch_status', 'default', 'value'=>'enabled', 'on'=>'save'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('odfi_branch_id, odfi_branch_datetime, odfi_branch_originator_id, odfi_branch_friendly_name, odfi_branch_name, odfi_branch_city, odfi_branch_state_province, odfi_branch_country_code, odfi_branch_dfi_id, odfi_branch_dfi_id_qualifier, odfi_branch_go_dfi_id, odfi_branch_status', 'safe', 'on'=>'search'),
			// On Save, check that the originator_id hasn't changed
			array('odfi_branch_originator_id', 'compare', 'compareAttribute'=>'odfi_branch_originator_id', 'on'=>'save'),
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
			'originator' => array(
					self::BELONGS_TO,
					'Originator',
					'odfi_branch_originator_id'
				),
			'ach_files' => array(
					self::HAS_MANY,
					'AchFile',
					'ach_file_odfi_branch_id'
				),
			'ach_entries' => array(
					self::HAS_MANY,
					'AchEntry',
					'ach_entry_odfi_branch_id'
				),
			'originator_info' => array(
					self::HAS_MANY,
					'OriginatorInfo',
					'originator_info_odfi_branch_id',
				),
			'settlements' => array(
					self::HAS_MANY,
					'Settlement',
					'settlement_odfi_branch_id'
				),

		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'odfi_branch_id' => 'Odfi Branch',
			'odfi_branch_datetime' => 'Datetime',
			'odfi_branch_originator_id' => 'Originator',
			'odfi_branch_friendly_name' => 'Friendly Name',
			'odfi_branch_name' => 'Bank Name',
			'odfi_branch_city' => 'City',
			'odfi_branch_state_province' => 'State/Province',
			'odfi_branch_country_code' => 'Country',
			'odfi_branch_dfi_id' => 'Routing/SWIFT Identifier',
			'odfi_branch_dfi_id_qualifier' => 'Identifier Type',
			'odfi_branch_go_dfi_id' => 'IAT Gateway',
			'odfi_branch_status' => 'Status',
			'odfi_branch_plugin' => 'OpenACH Bank Plugin',
		);
	}

	public function behaviors(){
		return array(
			'CEncryptionBehavior' => array(
				'class' => 'application.behaviors.CEncryptionBehavior',
				'attributeList' => array (
					'odfi_branch_dfi_id'	=> 'crypt',
				),
			),
			'CUuidKeyBehavior' => array(
				'class' => 'application.behaviors.CUuidKeyBehavior',
				'attributeList' => array (
					'odfi_branch_id',
				),
			),
                        'CActiveLogBehavior' => array(
                                'class' => 'application.behaviors.CActiveLogBehavior',
                                'attributeList' => array (
					'odfi_branch_id',
					'odfi_branch_friendly_name',
					'odfi_branch_name',
					'odfi_branch_city',
					'odfi_branch_state_province',
					'odfi_branch_country_code',
					'odfi_branch_dfi_id',
					'odfi_branch_dfi_id_qualifier',
					'odfi_branch_go_dfi_id',
					'odfi_branch_status',
					'odfi_branch_plugin',
				),
			),
			'CValidateOwnershipBehavior' => array(
				'class' => 'application.behaviors.CValidateOwnershipBehavior',
				'modelList' => array (
					'Originator' => 'odfi_branch_originator_id',
				),
			),
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
		$criteria->compare('odfi_branch_originator_id',$this->odfi_branch_originator_id,true);
		$criteria->compare('odfi_branch_friendly_name',$this->odfi_branch_friendly_name,true);
		$criteria->compare('odfi_branch_name',$this->odfi_branch_name,true);
		$criteria->compare('odfi_branch_city',$this->odfi_branch_city,true);
		$criteria->compare('odfi_branch_state_province',$this->odfi_branch_state_province,true);
		$criteria->compare('odfi_branch_country_code',$this->odfi_branch_country_code,true);
		$criteria->compare('odfi_branch_dfi_id',$this->odfi_branch_dfi_id,true);
		$criteria->compare('odfi_branch_dfi_id_qualifier',$this->odfi_branch_dfi_id_qualifier,true);
		$criteria->compare('odfi_branch_go_dfi_id',$this->odfi_branch_go_dfi_id,true);
		$criteria->compare('odfi_branch_status',$this->odfi_branch_status,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}

	public static function addUserJoin( CDbCriteria $criteria )
	{
		$criteria->join .= ' INNER JOIN originator ON ( originator_id = odfi_branch_originator_id ) ';
		Originator::addUserJoin( $criteria );
	}

	public function getCountryCodeOptions()
	{
		return Yii::app()->params['Country']['Payment'];
	}

	public function getDfiIdQualifierOptions()
	{
		return Yii::app()->params['AchEntry']['DfiIdQulifiers'];
	}

	public function getBankPluginOptions()
	{
		return Yii::app()->params['BankPlugins'];
	}

	public function displayAddress()
	{
		return $this->odfi_branch_city . ', ' . $this->odfi_branch_state_province . ' ' . $this->odfi_branch_country_code;
	}

	public function displayRoutingNumber()
	{
		if ( $this->odfi_branch_dfi_id_qualifier == '01' )
		{
			return $this->odfi_branch_dfi_id;
		}
		else
		{
			return 'SWIFT #' . $this->odfi_branch_dfi_id;
		}
	}

	public function displayStatus()
	{
		return 'Bank Status: ' . ucfirst( $this->odfi_branch_status );
	}

	public function displayPlugin()
	{
		return 'Using Plugin: ' . ucfirst( $this->odfi_branch_plugin );
	}

	public function displayOriginationInfoCount()
	{
		return 'Total Accounts: ' . count( $this->originator_info );
	}

	public function displayGatewayDfi()
	{
		if ( $this->odfi_branch_go_dfi_id )
		{
			return 'IAT Gateway ' . $this->odfi_branch_go_dfi_id;
		}
		else
		{
			'No IAT Gateway';
		}
	}

	public function getViewPath()
	{
		return '/odfiBranch';
	}

	public function onAfterFind($event)
	{
		parent::onAfterFind($event);
		$this->bank_config = $this->getBankConfig();
	}

	public function onAfterSave($event)
	{
		parent::onAfterSave($event);
		$this->bank_config = $this->getBankConfig();
		$this->bank_config->store( $this->odfi_branch_id );
	}

	public function getBankConfig()
	{
		return OABank::factory( $this );
	}

}
