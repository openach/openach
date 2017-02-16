<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

/**
 * This is the model class for table "originator_info".
 *
 * The followings are the available columns in table 'originator_info':
 * @property string $originator_info_id
 * @property string $originator_info_datetime
 * @property string $originator_info_odfi_branch_id
 * @property string $originator_info_originator_id
 * @property string $originator_info_name
 * @property string $originator_info_description
 * @property string $originator_info_identification
 * @property string $originator_info_address
 * @property string $originator_info_city
 * @property string $originator_info_state_province
 * @property string $originator_info_postal_code
 * @property string $originator_info_country_code
 */
class OriginatorInfo extends OADataSource
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return OriginatorInfo the static model class
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
		return 'originator_info';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('originator_info_id, originator_info_name, originator_info_odfi_branch_id, originator_info_originator_id', 'required'),
			array('originator_info_id, originator_info_odfi_branch_id, originator_info_originator_id', 'length', 'max'=>36),
			array('originator_info_name', 'length', 'max'=>16),
			array('originator_info_identification', 'length', 'max'=>10),
			array('originator_info_address, originator_info_city, originator_info_state_province, originator_info_postal_code', 'length', 'max'=>35),
			array('originator_info_country_code', 'length', 'max'=>2),
			array('originator_info_description', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('originator_info_id, originator_info_datetime, originator_info_odfi_branch_id, originator_info_originator_id, originator_info_name, originator_info_description, originator_info_identification, originator_info_address, originator_info_city, originator_info_state_province, originator_info_postal_code, originator_info_country_code', 'safe', 'on'=>'search'),
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
					'originator_info_originator_id'
				),
			'odfi_branch' => array(
					self::BELONGS_TO,
					'OdfiBranch',
					'originator_info_odfi_branch_id'
				),
			'ach_file' => array(
					self::HAS_MANY,
					'AchFile',
					'ach_file_originator_info_id'
				),
			'ach_batches' => array(
					self::HAS_MANY,
					'AchBatch',
					'ach_batch_originator_info_id'
				),
			'payment_profile' => array(
					self::HAS_MANY,
					'PaymentProfile',
					'payment_profile_originator_info_id'
				),
			'payment_types' => array(
					self::HAS_MANY,
					'PaymentType',
					'payment_type_originator_info_id'
				),
			'external_accounts' => array(
					self::HAS_MANY,
					'ExternalAccount',
					'external_account_originator_info_id'
				),
			'settlements' => array(
					self::HAS_MANY,
					'Settlement',
					'settlement_originator_info_id'
				),

		);
	}

	public function behaviors(){
		return array(
			'CUuidKeyBehavior' => array(
				'class' => 'application.behaviors.CUuidKeyBehavior',
				'attributeList' => array (
					'originator_info_id',
				),
			),
			// Hashed data is used for freeSearch to enable searching on encrypted values
			'CHashDataBehavior' => array(
				'class' => 'application.behaviors.CHashDataBehavior',
				'attributeList' => array(
					'originator_info_name'    =>      array(
						'method' => 'sha1',
						'target' => 'originator_info_name_hash',
					),
					'originator_info_identification'	=> array(
						'method' => 'sha1',
						'target' => 'originator_info_identification_hash',
					),
				),
			),
			'CPhoneticDataBehavior' => array(
				'class' => 'application.behaviors.CPhoneticDataBehavior',
				'attributeList' => array (
					array( 'attribute'=>'originator_info_name', 'dataType'=>'company', 'method'=>'soundex' ),
					array( 'attribute'=>'originator_info_name', 'dataType'=>'company', 'method'=>'nysiis' ),
					array( 'attribute'=>'originator_info_name', 'dataType'=>'company', 'method'=>'metaphone2' ),
				),
				'targetModel' => 'PhoneticData',
			),
			'CEncryptionBehavior' => array(
				'class' => 'application.behaviors.CEncryptionBehavior',
				'attributeList' => array (
					'originator_info_name'		=> 'crypt',
					'originator_info_description'	=> 'crypt',
					'originator_info_identification'      => 'crypt',
					'originator_info_address'	=> 'crypt',
				),
			),
                        'CActiveLogBehavior' => array(
                                'class' => 'application.behaviors.CActiveLogBehavior',
                                'attributeList' => array (
					'originator_info_id',
					'originator_info_odfi_branch_id',
					'originator_info_name',
					'originator_info_identification',
					'originator_info_address',
					'originator_info_city',
					'originator_info_state_province',
					'originator_info_postal_code',
					'originator_info_country_code',
				),
			),
			'CValidateOwnershipBehavior' => array(
				'class' => 'application.behaviors.CValidateOwnershipBehavior',
				'modelList' => array (
					'OdfiBranch' => 'originator_info_odfi_branch_id',
					'Originator' => 'originator_info_originator_id',
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
			'originator_info_id' => 'Originator Info',
			'originator_info_datetime' => 'Originator Info Datetime',
			'originator_info_odfi_branch_id' => 'Bank',
			'originator_info_originator_id' => 'Originator',
			'originator_info_name' => 'Business Name',
			'originator_info_description' => 'Description',
			'originator_info_identification' => 'Tax/Originator ID',
			'originator_info_address' => 'Business Street Address',
			'originator_info_city' => 'City',
			'originator_info_state_province' => 'State/Province',
			'originator_info_postal_code' => 'Postal Code',
			'originator_info_country_code' => 'Country',
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

		$criteria->compare('originator_info_id',$this->originator_info_id,true);
		$criteria->compare('originator_info_datetime',$this->originator_info_datetime,true);
		$criteria->compare('originator_info_odfi_branch_id',$this->originator_info_odfi_branch_id,true);
		$criteria->compare('originator_info_originator_id',$this->originator_info_originator_id,true);
		$criteria->compare('originator_info_name',$this->originator_info_name,true);
		$criteria->compare('originator_info_description',$this->originator_info_description,true);
		$criteria->compare('originator_info_identification',$this->originator_info_identification,true);
		$criteria->compare('originator_info_address',$this->originator_info_address,true);
		$criteria->compare('originator_info_city',$this->originator_info_city,true);
		$criteria->compare('originator_info_state_province',$this->originator_info_state_province,true);
		$criteria->compare('originator_info_postal_code',$this->originator_info_postal_code,true);
		$criteria->compare('originator_info_country_code',$this->originator_info_country_code,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}

	public function freeSearch( $query )
	{
		$keywords = explode( ' ', $query );
		
		$criteria = new OADbCriteria();

		foreach ( $keywords as $keyword )
		{
			$condition = array(
					'originator_info_name_hash' => sha1( strtolower( $keyword ) ),
					'originator_info_identification_hash' => sha1( strtolower( $keyword ) ),
				);
			$criteria->addColumnSearchCondition( $condition, 'OR' );
		}

		self::addUserJoin( $criteria );

		$criteria->limit = 20;

		return new CActiveDataProvider( $this, array( 'criteria'=>$criteria) );
	}

	public static function addUserJoin( CDbCriteria $criteria )
	{
		$criteria->join .= ' INNER JOIN originator ON ( originator_id = originator_info_originator_id ) ';
		Originator::addUserJoin( $criteria );
	}

	public function getCountryCodeOptions()
	{
		return Yii::app()->params['Country']['Payment'];
	}

	public function getPaymentTypeOptions()
	{
		$options = array();
		foreach ( $this->payment_types as $paymentType )
		{
			$options[ $paymentType->payment_type_id ] = $paymentType->payment_type_name;
		}
		return $options;
	}

	public function getExternalAccountOptions()
	{
		$options = array();
		foreach ( $this->external_accounts as $externalAccount )
		{
			$options[ $externalAccount->external_account_id ] = $externalAccount->external_account_name;
		}
		return $options;
	}

	public function displayAddress()
	{
		$display = '';
		$display .= $this->originator_info_address ? $this->originator_info_address . '<br />' : '';
		if ( $this->originator_info_city && $this->originator_info_state_province )
		{
			$display .= $this->originator_info_city . ', ' .
				$this->originator_info_state_province . ' ' .
				$this->originator_info_postal_code . ' ' .
				$this->originator_info_country_code;
		}
		return $display;
	}

	public function displayOdfiBranchName()
	{
		return $this->odfi_branch->odfi_branch_friendly_name;
	}

	public function displayIdentification()
	{
		return 'ID Ending with ' . substr( $this->originator_info_identification, -4 );
	}

	public function verifyOwnership()
	{
		$user = Yii::app()->user->model();
		if ( ! $user )
		{
			return false;
		}
		if ( $this->originator
			&& $this->originator->user
			&& $this->originator->user->user_id == $user->user_id )
		{
			return true;
		}
		return parent::verifyOwnership();
	}


}
