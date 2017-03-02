<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

/**
 * This is the model class for table "ach_entry".
 *
 * The followings are the available columns in table 'ach_entry':
 * @property string $ach_entry_id
 * @property string $ach_entry_datetime
 * @property string $ach_entry_status
 * @property string $ach_entry_ach_batch_id
 * @property string $ach_entry_odfi_branch_id
 * @property string $ach_entry_external_account_id
 * @property string $ach_entry_payment_schedule_id
 * @property string $ach_entry_detail_transaction_code
 * @property string $ach_entry_detail_receiving_dfi_id
 * @property string $ach_entry_detail_receiving_dfi_id_check_digit
 * @property string $ach_entry_detail_dfi_account_number
 * @property string $ach_entry_detail_amount
 * @property string $ach_entry_detail_individual_id_number
 * @property string $ach_entry_detail_individual_name
 * @property string $ach_entry_detail_discretionary_data
 * @property string $ach_entry_detail_addenda_record_indicator
 * @property string $ach_entry_detail_trace_number
 * @property string $ach_entry_addenda_type_code
 * @property string $ach_entry_addenda_payment_info
 * @property string $ach_entry_iat_go_receiving_dfi_id
 * @property string $ach_entry_iat_go_receiving_dfi_id_check_digit
 * @property string $ach_entry_iat_ofac_screening_indicator
 * @property string $ach_entry_iat_secondary_ofac_screening_indicator
 * @property string $ach_entry_iat_transaction_type_code
 * @property string $ach_entry_iat_foreign_trace_number
 * @property string $ach_entry_iat_originator_name
 * @property string $ach_entry_iat_originator_street_addr
 * @property string $ach_entry_iat_originator_city
 * @property string $ach_entry_iat_originator_state_province
 * @property string $ach_entry_iat_originator_postal_code
 * @property string $ach_entry_iat_originator_country
 * @property string $ach_entry_iat_originating_dfi_name
 * @property string $ach_entry_iat_originating_dfi_id
 * @property string $ach_entry_iat_originating_dfi_id_qualifier
 * @property string $ach_entry_iat_originating_dfi_country_code
 * @property string $ach_entry_iat_receiving_dfi_name
 * @property string $ach_entry_iat_receiving_dfi_id
 * @property string $ach_entry_iat_receiving_dfi_id_qualifier
 * @property string $ach_entry_iat_receiving_dfi_country_code
 * @property string $ach_entry_iat_receiver_street_addr
 * @property string $ach_entry_iat_receiver_city
 * @property string $ach_entry_iat_receiver_state_province
 * @property string $ach_entry_iat_receiver_postal_code
 * @property string $ach_entry_iat_receiver_country
 */
class AchEntry extends OADataSource
{

	public $ach_record_type_code = '6';
	public $ach_entry_detail_id = '';
        public $ach_entry_detail_addenda_count = 0;
        public $ach_addenda_type_code = '';
        public $reserved = '';
        public $ach_entry_detail_sequence_number = '';
	public $ach_entry_detail_addenda_record_indicator = '0';

	// These are for ODRecord->parse() using the OpenACH NACHA libraries to process return/change files
	public $ach_entry_return_reassigned_trace_number;
	public $ach_entry_return_date_of_death;
	public $ach_entry_return_original_dfi_id;
	public $ach_entry_return_trace_number;
	public $ach_entry_return_return_reason_code;
	public $ach_entry_return_change_code;
	public $ach_entry_return_corrected_data;
	public $ach_entry_return_addenda_information;

	// Used by this class implementation of merge()
	protected $foreignAttributes = array(
			'ach_entry_return_reassigned_trace_number',
			'ach_entry_return_date_of_death',
			'ach_entry_return_original_dfi_id',
			'ach_entry_return_trace_number',
			'ach_entry_return_return_reason_code',
			'ach_entry_return_change_code',
			'ach_entry_return_corrected_data',
			'ach_entry_return_addenda_information',
		);

        // These fields need to be added to the DB eventually, but we don't use them yet, so we'll settle for default values
        public $ach_entry_iat_foreign_payment_amount = '';

        public $ach_entry_status = 'pending';
	/**
	 * Returns the static model of the specified AR class.
	 * @return AchEntry the static model class
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
		return 'ach_entry';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ach_entry_id, ach_entry_odfi_branch_id, ach_entry_external_account_id', 'required'),
			array('ach_entry_id, ach_entry_ach_batch_id, ach_entry_odfi_branch_id, ach_entry_external_account_id, ach_entry_payment_schedule_id', 'length', 'max'=>36),
			array('ach_entry_status', 'length', 'max'=>10),
			array('ach_entry_detail_transaction_code, ach_entry_detail_discretionary_data, ach_entry_addenda_type_code, ach_entry_iat_originating_dfi_id_qualifier, ach_entry_iat_receiving_dfi_id_qualifier', 'length', 'max'=>2),
			array('ach_entry_detail_receiving_dfi_id, ach_entry_iat_go_receiving_dfi_id', 'length', 'max'=>8),
			array('ach_entry_detail_receiving_dfi_id_check_digit, ach_entry_detail_addenda_record_indicator, ach_entry_iat_go_receiving_dfi_id_check_digit, ach_entry_iat_ofac_screening_indicator, ach_entry_iat_secondary_ofac_screening_indicator', 'length', 'max'=>1),
			array('ach_entry_detail_dfi_account_number', 'length', 'max'=>17),
			array('ach_entry_detail_amount', 'length', 'max'=>18),
			array('ach_entry_detail_individual_id_number, ach_entry_detail_trace_number', 'length', 'max'=>15),
			array('ach_entry_detail_individual_name, ach_entry_iat_originator_name, ach_entry_iat_originator_street_addr, ach_entry_iat_originator_city, ach_entry_iat_originator_state_province, ach_entry_iat_originator_postal_code, ach_entry_iat_originator_country, ach_entry_iat_originating_dfi_name, ach_entry_iat_receiving_dfi_name, ach_entry_iat_receiver_street_addr, ach_entry_iat_receiver_city, ach_entry_iat_receiver_state_province, ach_entry_iat_receiver_postal_code, ach_entry_iat_receiver_country', 'length', 'max'=>35),
			array('ach_entry_addenda_payment_info', 'length', 'max'=>80),
			array('ach_entry_iat_transaction_type_code, ach_entry_iat_originating_dfi_country_code, ach_entry_iat_receiving_dfi_country_code', 'length', 'max'=>3),
			array('ach_entry_iat_foreign_trace_number', 'length', 'max'=>22),
			array('ach_entry_iat_originating_dfi_id, ach_entry_iat_receiving_dfi_id', 'length', 'max'=>34),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('ach_entry_id, ach_entry_datetime, ach_entry_status, ach_entry_ach_batch_id, ach_entry_odfi_branch_id, ach_entry_external_account_id, ach_entry_payment_schedule_id, ach_entry_detail_transaction_code, ach_entry_detail_receiving_dfi_id, ach_entry_detail_receiving_dfi_id_check_digit, ach_entry_detail_dfi_account_number, ach_entry_detail_amount, ach_entry_detail_individual_id_number, ach_entry_detail_individual_name, ach_entry_detail_discretionary_data, ach_entry_detail_addenda_record_indicator, ach_entry_detail_trace_number, ach_entry_addenda_type_code, ach_entry_addenda_payment_info, ach_entry_iat_go_receiving_dfi_id, ach_entry_iat_go_receiving_dfi_id_check_digit, ach_entry_iat_ofac_screening_indicator, ach_entry_iat_secondary_ofac_screening_indicator, ach_entry_iat_transaction_type_code, ach_entry_iat_foreign_trace_number, ach_entry_iat_originator_name, ach_entry_iat_originator_street_addr, ach_entry_iat_originator_city, ach_entry_iat_originator_state_province, ach_entry_iat_originator_postal_code, ach_entry_iat_originator_country, ach_entry_iat_originating_dfi_name, ach_entry_iat_originating_dfi_id, ach_entry_iat_originating_dfi_id_qualifier, ach_entry_iat_originating_dfi_country_code, ach_entry_iat_receiving_dfi_name, ach_entry_iat_receiving_dfi_id, ach_entry_iat_receiving_dfi_id_qualifier, ach_entry_iat_receiving_dfi_country_code, ach_entry_iat_receiver_street_addr, ach_entry_iat_receiver_city, ach_entry_iat_receiver_state_province, ach_entry_iat_receiver_postal_code, ach_entry_iat_receiver_country', 'safe', 'on'=>'search'),
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
			'ach_batch' => array(
					self::BELONGS_TO,
					'AchBatch',
					'ach_entry_ach_batch_id'
				),
			'odfi_branch' => array(
					self::BELONGS_TO,
					'OdfiBranch',
					'ach_entry_odfi_branch_id'
				),
			'external_account' => array(
					self::BELONGS_TO,
					'ExternalAccount',
					'ach_entry_external_account_id'
				),
			'payment_schedule' => array(
					self::BELONGS_TO,
					'PaymentSchedule',
					'ach_entry_payment_schedule_id'
				),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'ach_entry_id' => 'Ach Entry',
			'ach_entry_datetime' => 'Ach Entry Datetime',
			'ach_entry_status' => 'Ach Entry Status',
			'ach_entry_ach_batch_id' => 'Ach Entry Ach Batch',
			'ach_entry_odfi_branch_id' => 'Ach Entry Odfi Branch',
			'ach_entry_external_account_id' => 'Ach Entry External Account',
			'ach_entry_payment_schedule_id' => 'Ach Entry Payment Schedule',
			'ach_entry_detail_transaction_code' => 'Ach Entry Detail Transaction Code',
			'ach_entry_detail_receiving_dfi_id' => 'Ach Entry Detail Receiving Dfi',
			'ach_entry_detail_receiving_dfi_id_check_digit' => 'Ach Entry Detail Receiving Dfi Id Check Digit',
			'ach_entry_detail_dfi_account_number' => 'Ach Entry Detail Dfi Account Number',
			'ach_entry_detail_amount' => 'Ach Entry Detail Amount',
			'ach_entry_detail_individual_id_number' => 'Ach Entry Detail Individual Id Number',
			'ach_entry_detail_individual_name' => 'Ach Entry Detail Individual Name',
			'ach_entry_detail_discretionary_data' => 'Ach Entry Detail Discretionary Data',
			'ach_entry_detail_addenda_record_indicator' => 'Ach Entry Detail Addenda Record Indicator',
			'ach_entry_detail_trace_number' => 'Ach Entry Detail Trace Number',
			'ach_entry_addenda_type_code' => 'Ach Entry Addenda Type Code',
			'ach_entry_addenda_payment_info' => 'Ach Entry Addenda Payment Info',
			'ach_entry_iat_go_receiving_dfi_id' => 'Ach Entry Iat Go Receiving Dfi',
			'ach_entry_iat_go_receiving_dfi_id_check_digit' => 'Ach Entry Iat Go Receiving Dfi Id Check Digit',
			'ach_entry_iat_ofac_screening_indicator' => 'Ach Entry Iat Ofac Screening Indicator',
			'ach_entry_iat_secondary_ofac_screening_indicator' => 'Ach Entry Iat Secondary Ofac Screening Indicator',
			'ach_entry_iat_transaction_type_code' => 'Ach Entry Iat Transaction Type Code',
			'ach_entry_iat_foreign_trace_number' => 'Ach Entry Iat Foreign Trace Number',
			'ach_entry_iat_originator_name' => 'Ach Entry Iat Originator Name',
			'ach_entry_iat_originator_street_addr' => 'Ach Entry Iat Originator Street Addr',
			'ach_entry_iat_originator_city' => 'Ach Entry Iat Originator City',
			'ach_entry_iat_originator_state_province' => 'Ach Entry Iat Originator State Province',
			'ach_entry_iat_originator_postal_code' => 'Ach Entry Iat Originator Postal Code',
			'ach_entry_iat_originator_country' => 'Ach Entry Iat Originator Country',
			'ach_entry_iat_originating_dfi_name' => 'Ach Entry Iat Originating Dfi Name',
			'ach_entry_iat_originating_dfi_id' => 'Ach Entry Iat Originating Dfi',
			'ach_entry_iat_originating_dfi_id_qualifier' => 'Ach Entry Iat Originating Dfi Id Qualifier',
			'ach_entry_iat_originating_dfi_country_code' => 'Ach Entry Iat Originating Dfi Country Code',
			'ach_entry_iat_receiving_dfi_name' => 'Ach Entry Iat Receiving Dfi Name',
			'ach_entry_iat_receiving_dfi_id' => 'Ach Entry Iat Receiving Dfi',
			'ach_entry_iat_receiving_dfi_id_qualifier' => 'Ach Entry Iat Receiving Dfi Id Qualifier',
			'ach_entry_iat_receiving_dfi_country_code' => 'Ach Entry Iat Receiving Dfi Country Code',
			'ach_entry_iat_receiver_street_addr' => 'Ach Entry Iat Receiver Street Addr',
			'ach_entry_iat_receiver_city' => 'Ach Entry Iat Receiver City',
			'ach_entry_iat_receiver_state_province' => 'Ach Entry Iat Receiver State Province',
			'ach_entry_iat_receiver_postal_code' => 'Ach Entry Iat Receiver Postal Code',
			'ach_entry_iat_receiver_country' => 'Ach Entry Iat Receiver Country',
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

		$criteria->compare('ach_entry_id',$this->ach_entry_id,true);
		$criteria->compare('ach_entry_datetime',$this->ach_entry_datetime,true);
		$criteria->compare('ach_entry_status',$this->ach_entry_status,true);
		$criteria->compare('ach_entry_ach_batch_id',$this->ach_entry_ach_batch_id,true);
		$criteria->compare('ach_entry_odfi_branch_id',$this->ach_entry_odfi_branch_id,true);
		$criteria->compare('ach_entry_external_account_id',$this->ach_entry_external_account_id,true);
		$criteria->compare('ach_entry_payment_schedule_id',$this->ach_entry_payment_schedule_id,true);
		$criteria->compare('ach_entry_detail_transaction_code',$this->ach_entry_detail_transaction_code,true);
		$criteria->compare('ach_entry_detail_receiving_dfi_id',$this->ach_entry_detail_receiving_dfi_id,true);
		$criteria->compare('ach_entry_detail_receiving_dfi_id_check_digit',$this->ach_entry_detail_receiving_dfi_id_check_digit,true);
		$criteria->compare('ach_entry_detail_dfi_account_number',$this->ach_entry_detail_dfi_account_number,true);
		$criteria->compare('ach_entry_detail_amount',$this->ach_entry_detail_amount,true);
		$criteria->compare('ach_entry_detail_individual_id_number',$this->ach_entry_detail_individual_id_number,true);
		$criteria->compare('ach_entry_detail_individual_name',$this->ach_entry_detail_individual_name,true);
		$criteria->compare('ach_entry_detail_discretionary_data',$this->ach_entry_detail_discretionary_data,true);
		$criteria->compare('ach_entry_detail_addenda_record_indicator',$this->ach_entry_detail_addenda_record_indicator,true);
		$criteria->compare('ach_entry_detail_trace_number',$this->ach_entry_detail_trace_number,true);
		$criteria->compare('ach_entry_addenda_type_code',$this->ach_entry_addenda_type_code,true);
		$criteria->compare('ach_entry_addenda_payment_info',$this->ach_entry_addenda_payment_info,true);
		$criteria->compare('ach_entry_iat_go_receiving_dfi_id',$this->ach_entry_iat_go_receiving_dfi_id,true);
		$criteria->compare('ach_entry_iat_go_receiving_dfi_id_check_digit',$this->ach_entry_iat_go_receiving_dfi_id_check_digit,true);
		$criteria->compare('ach_entry_iat_ofac_screening_indicator',$this->ach_entry_iat_ofac_screening_indicator,true);
		$criteria->compare('ach_entry_iat_secondary_ofac_screening_indicator',$this->ach_entry_iat_secondary_ofac_screening_indicator,true);
		$criteria->compare('ach_entry_iat_transaction_type_code',$this->ach_entry_iat_transaction_type_code,true);
		$criteria->compare('ach_entry_iat_foreign_trace_number',$this->ach_entry_iat_foreign_trace_number,true);
		$criteria->compare('ach_entry_iat_originator_name',$this->ach_entry_iat_originator_name,true);
		$criteria->compare('ach_entry_iat_originator_street_addr',$this->ach_entry_iat_originator_street_addr,true);
		$criteria->compare('ach_entry_iat_originator_city',$this->ach_entry_iat_originator_city,true);
		$criteria->compare('ach_entry_iat_originator_state_province',$this->ach_entry_iat_originator_state_province,true);
		$criteria->compare('ach_entry_iat_originator_postal_code',$this->ach_entry_iat_originator_postal_code,true);
		$criteria->compare('ach_entry_iat_originator_country',$this->ach_entry_iat_originator_country,true);
		$criteria->compare('ach_entry_iat_originating_dfi_name',$this->ach_entry_iat_originating_dfi_name,true);
		$criteria->compare('ach_entry_iat_originating_dfi_id',$this->ach_entry_iat_originating_dfi_id,true);
		$criteria->compare('ach_entry_iat_originating_dfi_id_qualifier',$this->ach_entry_iat_originating_dfi_id_qualifier,true);
		$criteria->compare('ach_entry_iat_originating_dfi_country_code',$this->ach_entry_iat_originating_dfi_country_code,true);
		$criteria->compare('ach_entry_iat_receiving_dfi_name',$this->ach_entry_iat_receiving_dfi_name,true);
		$criteria->compare('ach_entry_iat_receiving_dfi_id',$this->ach_entry_iat_receiving_dfi_id,true);
		$criteria->compare('ach_entry_iat_receiving_dfi_id_qualifier',$this->ach_entry_iat_receiving_dfi_id_qualifier,true);
		$criteria->compare('ach_entry_iat_receiving_dfi_country_code',$this->ach_entry_iat_receiving_dfi_country_code,true);
		$criteria->compare('ach_entry_iat_receiver_street_addr',$this->ach_entry_iat_receiver_street_addr,true);
		$criteria->compare('ach_entry_iat_receiver_city',$this->ach_entry_iat_receiver_city,true);
		$criteria->compare('ach_entry_iat_receiver_state_province',$this->ach_entry_iat_receiver_state_province,true);
		$criteria->compare('ach_entry_iat_receiver_postal_code',$this->ach_entry_iat_receiver_postal_code,true);
		$criteria->compare('ach_entry_iat_receiver_country',$this->ach_entry_iat_receiver_country,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}

        public static function addUserJoin( CDbCriteria $criteria )
        {
                $criteria->join .= ' INNER JOIN external_account ON ( external_account_id = ach_entry_external_account_id ) ';
                ExternalAccount::addUserJoin( $criteria );
        }

	public function behaviors(){
		return array(
			'CTruncateBehavior' => array(
				'class' => 'application.behaviors.CTruncateBehavior',
				'attributeList' => array(
					'ach_entry_detail_individual_name'	=> 35,
				),
			),
			'CEncryptionBehavior' => array(
				'class' => 'application.behaviors.CEncryptionBehavior',
				'attributeList' => array (
					//'ach_entry_detail_receiving_dfi_id'	=> 'crypt', // Note that if we encrypt this field, we have to come up with a different way to calc the entry hash
					'ach_entry_detail_dfi_account_number'	=> 'crypt',
					'ach_entry_detail_individual_name'	=> 'crypt',
					'ach_entry_addenda_payment_info'	=> 'crypt',
					'ach_entry_iat_originator_name'	=> 'crypt',
					'ach_entry_iat_originator_street_addr'	=> 'crypt',
					'ach_entry_iat_originator_city'	=> 'crypt',
					'ach_entry_iat_originator_state_province'	=> 'crypt',
					'ach_entry_iat_originator_postal_code'	=> 'crypt',
					'ach_entry_iat_originator_country'	=> 'crypt',
					'ach_entry_iat_originating_dfi_name'	=> 'crypt',
					'ach_entry_iat_originating_dfi_id'	=> 'crypt',
					'ach_entry_iat_receiving_dfi_name'	=> 'crypt',
					'ach_entry_iat_receiving_dfi_id'	=> 'crypt',
					'ach_entry_iat_receiver_street_addr'	=> 'crypt',
					'ach_entry_iat_receiver_city'	=> 'crypt',
					'ach_entry_iat_receiver_state_province'	=> 'crypt',
					'ach_entry_iat_receiver_postal_code'	=> 'crypt',
					'ach_entry_iat_receiver_country'	=> 'crypt',
				),
			),
			'CEntityIndexIncrementingBehavior' => array(
				'class' => 'application.behaviors.CEntityIndexIncrementingBehavior',
				'attributeList' => array (
					'ach_entry_detail_individual_id_number',
				),
			),
			'CUuidKeyBehavior' => array(
				'class' => 'application.behaviors.CUuidKeyBehavior',
				'attributeList' => array (
					'ach_entry_id',
				),
			),
			'CDatetimeBehavior' => array(
				'class' => 'application.behaviors.CDatetimeBehavior',
				'attributeList' => array(
					'ach_entry_datetime',
				),
			),
                        'CActiveLogBehavior' => array(
                                'class' => 'application.behaviors.CActiveLogBehavior',
                                'attributeList' => array (
					'ach_entry_id',
					'ach_entry_status',
					'ach_entry_detail_transaction_code',
					'ach_entry_detail_amount',
					'ach_entry_detail_addenda_record_indicator',
					'ach_entry_detail_trace_number',
					'ach_entry_iat_foreign_trace_number',
				),
			),
		);
	}

	public function createFromSettlement( Settlement $settlement, AchBatch $achBatch )
	{
		if ( ! $this->isNewRecord )
		{
			throw new Exception( 'Attempted to create a new ACH entry from a Settlement, but this ACH entry is not a new record.' );
		}

		$originator_info = $achBatch->originator_info;
		$payment_type = $achBatch->payment_type;
		$external_account = $payment_type->external_account;
		$odfi_branch = $originator_info->odfi_branch;
		$transaction_type = $settlement->settlement_transaction_type;

		if ( ! $originator_info ) 
		{
			throw new Exception( 'Attempted to create a new ACH entry from a Settlement, but there is no originator info.' );
		}
		if ( ! $payment_type )
		{
			throw new Exception( 'Attempted to create a new ACH entry from a Settlement, but there is no payment type.' . PHP_EOL . $settlement->displaySummary() . PHP_EOL );
		}

		if ( ! $external_account )
		{
			throw new Exception( 'Attempted to create a new ACH entry from a Settlement, but there is no external account for settlement.  Check that the payment type has a settlement account assigned.' . PHP_EOL . "Payment Type:\t" . $payment_type->payment_type_id . PHP_EOL . $settlement->displaySummary() . PHP_EOL );
		}
		if ( ! $odfi_branch )
		{
			throw new Exception( 'Attempted to create a new ACH entry from a Settlement, but there is no odfi branch.' . PHP_EOL . $settlement->displaySummary() . PHP_EOL );
		}
		if ( ! $transaction_type )
		{
			throw new Exception( 'Attempted to create a new ACH entry from a Settlement, but there is no transaction type for the settlement .' . PHP_EOL . $settlement->displaySummary() . PHP_EOL );
		}

		if ( $external_account->external_account_country_code = 'US' )
		{
			$this->ach_entry_status				= 'pending';
			$this->ach_entry_odfi_branch_id			= $settlement->settlement_odfi_branch_id;
			$this->ach_entry_external_account_id		= $external_account->external_account_id;
			$this->ach_entry_detail_transaction_code	= $external_account->getAchEntryTransactionCode( $transaction_type );
			$this->ach_entry_detail_receiving_dfi_id	= substr( $external_account->external_account_dfi_id, 0, 8 ); // The first 8 digits of the DFI ID
			$this->ach_entry_detail_receiving_dfi_id_check_digit    = substr( $external_account->external_account_dfi_id, -1); // the last digit of the DFI ID 
			$this->ach_entry_detail_dfi_account_number      = $external_account->external_account_number;
			$this->ach_entry_detail_amount			= $settlement->settlement_amount;
			$this->ach_entry_detail_individual_name		= $external_account->external_account_holder;
		}
		else
		{
			throw new Exception( 'Settlement entries are currently only supported on US accounts.' );
		}

		return $this;
	}

	public function createFromPaymentSchedule( $schedule )
	{
		if ( ! $this->isNewRecord )
		{
			throw new Exception( 'Attempted to create a new ACH entry from a payment schedule, but this ACH entry is not a new record.' );
		}

		$external_account = $schedule->external_account;
		$payment_profile = $external_account->payment_profile;
		$originator_info = $payment_profile->originator_info;
		$odfi_branch = $originator_info->odfi_branch;

		$transaction_type = $schedule->payment_type->payment_type_transaction_type;
	
		if ( $external_account->external_account_country_code = 'US' )
		{
			$this->ach_entry_status			= 'pending';
			$this->ach_entry_odfi_branch_id 		= $odfi_branch->odfi_branch_id;
			$this->ach_entry_external_account_id 		= $external_account->external_account_id;
			$this->ach_entry_payment_schedule_id 		= $schedule->payment_schedule_id;
			$this->ach_entry_detail_transaction_code 	= $external_account->getAchEntryTransactionCode( $transaction_type );
			$this->ach_entry_detail_receiving_dfi_id 	= substr( $external_account->external_account_dfi_id, 0, 8 ); // The first 8 digits of the DFI ID
			$this->ach_entry_detail_receiving_dfi_id_check_digit	= substr( $external_account->external_account_dfi_id, -1); // the last digit of the DFI ID 
			$this->ach_entry_detail_dfi_account_number	= $external_account->external_account_number;
			$this->ach_entry_detail_amount		= $this->formatForAmount( $schedule->payment_schedule_amount );
			$this->ach_entry_detail_individual_name	= $external_account->external_account_holder;
		}

		return $this;
		
	}

	public function existsUnbatchedForPaymentType( $paymentType, $countryCode )
	{
		$command = Yii::app()->db->createCommand();
		$command->select = 'COUNT( ach_entry_id ) AS entry_count';
		$command->from( 'ach_entry' )
			->join( 'external_account', 'ach_entry_external_account_id = external_account_id' )
			->join( 'payment_profile', 'external_account_payment_profile_id = payment_profile_id' )
			->join( 'payment_schedule', 'ach_entry_payment_schedule_id = payment_schedule_id' )
			->join( 'originator_info', 'payment_profile_originator_info_id = originator_info_id' )
			->join( 'odfi_branch', 'originator_info_odfi_branch_id = odfi_branch_id AND odfi_branch_status = :status_enabled', array(':status_enabled'=>'enabled') )
			->join( 'payment_type', 'payment_schedule_payment_type_id = payment_type_id' )
			->where( 
				array(
					'AND', '( ach_entry_ach_batch_id = :empty_string OR ach_entry_ach_batch_id IS NULL )', 
					'external_account_country_code = :country_code', 
					'payment_type_id = :payment_type_id', 
					'originator_info_id = :originator_info_id', 
					'odfi_branch_id = :odfi_branch_id', 
				),
				array(
					':empty_string'=>'',
					':country_code'=>$countryCode,
					':odfi_branch_id'=>$paymentType->originator_info->odfi_branch->odfi_branch_id,
					':originator_info_id'=>$paymentType->originator_info->originator_info_id,
					':payment_type_id'=>$paymentType->payment_type_id,
				)
			);

		$result = $command->queryRow();
		if ( $result && $result['entry_count'] > 0 )
		{
			return true;
		}
		else
		{
			return false;
		}
		
	}

	public function existsUnbatchedForOriginatorInfo( $originatorInfo )
	{
		$command = Yii::app()->db->createCommand();
		$command->select = 'COUNT( ach_entry_id ) AS entry_count';
		$command->from( 'ach_entry' )
			->join( 'external_account', 'ach_entry_external_account_id = external_account_id' )
			->join( 'payment_profile', 'external_account_payment_profile_id = payment_profile_id' )
			->join( 'payment_schedule', 'ach_entry_payment_schedule_id = payment_schedule_id' )
			->join( 'originator_info', 'payment_profile_originator_info_id = originator_info_id' )
			->join( 'odfi_branch', 'originator_info_odfi_branch_id = odfi_branch_id AND odfi_branch_status = :status_enabled', array(':status_enabled'=>'enabled') )
			->where(
				array(
					'AND', '( ach_entry_ach_batch_id = :empty_string OR ach_entry_ach_batch_id IS NULL )',
					'originator_info_id = :originator_info_id',
					'odfi_branch_id = :odfi_branch_id',
				),
				array(
					':empty_string'=>'',
					':odfi_branch_id'=>$originatorInfo->odfi_branch->odfi_branch_id,
					':originator_info_id'=>$originatorInfo->originator_info_id
				)
			);

		$result = $command->queryRow();
		if ( $result && $result['entry_count'] > 0 )
		{
			return true;
		}
		else
		{
			return false;
		}

	}


/*
	public function getPaymentTypesForAllUnbatchedQuery()
	{
		$command = Yii::app()->db->createCommand()
			->select( 'payment_type_id' )
			->from( 'ach_entry' )
			->join( 'external_account', 'ach_entry_external_account_id = external_account_id' )
			->join( 'payment_profile', 'external_account_payment_profile_id = payment_profile_id' )
			->join( 'payment_schedule', 'ach_entry_payment_schedule_id = payment_schedule_id' )
			->join( 'originator_info', 'payment_profile_originator_info_id = originator_info_id' )
			->join( 'odfi_branch', 'originator_info_odfi_branch_id = odfi_branch_id AND odfi_branch_status = :status_enabled', array(':status_enabled'=>'enabled') )
			->join( 'payment_type', 'payment_schedule_payment_type_id = payment_type_id' )
			->where( 'ach_entry_ach_batch_id = :empty_string OR ach_entry_ach_batch_id IS NULL', array(':empty_string'=>'') );
		$command->setDistinct( true );
		return $command;
	}
*/

	public function getAllUnbatchedQuery( CDbCriteria $criteria = null )
	{
		$command = Yii::app()->db->createCommand() //$this->getCommandBuilder()->createFindCommand( $this->getTableSchema(), $criteria )
			->from( 'ach_entry' )
			->join( 'external_account', 'ach_entry_external_account_id = external_account_id' )
			->join( 'payment_profile', 'external_account_payment_profile_id = payment_profile_id' )
			->join( 'payment_schedule', 'ach_entry_payment_schedule_id = payment_schedule_id' )
			->join( 'originator_info', 'payment_profile_originator_info_id = originator_info_id' )
			->join( 'odfi_branch', 'originator_info_odfi_branch_id = odfi_branch_id AND odfi_branch_status = :status_enabled', array(':status_enabled'=>'enabled') )
			->join( 'payment_type', 'payment_schedule_payment_type_id = payment_type_id' )
			->where( 'ach_entry_ach_batch_id = :empty_string OR ach_entry_ach_batch_id IS NULL', array(':empty_string'=>'') );

		if ( $criteria )
		{
			$command->where( $command->where . ' AND ' . $criteria->condition, $criteria->params );
		}

		return $command;
	}

	public function getOriginatorInfoForAllUnbatchedQuery( CDbCriteria $criteria = null )
	{
		$command = Yii::app()->db->createCommand() //$this->getCommandBuilder()->createFindCommand( $this->getTableSchema(), $criteria )
			->selectDistinct( 'originator_info_id' )
			->from( 'originator_info' )
			->join( 'odfi_branch', 'originator_info_odfi_branch_id = odfi_branch_id AND odfi_branch_status = :status_enabled', array(':status_enabled'=>'enabled') )
			->join( 'ach_entry', 'ach_entry_odfi_branch_id = odfi_branch_id' )
			->join( 'external_account', 'ach_entry_external_account_id = external_account_id' )
			->join( 'payment_profile', 'external_account_payment_profile_id = payment_profile_id' )
			->join( 'payment_schedule', 'ach_entry_payment_schedule_id = payment_schedule_id' )
			->join( 'payment_type', 'payment_schedule_payment_type_id = payment_type_id' )
			->where( 'ach_entry_ach_batch_id = :empty_string OR ach_entry_ach_batch_id IS NULL', array(':empty_string'=>'') );
		if ( $criteria )
		{
			$command->where( $command->where . ' AND ' . $criteria->condition, $criteria->params );
		}

		return $command;
	}

	// Formats a decimal value for the amount field by removing the decimal point
	public function formatForAmount( $amount )
	{
		// The safe way to multiply a float into an integer
		return bcmul( $amount, 100 );
	}

	public function generateDetailId()
	{
	}

	public function isDebit()
	{
		if ( in_array( $this->ach_entry_detail_transaction_code, Yii::app()->params['AchEntry']['TransactionCodes']['Debit'] ) )
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	public function isCredit()
	{
		return ! $this->isDebit();
	}

	public function displayAccountNumber()
	{
		return 'Account ending in ' . substr( $this->ach_entry_detail_dfi_account_number, -4 );
	}

	public function displayAmount()
	{
		return '$' . number_format( (double) $this->ach_entry_detail_amount / 100, 2 ) . ' ' . ( $this->isDebit() ? 'Withdrawal' : 'Deposit' );
	}

	public function displayDate()
	{
		$dateTime = new DateTime( $this->ach_entry_datetime );
		return 'Initiated ' . $dateTime->format( 'M d, Y' );
	}

	public function displayReceiptNumber()
	{
		return 'Receipt Number ' . $this->ach_entry_detail_individual_id_number;
	}

	public function displayStatus()
	{
		return 'Status: ' . ucfirst( $this->ach_entry_status );
	}

	public function displayCustomer()
	{
		return $this->ach_entry_detail_individual_name;
	}

	public function merge( ODDataSource $record )
	{
		parent::merge( $record );
		// This allows non-record attributes to be merged when parsing entries with addenda records
		foreach ( $this->foreignAttributes as $attribute )
		{
			if ( ! isset( $record->{$attribute} ) )
			{
				continue;
			}
			if ( ! $this->{$attribute} && $record->{$attribute} )
			{
				$this->{$attribute} = $record->{$attribute};
			}
		}
	}

	public function updateStatusReturned()
	{
		if ( ! $this->refresh() )
		{
			throw new Exception( 'The Ach Entry ' . $this->ach_entry_id . ' no longer exists.' );
		}

		if ( $this->ach_entry_status == 'returned' )
		{
			throw new Exception( 'Ach Entry already has status of returned.' );
		}

		if ( $this->ach_entry_status == 'error' )
		{
			throw new Exception( 'Ach Entry has status of error.' );
		}

		$this->ach_entry_status = 'returned';

		return $this->save();
	}

}
