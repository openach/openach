<?php

/**
 * This is the model class for table "settlement".
 *
 * The followings are the available columns in table 'settlement':
 * @property string $settlement_id
 * @property string $settlement_datetime
 * @property string $settlement_originator_info_id
 * @property string $settlement_odfi_branch_id
 * @property string $settlement_ach_batch_id
 * @property string $settlement_ach_entry_id
 * @property string $settlement_transaction_type
 * @property string $settlement_amount
 * @property string $settlement_effective_entry_date
 */
class Settlement extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Settlement the static model class
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
		return 'settlement';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('settlement_id, settlement_datetime, settlement_originator_info_id, settlement_odfi_branch_id, settlement_ach_batch_id, settlement_ach_entry_id, settlement_transaction_type, settlement_amount, settlement_effective_entry_date', 'required'),
			array('settlement_id, settlement_originator_info_id, settlement_odfi_branch_id, settlement_ach_batch_id, settlement_ach_entry_id', 'length', 'max'=>36),
			array('settlement_amount', 'length', 'max'=>18),
			array('settlement_effective_entry_date', 'length', 'max'=>6),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('settlement_id, settlement_datetime, settlement_originator_info_id, settlement_odfi_branch_id, settlement_ach_batch_id, settlement_ach_entry_id, settlement_transaction_type, settlement_amount', 'safe', 'on'=>'search'),
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
			'originator_info' => array(
					self::BELONGS_TO,
					'OriginatorInfo',
					'settlement_originator_info_id'
				),

			'odfi_branch' => array(
					self::BELONGS_TO,
					'OdfiBranch',
					'settlement_odfi_branch_id'
				),
			'ach_batch' => array(
					self::BELONGS_TO,
					'AchBatch',
					'settlement_ach_batch_id'
				),
			'ach_entry' => array(
					self::BELONGS_TO,
					'AchEntry',
					'settlement_ach_entry_id'
				),
		);
	}


	public function behaviors()
	{
		return array(

			'CUuidKeyBehavior' => array(
				'class' => 'application.behaviors.CUuidKeyBehavior',
				'attributeList' => array (
					'settlement_id',
				),
			),
			'CDatetimeBehavior' => array(
				'class' => 'application.behaviors.CDatetimeBehavior',
				'attributeList' => array(
					'settlement_datetime',
				),
			),
			'CActiveLogBehavior' => array(
				'class' => 'application.behaviors.CActiveLogBehavior',
				'attributeList' => array (
					'settlement_id',
					'settlement_originator_info_id',
					'settlement_odfi_branch_id',
					'settlement_ach_batch_id',
					'settlement_ach_entry_id',
					'settlement_transaction_type',
					'settlement_amount',
					'settlement_effective_entry_date',
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
			'settlement_id' => 'Settlement',
			'settlement_datetime' => 'Settlement Datetime',
			'settlement_originator_info_id' => 'Settlement Originator Info', // The originator info for which this settlement is being processed
			'settlement_odfi_branch_id' => 'Settlement Odfi Branch', // The OdfiBranch of the originator info at the time when the settlement entry was generated
			'settlement_ach_batch_id' => 'Settlement Ach Batch', // The AchBatch that this record is settling
			'settlement_ach_entry_id' => 'Settlement Ach Entry', // The AchEntry record that is doing the settling
			'settlement_transaction_type' => 'Settlement Transaction Type', // The transaction type (credit/deibt) of the settlement - opposite of the AchBatch
			'settlement_amount' => 'Settlement Amount', // The amount of the settlement
			'settlement_effective_entry_date' => 'Effective Entry Date', // The effective entry date of the settlement ACH entry (used to properly batch the entry)
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

		$criteria->compare('settlement_id',$this->settlement_id,true);
		$criteria->compare('settlement_datetime',$this->settlement_datetime,true);
		$criteria->compare('settlement_originator_info_id',$this->settlement_originator_info_id,true);
		$criteria->compare('settlement_odfi_branch_id',$this->settlement_odfi_branch_id,true);
		$criteria->compare('settlement_ach_batch_id',$this->settlement_ach_batch_id,true);
		$criteria->compare('settlement_ach_entry_id',$this->settlement_ach_entry_id,true);
		$criteria->compare('settlement_transaction_type',$this->settlement_transaction_type,true);
		$criteria->compare('settlement_amount',$this->settlement_amount,true);
		$criteria->compare('settlement_effective_entry_date',$this->settlement_effective_entry_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function createFromAchBatch( AchBatch $achBatch )
	{
		if ( ! $dbTrans = Yii::app()->db->getCurrentTransaction() )
		{
			throw new Exception( 'Creating new settlements from a batch requires an active DB transaction.' );
		}

		if ( $achBatch->ach_batch_header_service_class_code == '210' )
		{
			throw new Exception( 'Settlement does not currently support mixed ACH batches.' );
		}

		if ( ! $this->isNewRecord )
		{
			throw new Exception( 'Attempted to create a new Settlement record from an AchBatch, but this Settlement record is not new.' );
		}

		// If its a CREDIT ONLY ACH BATCH, we will create a DEBIT settlement to offset the CREDITS
		if ( $achBatch->ach_batch_header_service_class_code == '220' )
		{
			$this->settlement_amount = $achBatch->ach_batch_control_total_credits;
			$this->settlement_transaction_type = 'debit';
		}
		// If its a DEBIT ONLY ACH BATCH, we will create a CREDIT settlement to offset the DEBITS
		elseif ( $achBatch->ach_batch_header_service_class_code == '225' )
		{
			$this->settlement_amount = $achBatch->ach_batch_control_total_debits;
			$this->settlement_transaction_type = 'credit';
		}
		else
		{
			throw new Exception( 'Unknown service class code: ' . $achBatch->ach_batch_header_service_class_code );
		}

		$this->settlement_originator_info_id = $achBatch->ach_batch_originator_info_id;
		$achBatch->originator_info->odfi_branch;
		$this->settlement_odfi_branch_id = $achBatch->originator_info->odfi_branch->odfi_branch_id;
		$this->settlement_ach_batch_id = $achBatch->ach_batch_id;

		$this->calculateEffectiveEntryDate( $achBatch->payment_type->payment_type_transaction_type );

		$achEntry = new AchEntry();
		$achEntry->createFromSettlement( $this, $achBatch );
		if ( ! $achEntry->save() )
		{
			throw new Exception( 'Unable to save Ach Entry for settlement.' );
		}

		$this->settlement_ach_entry_id = $achEntry->ach_entry_id;

		return $this;

	}

	public function calculateEffectiveEntryDate()
	{
	
		if ( ! $achBatch = AchBatch::model()->findByPk( $this->settlement_ach_batch_id ) )
		{
			throw new Exception( 'Unable to load AchBatch for this settlement when calculating Effective Entry Date.' );
		}

		$batchDate = $achBatch->getEffectiveDateTime();

		$leadTime = Yii::app()->params['Settlement']['LeadTime'][ $this->settlement_transaction_type ];

		// The effective date of a CREDIT settlement should happen BEFORE the actual ach_batch effective date
		if ( $this->settlement_transaction_type == 'debit' && $achBatch->payment_type->payment_type_transaction_type == 'credit' )
		{
			$batchDate->sub( new DateInterval( 'P' . $leadTime . 'D' ) );
		}
		// The effective date of a DEBIT settlement should happen AFTER the actual ach_batch effective date
		elseif ( $this->settlement_transaction_type == 'credit' && $achBatch->payment_type->payment_type_transaction_type == 'debit' )
		{
			$batchDate->add( new DateInterval( 'P' . $leadTime . 'D' ) );
		}
		else
		{
			throw new Exception( 'Transaction type combination was not what was expected.' );
		}

		// Verify that we're not trying to set effective entry date to a past date
		// TODO:  This should be compared to the NEXT BUSINESS DAY!
		$curDate = new DateTime( date( 'Y-m-d' ) ); // Set this way instead of 'now' to keep the time set to midnight
		if ( $batchDate < $curDate )
		{
			throw new Exception( 'Attempted to set the settlement effective date to a date in the past.  Currently '  . $curDate->format( 'Y-m-d H:i:s' ) . ' and batch showed ' . $batchDate->format( 'Y-m-d H:i:s' ) );
		}
		
		$this->settlement_effective_entry_date = $batchDate->format( 'ymd' );
	}

	public function getEffectiveDateTime()
	{
		if ( strlen( $this->settlement_effective_entry_date ) != 6 )
		{
			throw new Exception( 'The effective entry date is not properly set.' );
		}
		$date = $this->settlement_effective_entry_date;
		$dateParts = $date[0] . $date[1] . '-' . $date[2] . $date[3] . '-' .$date[4] . $date[5];

		return new DateTime( $dateParts );
	}

	public function displaySummary()
	{
		return
			"Settlement Id:\t" . $this->settlement_id . PHP_EOL .
			"Originator:\t" . $this->originator_info->originator_info_originator_id . PHP_EOL .
			"Originator Info:\t" . $this->settlement_originator_info_id . PHP_EOL .
			"ODFI Branch:\t" . $this->settlement_odfi_branch_id . PHP_EOL . 
			"ACH Batch:\t" . $this->settlement_ach_batch_id . PHP_EOL . 
			"ACH Entry:\t" . $this->settlement_ach_entry_id . PHP_EOL .
			"Transaction Type:\t" . $this->settlement_transaction_type . PHP_EOL .
			"Amount:\t" . $this->settlement_amount . PHP_EOL .
			"Effective Date:\t" . $this->settlement_effective_entry_date . PHP_EOL;
	}

}
