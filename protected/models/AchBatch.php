<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

/**
 * This is the model class for table "ach_batch".
 *
 * The followings are the available columns in table 'ach_batch':
 * @property string $ach_batch_id
 * @property string $ach_batch_datetime
 * @property string $ach_batch_ach_file_id
 * @property string $ach_batch_header_service_class_code
 * @property string $ach_batch_header_company_name
 * @property string $ach_batch_header_discretionary_data
 * @property string $ach_batch_header_company_identification
 * @property string $ach_batch_header_standard_entry_class
 * @property string $ach_batch_header_company_entry_description
 * @property string $ach_batch_header_company_descriptive_date
 * @property string $ach_batch_header_effective_entry_date
 * @property string $ach_batch_header_settlement_date
 * @property string $ach_batch_header_originator_status_code
 * @property string $ach_batch_header_originating_dfi_id
 * @property string $ach_batch_header_batch_number
 * @property string $ach_batch_control_entry_addenda_count
 * @property string $ach_batch_control_entry_hash
 * @property string $ach_batch_control_total_debits
 * @property string $ach_batch_control_total_credits
 * @property string $ach_batch_control_message_authentication_code
 * @property string $ach_batch_iat_indicator
 * @property string $ach_batch_iat_foreign_exchange_indicator
 * @property string $ach_batch_iat_foreign_exchange_ref_indicator
 * @property string $ach_batch_iat_foreign_exchange_rate_ref
 * @property string $ach_batch_iat_iso_dest_country_code
 * @property string $ach_batch_iat_iso_orig_currency_code
 * @property string $ach_batch_iat_iso_dest_currency_code
 * @property string $ach_batch_payment_type_id
 * @property string $ach_batch_originator_info_id
 */
class AchBatch extends OADataSource
{

	public $ach_record_type_code = '5';
	public $reserved = '';

	// Defaults
	public $ach_batch_header_originator_status_code = '1';

	/**
	 * Returns the static model of the specified AR class.
	 * @return AchBatch the static model class
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
		return 'ach_batch';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ach_batch_id, ach_batch_datetime, ach_batch_ach_file_id, ach_batch_originator_info_id', 'required'),
			array('ach_batch_id, ach_batch_ach_file_id, ach_batch_payment_type_id, ach_batch_originator_info_id', 'length', 'max'=>36),
			array('ach_batch_header_service_class_code, ach_batch_header_standard_entry_class, ach_batch_header_settlement_date, ach_batch_iat_iso_dest_country_code, ach_batch_iat_iso_orig_currency_code, ach_batch_iat_iso_dest_currency_code', 'length', 'max'=>3),
			array('ach_batch_header_company_name, ach_batch_iat_indicator', 'length', 'max'=>16),
			array('ach_batch_header_discretionary_data', 'length', 'max'=>20),
			array('ach_batch_header_company_identification, ach_batch_header_company_entry_description, ach_batch_control_entry_hash', 'length', 'max'=>10),
			array('ach_batch_header_company_descriptive_date, ach_batch_header_effective_entry_date, ach_batch_control_entry_addenda_count', 'length', 'max'=>6),
			array('ach_batch_header_originator_status_code, ach_batch_iat_foreign_exchange_ref_indicator', 'length', 'max'=>1),
			array('ach_batch_header_originating_dfi_id', 'length', 'max'=>8),
			array('ach_batch_header_batch_number', 'length', 'max'=>7),
			array('ach_batch_control_total_debits, ach_batch_control_total_credits', 'length', 'max'=>12),
			array('ach_batch_control_message_authentication_code', 'length', 'max'=>19),
			array('ach_batch_iat_foreign_exchange_indicator', 'length', 'max'=>2),
			array('ach_batch_iat_foreign_exchange_rate_ref', 'length', 'max'=>15),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('ach_batch_id, ach_batch_datetime, ach_batch_ach_file_id, ach_batch_header_service_class_code, ach_batch_header_company_name, ach_batch_header_discretionary_data, ach_batch_header_company_identification, ach_batch_header_standard_entry_class, ach_batch_header_company_entry_description, ach_batch_header_company_descriptive_date, ach_batch_header_effective_entry_date, ach_batch_header_settlement_date, ach_batch_header_originator_status_code, ach_batch_header_originating_dfi_id, ach_batch_header_batch_number, ach_batch_control_entry_addenda_count, ach_batch_control_entry_hash, ach_batch_control_total_debits, ach_batch_control_total_credits, ach_batch_control_message_authentication_code, ach_batch_iat_indicator, ach_batch_iat_foreign_exchange_indicator, ach_batch_iat_foreign_exchange_ref_indicator, ach_batch_iat_foreign_exchange_rate_ref, ach_batch_iat_iso_dest_country_code, ach_batch_iat_iso_orig_currency_code, ach_batch_iat_iso_dest_currency_code', 'safe', 'on'=>'search'),
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
			'ach_file' => array(
					self::BELONGS_TO,
					'AchFile',
					'ach_batch_ach_file_id'
				),
			'ach_entries' => array(
					self::HAS_MANY,
					'AchEntry',
					'ach_entry_ach_batch_id'
				),
			'payment_type' => array(
					self::BELONGS_TO,
					'PaymentType',
					'ach_batch_payment_type_id'
				),
			'originator_info' => array(
					self::BELONGS_TO,
					'OriginatorInfo',
					'ach_batch_originator_info_id'
				),
			'settlement' => array(
					self::HAS_ONE,
					'Settlement',
					'settlement_ach_batch_id'
				),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'ach_batch_id' => 'Ach Batch',
			'ach_batch_datetime' => 'Datetime',
			'ach_batch_ach_file_id' => 'Ach File',
			'ach_batch_header_service_class_code' => 'Service Class Code',
			'ach_batch_header_company_name' => 'Company Name',
			'ach_batch_header_discretionary_data' => 'Discretionary Data',
			'ach_batch_header_company_identification' => 'Company ID',
			'ach_batch_header_standard_entry_class' => 'Standard Entry Class',
			'ach_batch_header_company_entry_description' => 'Entry Description',
			'ach_batch_header_company_descriptive_date' => 'Descriptive Date',
			'ach_batch_header_effective_entry_date' => 'Effective Entry Date',
			'ach_batch_header_settlement_date' => 'Settlement Date',
			'ach_batch_header_originator_status_code' => 'Originator Status Code',
			'ach_batch_header_originating_dfi_id' => 'Originating DFI',
			'ach_batch_header_batch_number' => 'Batch Number',
			'ach_batch_control_entry_addenda_count' => 'Entry Addenda Count',
			'ach_batch_control_entry_hash' => 'Entry Hash',
			'ach_batch_control_total_debits' => 'Total Debits',
			'ach_batch_control_total_credits' => 'Total Credits',
			'ach_batch_control_message_authentication_code' => 'Message Authentication Code',
			'ach_batch_iat_indicator' => 'IAT Indicator',
			'ach_batch_iat_foreign_exchange_indicator' => 'Foreign Exchange Indicator',
			'ach_batch_iat_foreign_exchange_ref_indicator' => 'Foreign Exchange Ref Indicator',
			'ach_batch_iat_foreign_exchange_rate_ref' => 'Foreign Exchange Rate Ref',
			'ach_batch_iat_iso_dest_country_code' => 'Dest Country Code',
			'ach_batch_iat_iso_orig_currency_code' => 'Orig Currency Code',
			'ach_batch_iat_iso_dest_currency_code' => 'Dest Currency Code',
			'ach_batch_payment_type_id' => 'Payment Type',
			'ach_batch_originator_info_id' => 'Origination Account',
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

		$criteria->compare('ach_batch_id',$this->ach_batch_id,true);
		$criteria->compare('ach_batch_datetime',$this->ach_batch_datetime,true);
		$criteria->compare('ach_batch_ach_file_id',$this->ach_batch_ach_file_id,true);
		$criteria->compare('ach_batch_header_service_class_code',$this->ach_batch_header_service_class_code,true);
		$criteria->compare('ach_batch_header_company_name',$this->ach_batch_header_company_name,true);
		$criteria->compare('ach_batch_header_discretionary_data',$this->ach_batch_header_discretionary_data,true);
		$criteria->compare('ach_batch_header_company_identification',$this->ach_batch_header_company_identification,true);
		$criteria->compare('ach_batch_header_standard_entry_class',$this->ach_batch_header_standard_entry_class,true);
		$criteria->compare('ach_batch_header_company_entry_description',$this->ach_batch_header_company_entry_description,true);
		$criteria->compare('ach_batch_header_company_descriptive_date',$this->ach_batch_header_company_descriptive_date,true);
		$criteria->compare('ach_batch_header_effective_entry_date',$this->ach_batch_header_effective_entry_date,true);
		$criteria->compare('ach_batch_header_settlement_date',$this->ach_batch_header_settlement_date,true);
		$criteria->compare('ach_batch_header_originator_status_code',$this->ach_batch_header_originator_status_code,true);
		$criteria->compare('ach_batch_header_originating_dfi_id',$this->ach_batch_header_originating_dfi_id,true);
		$criteria->compare('ach_batch_header_batch_number',$this->ach_batch_header_batch_number,true);
		$criteria->compare('ach_batch_control_entry_addenda_count',$this->ach_batch_control_entry_addenda_count,true);
		$criteria->compare('ach_batch_control_entry_hash',$this->ach_batch_control_entry_hash,true);
		$criteria->compare('ach_batch_control_total_debits',$this->ach_batch_control_total_debits,true);
		$criteria->compare('ach_batch_control_total_credits',$this->ach_batch_control_total_credits,true);
		$criteria->compare('ach_batch_control_message_authentication_code',$this->ach_batch_control_message_authentication_code,true);
		$criteria->compare('ach_batch_iat_indicator',$this->ach_batch_iat_indicator,true);
		$criteria->compare('ach_batch_iat_foreign_exchange_indicator',$this->ach_batch_iat_foreign_exchange_indicator,true);
		$criteria->compare('ach_batch_iat_foreign_exchange_ref_indicator',$this->ach_batch_iat_foreign_exchange_ref_indicator,true);
		$criteria->compare('ach_batch_iat_foreign_exchange_rate_ref',$this->ach_batch_iat_foreign_exchange_rate_ref,true);
		$criteria->compare('ach_batch_iat_iso_dest_country_code',$this->ach_batch_iat_iso_dest_country_code,true);
		$criteria->compare('ach_batch_iat_iso_orig_currency_code',$this->ach_batch_iat_iso_orig_currency_code,true);
		$criteria->compare('ach_batch_iat_iso_dest_currency_code',$this->ach_batch_iat_iso_dest_currency_code,true);
		$criteria->compare('ach_batch_payment_type_id',$this->ach_batch_payment_type_id,true);
		$criteria->compare('ach_batch_originator_info_id',$this->ach_batch_originator_info_id,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}

        public static function addUserJoin( CDbCriteria $criteria )
        {
                $criteria->join .= ' INNER JOIN originator_info ON ( originator_info_id = ach_batch_originator_info_id ) ';
                Originator::addUserJoin( $criteria );
        }

	public function behaviors(){
		return array(
			'CEncryptionBehavior' => array(
				'class' => 'application.behaviors.CEncryptionBehavior',
				'attributeList' => array (
					'ach_batch_header_company_name'			=> 'crypt',
					'ach_batch_header_company_identification'	=> 'crypt',
				),
			),
			'CEntityIndexIncrementingBehavior' => array(
				'class' => 'application.behaviors.CEntityIndexIncrementingBehavior',
				'attributeList' => array (
					'ach_batch_header_discretionary_data',
				),
			),
			'CUuidKeyBehavior' => array(
				'class' => 'application.behaviors.CUuidKeyBehavior',
				'attributeList' => array (
					'ach_batch_id',
				),
			),
			'CDatetimeBehavior' => array(
				'class' => 'application.behaviors.CDatetimeBehavior',
				'attributeList' => array(
					'ach_batch_datetime',
				),
			),
                        'CActiveLogBehavior' => array(
                                'class' => 'application.behaviors.CActiveLogBehavior',
                                'attributeList' => array (
					'ach_batch_id',
					'ach_batch_header_company_descriptive_date',
					'ach_batch_header_effective_entry_date',
					'ach_batch_header_batch_number',
					'ach_batch_control_entry_addenda_count',
					'ach_batch_control_entry_hash',
					'ach_batch_control_total_debits',
					'ach_batch_control_total_credits',
					'ach_batch_payment_type_id',
					'ach_batch_originator_info_id',
				),
			),
		);
	}

	public function displayCredits()
	{
		return 'Total Credits: $' . number_format( (double) $this->ach_batch_control_total_credits / 100, 2 );
	}

	public function displayDebits()
	{
		return 'Total Debits: $' . number_format( (double) $this->ach_batch_control_total_debits / 100, 2 );
	}

	public function displayEntryHash()
	{
		return 'Entry Hash: ' . $this->ach_batch_control_entry_hash;
	}

	public function displayBatchCount()
	{
		return 'Batch Count: ' . $this->ach_batch_control_batch_count;
	}

	public function displayEntryAddendaCount()
	{
		return 'Entry/Addenda Count: ' . $this->ach_batch_control_entry_addenda_count;
	}

	public function displayDescription()
	{
		return $this->ach_batch_header_company_entry_description;
	}

	public function displayDate()
	{
		$dateString = $this->ach_batch_header_effective_entry_date;
		$dateFormatted = $dateString[2] . $dateString[3] . '-' . $dateString[4] . $dateString[5] . '-' . $dateString[0] . $dateString[1]; 
		return $this->formatDate( $dateFormatted );
		
	}

	public function createFromPaymentType( $paymentType )
	{
		throw new Exception( 'This method should only be called from one of the AchBatch subclasses.' );
	}

	public function addUnbatchedEntriesByPaymentType( $paymentType, $countryCode )
	{

		if ( ! $this->ach_batch_id || $this->isNewRecord )
		{
			throw new Exception( 'Unable to add unbatched entries for this ACH batch as it is either not saved or has no ach_batch_id.' );
		}
/*
		$command = Yii::app()->db->createCommand();
		$command->update( 'ach_entry', array( 'ach_entry_ach_batch_id' => $this->ach_batch_id ) );
		$command->join( 'external_account', 'ach_entry_external_account_id = external_account_id AND external_account_country_code = :country_code', array(':country_code'=>$countryCode) )
			->join( 'payment_profile', 'external_account_payment_profile_id = payment_profile_id' )
			->join( 'originator_info', 'payment_profile_originator_info_id = originator_info_id AND originator_info_id = :originator_info_id', array(':originator_info_id'=>$paymentType->originator_info->originator_info_id) )
			->join( 'odfi_branch', 'originator_info_odfi_branch_id = odfi_branch_id AND odfi_branch_status = :status_enabled AND odfi_branch_id = :odfi_branch_id', array(':status_enabled'=>'enabled',':odfi_branch_id'=>$paymentType->originator_info->odfi_branch->odfi_branch_id) )
			->join( 'payment_schedule', 'ach_entry_payment_schedule_id = payment_schedule_id' )
			->join( 'payment_type', 'payment_schedule_payment_type_id = payment_type_id AND payment_type_id = :payment_type_id', array(':payment_type_id'=>$paymentType->payment_type_id) )
			->where( 'ach_entry_ach_batch_id = :empty_string', array(':empty_string'=>'') );
*/

		$joins = array(
				'external_account' => 'ach_entry_external_account_id = external_account_id AND external_account_country_code = :country_code',
				'payment_profile' => 'external_account_payment_profile_id = payment_profile_id',
				'originator_info' => 'payment_profile_originator_info_id = originator_info_id AND originator_info_id = :originator_info_id',
				'odfi_branch' => 'originator_info_odfi_branch_id = odfi_branch_id AND odfi_branch_status = :status_enabled AND odfi_branch_id = :odfi_branch_id',
				'payment_schedule' => 'ach_entry_payment_schedule_id = payment_schedule_id',
				'payment_type' => 'payment_schedule_payment_type_id = payment_type_id AND payment_type_id = :payment_type_id'
			);

		$sqlQuery = 'UPDATE ach_entry ';
		if ( Yii::app()->db->schema instanceof CMysqlSchema )
		{
			foreach ( $joins as $tableName => $condition )
			{
				$sqlQuery .= 'JOIN ' . $tableName . ' ON ( ' . $condition . ' ) ';
			}
			$sqlQuery .= 'SET ach_entry_ach_batch_id = :ach_batch_id ';
			$sqlQuery .= 'WHERE ach_entry_ach_batch_id = :empty_string OR ach_entry_ach_batch_id IS NULL';
		}
		elseif ( Yii::app()->db->schema instanceof CPgsqlSchema )
		{
			$sqlQuery .= 'SET ach_entry_ach_batch_id = :ach_batch_id ';
			$sqlQuery .= 'FROM ' . implode( ', ', array_keys( $joins ) ) . ' ';
			$sqlQuery .= 'WHERE ';
			$sqlQuery .= '( ' . implode( ' ) AND ( ', array_values( $joins ) ) . ' ) ';
			$sqlQuery .= 'AND ( ach_entry_ach_batch_id = :empty_string OR ach_entry_ach_batch_id IS NULL )';
		}
		elseif ( Yii::app()->db->schema instanceof CSqliteSchema )
		{
			$sqlQuery .= 'SET ach_entry_ach_batch_id = :ach_batch_id ';
			$sqlQuery .= 'WHERE ach_entry_id IN ( '; // begin subselect
			$sqlQuery .= 'SELECT ach_entry_id FROM ach_entry ';
			foreach ( $joins as $tableName => $condition )
			{
				$sqlQuery .= 'JOIN ' . $tableName . ' ON ( ' . $condition . ' ) ';
			}
			$sqlQuery .= 'WHERE ach_entry_ach_batch_id = :empty_string OR ach_entry_ach_batch_id IS NULL';
			$sqlQuery .= ' ) '; // end subselect
		}
		else
		{
			throw new Exception( 'Unsupported database type.' );
		}
		
/*	

		$sqlQuery = 	'UPDATE ach_entry
				JOIN external_account ON ( ach_entry_external_account_id = external_account_id AND external_account_country_code = :country_code )
				JOIN payment_profile ON ( external_account_payment_profile_id = payment_profile_id )
				JOIN originator_info ON ( payment_profile_originator_info_id = originator_info_id AND originator_info_id = :originator_info_id )
				JOIN odfi_branch ON ( originator_info_odfi_branch_id = odfi_branch_id AND odfi_branch_status = :status_enabled AND odfi_branch_id = :odfi_branch_id )
				JOIN payment_schedule ON ( ach_entry_payment_schedule_id = payment_schedule_id )
				JOIN payment_type ON ( payment_schedule_payment_type_id = payment_type_id AND payment_type_id = :payment_type_id )
				SET ach_entry_ach_batch_id = :ach_batch_id
				WHERE ach_entry_ach_batch_id = :empty_string OR ach_entry_ach_batch_id IS NULL';
*/
				
		$params = array(
				':ach_batch_id'=>$this->ach_batch_id,
				':country_code'=>$countryCode,
				':originator_info_id'=>$paymentType->originator_info->originator_info_id,
				':status_enabled'=>'enabled',
				':odfi_branch_id'=>$paymentType->originator_info->odfi_branch->odfi_branch_id,
				':payment_type_id'=>$paymentType->payment_type_id,
				':empty_string'=>''
			);

		$command = Yii::app()->db->createCommand();
		$command->text = $sqlQuery;

		return $command->execute( $params );
	}

	public function setEntryTraceNumbersForBatch()
	{
		// The following query relies on the ON DUPLICATE KEY UPDATE clause in MySQL
		// Note that it will NOT actually INSERT rows, only UPDATE them since every 
		// row that is included in the SELECT will be a DUPLICATE.  This 'trick' is
		// faster than loading a list of IDs and looping through them with individual
		// UPDATE queries.
		// The INNER JOIN uses a subselect to initialize the variable @trace.
		// While the UPDATE increments the @trace counter when the field value updates

		if ( Yii::app()->db->schema instanceof CMysqlSchema )
		{
			$sqlQuery =     'INSERT INTO ach_entry
					SELECT a.*
					FROM ach_entry a
					INNER JOIN (SELECT @trace:=0) b
					WHERE ach_entry_ach_batch_id = :ach_batch_id
					ON DUPLICATE KEY UPDATE ach_entry_detail_trace_number = (@trace:=@trace+1) ';
		}
		elseif ( Yii::app()->db->schema instanceof CPgsqlSchema )
		{
			$command = Yii::app()->db->createCommand();
			$command->text = "SELECT setval( 'ach_entry_detail_trace_number_seq', 0 )";
			$command->execute();
			$sqlQuery = "UPDATE ach_entry 
					SET ach_entry_detail_trace_number = nextval( 'ach_entry_detail_trace_number_seq' )
					WHERE ach_entry_ach_batch_id = :ach_batch_id";
		}
		elseif ( Yii::app()->db->schema instanceof CSqliteSchema )
		{
			// Do nothing just don't throw an exception, the ach_entry_detail_trace_number was created at the time the row was inserted
			$sqlQuery = '';
		}
		else
		{
			throw new Exception( 'Unsupported database type.' );
		}

		if ( $sqlQuery != '' )
		{
			$command = Yii::app()->db->createCommand(); 
			$command->text = $sqlQuery;
			$params = array( ':ach_batch_id'=>$this->ach_batch_id );

			return $command->execute( $params );
		}
		else
		{
			return;
		}
	}


	public function setDates( $dateTime = null )
	{
		if ( $dateTime == null )
		{
			// Default to one day in the future
			// TODO: This needs to be calculated as the NEXT BUSINESS DAY!
			$dateTime = new DateTime();
			$dateTime->add( new DateInterval( 'PT1D' ) );
		}

		// Ensure that the effective date is at least one day in the future
		// TODO:  The dateTime needs to be greater than or equal to the NEXT BUSINESS DAY!
		$curDate = new DateTime();
		if ( $curDate < $dateTime )
		{
			$this->ach_batch_header_company_descriptive_date = $dateTime->format( 'ymd' );
			$this->ach_batch_header_effective_entry_date = $dateTime->format( 'ymd' );
		}
		else
		{
			throw new Exception( 'Attempted to set the effective entry date to a date in the past, or too soon in the future.' );
		}
	}

	public function getEffectiveDateTime()
	{
		if ( strlen( $this->ach_batch_header_effective_entry_date ) != 6 )
		{
			throw new Exception( 'The effective entry date is not properly set.' );
		}
		$date = $this->ach_batch_header_effective_entry_date;
		$dateParts = $date[0] . $date[1] . '-' . $date[2] . $date[3] . '-' .$date[4] . $date[5];
		return new DateTime( $dateParts );
	}

	public function getCalculateQuery()
	{
		if ( Yii::app()->db->schema instanceof CMysqlSchema )
		{
			$sumField = 'ach_entry_detail_amount';
		}
		elseif ( Yii::app()->db->schema instanceof CPgsqlSchema )
		{
			$sumField = "to_number( ach_entry_detail_amount, '999999999999999999' )";
		}
		elseif ( Yii::app()->db->schema instanceof CSqliteSchema )
		{
			$sumField = "cast( ach_entry_detail_amount AS INTEGER )";
		}
		
		return Yii::app()->db->createCommand()
			->select('SUM( ' . $sumField . ' ) AS total' )
			->from( 'ach_entry' )
			->join( 'ach_batch', 'ach_entry_ach_batch_id = ach_batch_id AND ach_batch_id = :ach_batch_id' )
			->join( 'payment_schedule', 'ach_entry_payment_schedule_id = payment_schedule_id' )
			->join( 'payment_type', 'payment_schedule_payment_type_id = payment_type_id AND payment_type_transaction_type = :transaction_type' );
	}

	public function calculateTotals( $recalculate=false )
	{
	
		if ( ! $recalculate && ( $this->ach_batch_control_total_debits != 0 || $this->ach_batch_control_total_debits != 0 ) )
		{
			throw new Exception( 'Attempted to calculate non-zero batch totals without specifying recalculate.' );
		}

		$command = $this->getCalculateQuery();

		if ( ! $creditResult = $command->queryRow( true, array( ':ach_batch_id'=>$this->ach_batch_id, ':transaction_type'=>'credit' ) ) )
		{
			throw new Exception( 'Query failed for calculating credits. ' . $command->text );
			$this->ach_batch_control_total_credits = 0;
		}
		else
		{
			$this->ach_batch_control_total_credits = ( $creditResult['total'] ? $creditResult['total'] : 0 );
		}

		$command = $this->getCalculateQuery();

		if ( ! $debitResult = $command->queryRow( true, array( ':ach_batch_id'=>$this->ach_batch_id, ':transaction_type'=>'debit' ) ) )
		{
			throw new Exception( 'Query failed for calculating debits. ' . $command->text );
			$this->ach_batch_control_total_debits = 0;
		}
		else
		{
			$this->ach_batch_control_total_debits = ( $debitResult['total'] ? $debitResult['total'] : 0 );
		}
	}

	public function calculateEntryHash()
	{
		throw new Exception('This method should only be called from one of the AchBatch subclasses.' );

	}
}
