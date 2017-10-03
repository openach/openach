<?php

/**
 * This is the model class for table "payment_schedule".
 *
 * The followings are the available columns in table 'payment_schedule':
 * @property string $payment_schedule_id
 * @property string $payment_schedule_external_account_id
 * @property string $payment_schedule_payment_type_id
 * @property string $payment_schedule_status
 * @property string $payment_schedule_amount
 * @property string $payment_schedule_currency_code
 * @property string $payment_schedule_next_date
 * @property string $payment_schedule_frequency
 * @property string $payment_schedule_end_date
 * @property integer $payment_schedule_remaining_occurrences
 */
class PaymentSchedule extends OADataSource
{

	// Default fields
	public $payment_schedule_currency_code = 'USD';
	public $payment_schedule_status = 'enabled';
	public $payment_schedule_frequency = 'once';
	public $payment_schedule_amount = '0.00';
	public $payment_schedule_next_date; 

	public function init()
	{
		// Set a default date of today
		$today = new DateTime();
		$this->payment_schedule_next_date = $today->format('Y-m-d');
		$this->payment_schedule_end_date = $today->format('Y-m-d');
		parent::init();
	}
	

	/**
	 * Returns the static model of the specified AR class.
	 * @return PaymentSchedule the static model class
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
		return 'payment_schedule';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('payment_schedule_id, payment_schedule_external_account_id, payment_schedule_payment_type_id, payment_schedule_status, payment_schedule_next_date, payment_schedule_frequency, payment_schedule_end_date', 'required'),
			array('payment_schedule_remaining_occurrences', 'numerical', 'integerOnly'=>true),
			array('payment_schedule_id, payment_schedule_external_account_id, payment_schedule_payment_type_id', 'length', 'max'=>36),
			array('payment_schedule_status', 'length', 'max'=>9),
			array('payment_schedule_amount', 'length', 'max'=>19),
			array('payment_schedule_amount', 'numerical', 'min'=>0.01, 'max'=>99999999.99),
			array('payment_schedule_currency_code', 'length', 'max'=>3),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('payment_schedule_id, payment_schedule_payment_type_id, payment_schedule_status, payment_schedule_amount, payment_schedule_currency_code, payment_schedule_next_date, payment_schedule_frequency, payment_schedule_end_date, payment_schedule_remaining_occurrences', 'safe', 'on'=>'search'),
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
			'external_account' => array(
					self::BELONGS_TO,
					'ExternalAccount',
					'payment_schedule_external_account_id'
			),
			'ach_entries' => array(
					self::HAS_MANY,
					'AchEntry',
					'ach_entry_payment_schedule_id',
			),
			'payment_type' => array(
					self::BELONGS_TO,
					'PaymentType',
					'payment_schedule_payment_type_id'
			),
		);
	}

	public function behaviors(){
		return array(
			'CUuidKeyBehavior' => array(
				'class' => 'application.behaviors.CUuidKeyBehavior',
				'attributeList' => array (
					'payment_schedule_id',
				),
			),
                        'CActiveLogBehavior' => array(
                                'class' => 'application.behaviors.CActiveLogBehavior',
                                'attributeList' => array (
					'payment_schedule_id',
					'payment_schedule_external_account_id',
					'payment_schedule_payment_type_id',
					'payment_schedule_status',
					'payment_schedule_amount',
					'payment_schedule_currency_code',
					'payment_schedule_next_date',
					'payment_schedule_frequency',
					'payment_schedule_end_date',
					'payment_schedule_remaining_occurrences',
				),
			),
			'CValidateOwnershipBehavior' => array(
				'class' => 'application.behaviors.CValidateOwnershipBehavior',
				'modelList' => array (
					'ExternalAccount' => 'payment_schedule_external_account_id',
					'PaymentType' => 'payment_schedule_payment_type_id',
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
			'payment_schedule_id' => 'Payment Schedule',
			'payment_schedule_external_account_id' => 'External Account',
			'payment_schedule_payment_type_id' => 'Payment Type',
			'payment_schedule_status' => 'Status',
			'payment_schedule_amount' => 'Amount',
			'payment_schedule_currency_code' => 'Currency',
			'payment_schedule_next_date' => 'Date',
			'payment_schedule_frequency' => 'Frequency',
			'payment_schedule_end_date' => 'End Date',
			'payment_schedule_remaining_occurrences' => 'Remaining Payments',
		);
	}

	public function apiFields()
	{
		return array(
			'payment_schedule_id' => array('read','summary'),
			'payment_schedule_external_account_id' => array('read','summary'),
			'payment_schedule_payment_type_id' => array('read','summary'),
			'payment_schedule_amount' => array('edit','summary'),
			'payment_schedule_currency_code' => array('edit'),
			'payment_schedule_next_date' => array('edit','summary'),
			'payment_schedule_frequency' => array('edit','summary'),
			'payment_schedule_end_date' => array('edit','summary'),
			'payment_schedule_remaining_occurrences' => 'edit',
			'payment_schedule_status' => 'read',
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

		$criteria->compare('payment_schedule_id',$this->payment_schedule_id,true);
		$criteria->compare('payment_schedule_external_account_id',$this->payment_schedule_external_account_id,true);
		$criteria->compare('payment_schedule_payment_type_id',$this->payment_schedule_payment_type_id,true);
		$criteria->compare('payment_schedule_status',$this->payment_schedule_status,true);
		$criteria->compare('payment_schedule_amount',$this->payment_schedule_amount,true);
		$criteria->compare('payment_schedule_currency_code',$this->payment_schedule_currency_code,true);
		$criteria->compare('payment_schedule_next_date',$this->payment_schedule_next_date,true);
		$criteria->compare('payment_schedule_frequency',$this->payment_schedule_frequency,true);
		$criteria->compare('payment_schedule_end_date',$this->payment_schedule_end_date,true);
		$criteria->compare('payment_schedule_remaining_occurrences',$this->payment_schedule_remaining_occurrences);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public static function addUserJoin( CDbCriteria $criteria )
	{
		$criteria->join .= ' INNER JOIN external_account ON ( external_account_id = payment_schedule_external_account_id ) ';
		ExternalAccount::addUserJoin( $criteria );
	}

	public function getStatusOptions()
	{
		return Yii::app()->params['PaymentSchedule']['Status'];
	}

	public function getFrequencyOptions()
	{
		return Yii::app()->params['PaymentSchedule']['Frequency'];
	}

	public function getCurrencyCodeOptions()
	{
		return Yii::app()->params['Currency']['Code'];
	}

	public function displayAmount()
	{
		$verb = ( $this->payment_type->payment_type_transaction_type == 'credit' ) ? 'Deposit' : 'Withdraw';
		if ( $this->payment_schedule_amount > 0 )
		{
			return $verb . ' $' . number_format( (double) $this->payment_schedule_amount, 2 );
		}
		else
		{
			return $verb . ' $' . number_format( abs( $this->payment_schedule_amount ), 2 );
		}
	}

	public function displayScheduleInfo()
	{
		if ( $this->payment_schedule_remaining_occurrences > 1 )
		{
			return ucfirst( $this->payment_schedule_frequency ) . ' (' . 
				$this->payment_schedule_remaining_occurrences . ' more time' .
				( $this->payment_schedule_remaining_occurrences == 1 ? '' : 's' ) .
				') until ' . $this->displayEndDate();
		}
		else
		{
			return 'Occurs once';
		}
	}

	public function displayEndDate()
	{
		return $this->formatDate( $this->payment_schedule_end_date );
	}

	public function displayNextDate()
	{
		return $this->formatDate( $this->payment_schedule_next_date );
	}

	public function displayStatus()
	{
		return ucfirst( $this->payment_schedule_status );
	}

	public function run()
	{
	 	if ( $this->isNewRecord )
		{
			throw new Exception( 'Attempted to run a schedule that has not been saved.' );
		}

		// To be safe, we will recalculate the remaining occurrences every time the schedule is run
		$remaining = $this->payment_schedule_remaining_occurrences;
		$this->calculateRemaining();

		// check to see if remaining has changed, and if it has, save
		if ( $remaining != $this->payment_schedule_remaining_occurrences )
		{
			if ( ! $this->save() )
			{
				throw new Exception( 'Unable to save payment schedule after recalculating the remaining occurrences.' );
			}
		}
		// Never run a schedule past its remaining occurrences.
		if ( $this->payment_schedule_remaining_occurrences <= 0 )
		{
			return;
		}

		$dbTransaction = $this->dbConnection->beginTransaction();

		try
		{
			// Create a new AchEntry
			$achEntry = new AchEntry();
			$achEntry->createFromPaymentSchedule( $this );

			if ( ! $achEntry->save() )
			{
				var_dump( $achEntry->getErrors() );
				throw new Exception( 'Unable to save the ACH entry.' );
			}

			// Log the payment to the payment event log
			$this->logPaymentEvent( $achEntry );

			if ( Yii::app()->params['SkipMissedSchedules'] )
			{
				// Continue advancing the schedule until it has a future date
				while ( $this->hasFutureNextDate() )
				{
					$this->advanceSchedule();
				}
			}
			else
			{
				// Advance the scheudle to the next schedule date
				$this->advanceSchedule();
			}

			$this->payment_schedule_remaining_occurrences--;

			// If there are remaining occurernces, advance the schedule's next date
			if ( $this->payment_schedule_remaining_occurrences > 0 )
			{
				$currentDate = new DateTime( $this->payment_schedule_next_date );
				$this->payment_schedule_next_date = date( 'Y-m-d', strtotime( $this->getRelativeDateFormat(), $currentDate->getTimestamp() ) );
			}
			// Save the updated payment schedule
			if ( ! $this->save() )
			{
				throw new Exception( 'Unable to save the payment schedule.' );
			}
			$dbTransaction->commit();
		}
		catch ( Exception $e )
		{
			$dbTransaction->rollback();
			throw $e;
		}
		
	}

	protected function advanceSchedule()
	{
		if ( $this->payment_schedule_remaining_occurrences > 0 )
		{
			$this->payment_schedule_remaining_occurrences--;
			// If there are remaining occurrences, advance to the next date
			if ( $this->payment_schedule_remaining_occurrences > 0 )
			{
				$currentDate = new DateTime( $this->payment_schedule_next_date );
				$this->payment_schedule_next_date = date( 'Y-m-d', strtotime( $this->getRelativeDateFormat(), $currentDate->getTimestamp() ) );
			}
		}	
	}

	public function hasFutureNextDate()
	{
		$scheduleDate = new DateTime( $this->payment_schedule_next_date );
		$today = new DateTime();
		return ( $scheduleDate > $today ) ? true : false;
	}

	public function logPaymentEvent( $achEntry )
	{
		if ( ! $achEntry->ach_entry_id )
		{
			throw new Exception( 'Unable to log payment event without a valid ach entry.' );
		}
		// Log the payment to the payment event log
		$eventLog = new OAActiveLog();
		$eventLog->setTableName( 'payment_event_log' );
		$eventLog->setAttribute( 'ach_entry_id', $achEntry->ach_entry_id );
		$eventLog->setAttribute( 'payment_schedule_id', $this->payment_schedule_id );
		$eventLog->setAttribute( 'payment_schedule_external_account_id', $this->payment_schedule_external_account_id );
		$eventLog->setAttribute( 'payment_schedule_payment_type_id', $this->payment_schedule_payment_type_id );
		$eventLog->setAttribute( 'payment_schedule_amount', $this->payment_schedule_amount );

		if ( ! $eventLog->save() )
		{
			throw new Exception( 'Unable to save the payment event log for this schedule.' );
		}
	}

	public function calculateRemaining()
	{
		// Never adjust remaining occurreces for schedules that have no remaining
		if ( $this->payment_schedule_remaining_occurrences <= 0 )
		{
			return;
		}
		if ( $this->payment_schedule_frequency == 'once' )
		{
			$this->payment_schedule_remaining_occurrences = 1;
			return;
		}
		$remainingCounter = 0;
		$nextDate = new DateTime( $this->payment_schedule_next_date );
		$endDate = new DateTime( $this->payment_schedule_end_date );
		$interval = $this->getDateInterval();

		// As soon as our next date is past the end date, our counting is over
		while ( $nextDate < $endDate )
		{
			// Advance the next date by the interval
			$nextDate->add( $interval );
			// If the next date is still before the end date, increment the counter
			if ( $nextDate < $endDate )
			{
				$remainingCounter++;
			}
		}

		$this->payment_schedule_remaining_occurrences = $remainingCounter;
	}
	protected function getRelativeDateFormat()
	{
		switch ( $this->payment_schedule_frequency )
		{
			case 'once':
				$interval = '';
				break;
			case 'daily':
				$interval = '+1 day';
				break;
			case 'weekly':
				$interval = '+1 week';
				break;
			case 'biweekly':
				$interval = '+2 week';
				break;
			case 'monthly':
				$interval = '+1 month';
				break;
			case 'bimonthly':
				$interval = '+2 month';
				break;
			case 'biannually':
				$interval = '+6 month';
				break;
			case 'annually':
				$interval = '+1 year';
				break;
			case 'biennially':
				$interval = '+2 year';
				break;
			default:
				$interval = '';
				break;
		}

		return $interval;
	}

	protected function getDateInterval()
	{
		switch ( $this->payment_schedule_frequency )
		{
			case 'once':
				$interval = new DateInterval( 'P0D' );
				break;
			case 'daily':
				$interval = new DateInterval( 'P1D' );
				break;
			case 'weekly':
				$interval = new DateInterval( 'P7D' );
				break;
			case 'biweekly':
				$interval = new DateInterval( 'P14D' );
				break;
			case 'monthly':
				$interval = new DateInterval( 'P1M' );
				break;
			case 'bimonthly':
				$interval = new DateInterval( 'P2M' );
				break;
			case 'biannually':
				$interval = new DateInterval( 'P6M' );
				break;
			case 'annually':
				$interval = new DateInterval( 'P1Y' );
				break;
			case 'biennially':
				$interval = new DateInterval( 'P2Y' );
				break;
			default:
				$interval = new DateInterval( 'P0D' );
				break;
		}

		return $interval;
	}

	public function adjustFrequency()
	{
		switch ( $this->payment_schedule_frequency )
		{
			case 'annually':
				$this->payment_schedule_frequency = 'annually';
				break;
			case 'biannually':
				$this->payment_schedule_frequency = 'biannually';
				break;
		}
	}

	public function beforeSave()
	{
		if ( parent::beforeSave() )
		{
			$this->adjustFrequency();
			$this->calculateRemaining();
			return true;
		}
	}

}
