<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

/**
 * This is the model class for table "external_account".
 *
 * The followings are the available columns in table 'external_account':
 * @property string $external_account_id
 * @property string $external_account_datetime
 * @property string $external_account_payment_profile_id
 * @property string $external_account_type
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
 * @property bool $external_account_allow_originator_payments
 * @property string $external_account_originator_info_id
 */
class ExternalAccount extends OADataSource
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
			array('external_account_id, external_account_datetime, external_account_type, external_account_holder, external_account_dfi_id, external_account_number', 'required'),
			array('external_account_business', 'numerical', 'integerOnly'=>true),
			//array('external_account_allow_originator_payments', 'boolean' ),
			array('external_account_id, external_account_payment_profile_id, external_account_originator_info_id', 'length', 'max'=>36),
			array('external_account_name, external_account_bank, external_account_holder, external_account_dfi_id, external_account_number', 'length', 'max'=>125),
			array('external_account_country_code, external_account_dfi_id_qualifier, external_account_billing_country', 'length', 'max'=>2),
			array('external_account_billing_address, external_account_billing_city, external_account_billing_state_province, external_account_billing_postal_code', 'length', 'max'=>35),
			array('external_account_verification_status', 'length', 'max'=>9),
			array('external_account_status', 'length', 'max'=>7),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('external_account_id, external_account_datetime, external_account_payment_profile_id, external_account_name, external_account_bank, external_account_holder, external_account_country_code, external_account_dfi_id, external_account_dfi_id_qualifier, external_account_number, external_account_billing_address, external_account_billing_city, external_account_billing_state_province, external_account_billing_postal_code, external_account_billing_country, external_account_business, external_account_verification_status, external_account_status', 'safe', 'on'=>'search'),
			array('external_account_type', 'in', 'range'=>array('checking','savings'),'allowEmpty'=>false,'message'=>'External account type must be one of ("checking","savings")'),
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
			'payment_profile' => array(
					self::BELONGS_TO,
					'PaymentProfile',
					'external_account_payment_profile_id'
				),
			'ach_entries' => array (
					self::HAS_MANY,
					'AchEntry',
					'ach_entry_external_account_id'
				),
			'payment_schedules' => array(
					self::HAS_MANY,
					'PaymentSchedule',
					'payment_schedule_external_account_id',
					'alias' => 'payment_schedule',
				),
			'originator_info' => array(
					self::BELONGS_TO,
					'OriginatorInfo',
					'external_account_originator_info_id'
				),
			//'originator_info' => array(
			//		self::MANY_MANY,
			//		'OriginatorInfo',
			//		'originator_info_external_account(external_account_id,originator_info_id)',
			//	),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'external_account_id' => 'External Account',
			'external_account_datetime' => 'Datetime',
			'external_account_payment_profile_id' => 'Payment Profile',
			'external_account_type' => 'Account Type',
			'external_account_name' => 'Friendly Name',
			'external_account_bank' => 'Bank Name',
			'external_account_holder' => 'Account Holder',
			'external_account_country_code' => 'Country Code',
			'external_account_dfi_id' => 'Routing Number',
			'external_account_dfi_id_qualifier' => 'Routing Number Type',
			'external_account_number' => 'Account Number',
			'external_account_billing_address' => 'Address',
			'external_account_billing_city' => 'City',
			'external_account_billing_state_province' => 'State Province',
			'external_account_billing_postal_code' => 'Postal Code',
			'external_account_billing_country' => 'Country',
			'external_account_business' => 'Business Account',
			'external_account_verification_status' => 'Verification Status',
			'external_account_status' => 'Status',
		);
	}

	public function apiFields()
	{
		return array(
			'external_account_id' => array('read','summary'),
			'external_account_payment_profile_id' => 'read',
			'external_account_type' => array('edit','summary'),
			'external_account_name' => array('edit','summary'),
			'external_account_bank' => array('edit','summary'),
			'external_account_holder' => array('edit','summary'),
			'external_account_country_code' => 'edit',
			'external_account_dfi_id' => array('edit','summary'),
			'external_account_number' => array('edit','summary'),
			'external_account_billing_address' => 'edit',
			'external_account_billing_city' => 'edit',
			'external_account_billing_state_province' => 'edit',
			'external_account_billing_postal_code' => 'edit',
			'external_account_billing_country' => 'edit',
			'external_account_business' => 'edit',
			'external_account_verification_status' => 'read',
			'external_account_status' => 'read',
		);
	}

	public function maskFields()
	{
		return array(
			'external_account_dfi_id',
			'external_account_number',
		);
	}

	public function behaviors(){
		return array(
			'CEncryptionBehavior' => array(
				'class' => 'application.behaviors.CEncryptionBehavior',
				'attributeList' => array (
					'external_account_holder'	=> 'crypt',
					'external_account_bank'		=> 'crypt',
					'external_account_dfi_id'	=> 'crypt',
					'external_account_number'	=> 'crypt',
					'external_account_billing_address'	=> 'crypt',
					'external_account_billing_city'		=> 'crypt',
				),
			),
			'CUuidKeyBehavior' => array(
				'class' => 'application.behaviors.CUuidKeyBehavior',
				'attributeList' => array (
					'external_account_id',
				),
			),
			'CDatetimeBehavior' => array(
				'class' => 'application.behaviors.CDatetimeBehavior',
				'attributeList' => array(
					'external_account_datetime',
				),
			),
                        'CActiveLogBehavior' => array(
                                'class' => 'application.behaviors.CActiveLogBehavior',
                                'attributeList' => array (
					'external_account_id',
					'external_account_payment_profile_id',
					'external_account_type',
					'external_account_name',
					'external_account_bank',
					'external_account_holder',
					'external_account_country_code',
					'external_account_dfi_id',
					'external_account_dfi_id_qualifier',
					'external_account_number',
					'external_account_billing_address',
					'external_account_billing_city',
					'external_account_billing_state_province',
					'external_account_billing_postal_code',
					'external_account_billing_country',
					'external_account_business',
					'external_account_verification_status',
					'external_account_status',
				),
			),
			'CValidateOwnershipBehavior' => array(
				'class' => 'application.behaviors.CValidateOwnershipBehavior',
				'modelList' => array (
					'PaymentProfile' => 'external_account_payment_profile_id',
					'OriginatorInfo' => 'external_account_originator_info_id',
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
		$criteria->compare('external_account_id',$this->external_account_id,true);
		$criteria->compare('external_account_datetime',$this->external_account_datetime,true);
		$criteria->compare('external_account_type',$this->external_account_type,true);
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

	public static function addUserJoin( CDbCriteria $criteria )
	{
		$criteria->join .= ' INNER JOIN payment_profile ON ( payment_profile_id = external_account_payment_profile_id ) ';
		PaymentProfile::addUserJoin( $criteria );
	}

	public function getDfiIdWithoutCheckDigit()
	{
		if ( strlen( $this->external_account_dfi_id ) == 9 )
		{
			return substr( $this->external_account_dfi_id, 0, 8 );
		}
		else
		{
			return '';
		}
	}

	public function getDfiIdCheckDigit()
	{
		if ( strlen( $this->external_account_dfi_id ) == 9 )
		{
			return substr( $this->external_account_dfi_id, -1 );
		}
		else
		{
			return '';
		}
	}

	public function displayBankName()
	{
		return $this->external_account_bank;
	}

	public function displayAccountNumber()
	{
		return 'Account ending with ' . substr( $this->external_account_number, -4 );
	}

	public function hasAddress()
	{
		return  ( $this->external_account_billing_address
			&& $this->external_account_billing_city
			&& $this->external_account_billing_state_province
			&& $this->external_account_billing_postal_code
			&& $this->external_account_billing_country );
	}

	public function displayAddress()
	{
		return  $this->external_account_billing_address . '<br />' .
			$this->external_account_billing_city . ', ' .
                        $this->external_account_billing_state_province . ' ' .
                        $this->external_account_billing_postal_code . ' ' .
                        $this->external_account_billing_country;
	}

	public function displayRoutingNumber()
	{
		if ( $this->external_account_dfi_id_qualifier == '01' )
		{
			return 'Routing Number: ' . $this->external_account_dfi_id;
		}
		else
		{
			return 'SWIFT #' . $this->external_account_dfi_id;
		}
	}

	public function displayStatus()
	{
		return 'Status: ' . ucfirst( $this->external_account_status );
	}

	public function displayAccountType()
	{
		return 'Type: ' . ( $this->external_account_business ? 'Business ' : 'Personal ' ) . ucfirst( $this->external_account_type );
	}

	public function displayCountry()
	{
		return 'Bank Country: ' . $this->external_account_country_code;
	}

	public function getCountryCodeOptions()
	{
		return Yii::app()->params['Country']['Payment'];
	}

	public function getDfiIdQualifierOptions()
	{
		return Yii::app()->params['AchEntry']['DfiIdQulifiers'];
	}

	// For this external account, return the correct AchEntry Transaction Code, given the amount
	// Positive amounts are debits, negative amounts are credits
	public function getAchEntryTransactionCode( $transaction_type )
	{
		$codes = array();
		$codes['credit']['checking']	= '22';
		$codes['debit']['checking']	= '27';
		$codes['credit']['savings']	= '32';
		$codes['debit']['savings']	= '37';

		return $codes[$transaction_type][$this->external_account_type];
	}

	public function verifyOriginatorInfoOwnership( $originatorInfoId )
	{
		// There is no originator info for this id
		if ( ! $originatorInfo = OriginatorInfo::model()->findByPk( $originatorInfoId ) )
		{
			return false;
		}

		$user = Yii::app()->user->model();
		// There is no user
		if ( ! $user )
		{
			return false;
		}

		// The originator info isn't linked to an originator
		if ( ! $originatorInfo->originator )
		{
			return false;
		}

		return true;
	}

	public function mask()
	{
		foreach ( $this->maskFields() as $field )
		{
			if ( ! isset( $this->{$field} ) )
			{
				continue;
			}
			$value = $this->{$field};
			for ( $i = 0; $i < strlen( $value ) - 4; $i++ )
			{
				$value[$i] = 'X';
			}
			$this->{$field} = $value;
		}
	}

	public static function accountExists( $payment_profile_id, $routing_number, $account_number )
	{
		$criteria = new CDbCriteria();
		$criteria->addCondition( 'external_account_payment_profile_id = :payment_profile_id' );
		$criteria->join = 'LEFT JOIN payment_profile ON payment_profile_id = external_account_payment_profile_id ';
		$criteria->params = array( ':payment_profile_id' => $payment_profile_id );
		
		$externalAccounts = ExternalAccount::model()->findAll( $criteria );

		foreach ( $externalAccounts as $externalAccount )
		{
			if ( $externalAccount->external_account_dfi_id == $routing_number 
				&& $externalAccount->external_account_number == $account_number )
			{
				return $externalAccount;
			}
		}
		return false;
	}

}
