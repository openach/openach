<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

/**
 * This is the model class for table "ach_file".
 *
 * The followings are the available columns in table 'ach_file':
 * @property string $ach_file_id
 * @property string $ach_file_datetime
 * @property string $ach_file_status
 * @property string $ach_file_odfi_branch_id
 * @property string $ach_file_originator_id
 * @property string $ach_file_header_priority_code
 * @property string $ach_file_header_immediate_destination
 * @property string $ach_file_header_immediate_origin
 * @property string $ach_file_header_file_creation_date
 * @property string $ach_file_header_file_creation_time
 * @property string $ach_file_header_file_id_modifier
 * @property string $ach_file_header_record_size
 * @property string $ach_file_header_blocking_factor
 * @property string $ach_file_header_format_code
 * @property string $ach_file_header_immediate_destination_name
 * @property string $ach_file_header_immediate_origin_name
 * @property string $ach_file_header_reference_code
 * @property string $ach_file_control_batch_count
 * @property string $ach_file_control_block_count
 * @property string $ach_file_control_entry_addenda_count
 * @property string $ach_file_control_entry_hash
 * @property string $ach_file_control_total_debits
 * @property string $ach_file_control_total_credits
 */
class AchFile extends OADataSource
{
	public $ach_record_type_code = '1';
	public $reserved = '';

	// Set defaults
	public $ach_file_status = 'pending';
	public $ach_file_header_priority_code = '01';
	public $ach_file_header_record_size = '094';
	public $ach_file_header_blocking_factor = '10';
	public $ach_file_header_format_code = '1';
	public $ach_file_control_entry_addenda_count = 0;
	public $ach_file_control_batch_count = 0;

	/**
	 * Returns the static model of the specified AR class.
	 * @return AchFile the static model class
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
		return 'ach_file';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ach_file_id, ach_file_datetime, ach_file_odfi_branch_id, ach_file_originator_id', 'required'),
			array('ach_file_id, ach_file_odfi_branch_id, ach_file_originator_id', 'length', 'max'=>36),
			array('ach_file_status', 'length', 'max'=>11),
			array('ach_file_header_priority_code, ach_file_header_blocking_factor', 'length', 'max'=>2),
			array('ach_file_control_entry_hash', 'length', 'max'=>10),
			array('ach_file_header_immediate_origin, ach_file_header_immediate_origin_name', 'length', 'max'=>125),
			array('ach_file_header_immediate_destination, ach_file_header_immediate_destination_name', 'length', 'max'=>125),
			array('ach_file_header_file_creation_date, ach_file_control_batch_count, ach_file_control_block_count', 'length', 'max'=>6),
			array('ach_file_header_file_creation_time', 'length', 'max'=>4),
			array('ach_file_header_file_id_modifier, ach_file_header_format_code', 'length', 'max'=>1),
			array('ach_file_header_record_size', 'length', 'max'=>3),
			array('ach_file_header_reference_code, ach_file_control_entry_addenda_count', 'length', 'max'=>8),
			array('ach_file_control_total_debits, ach_file_control_total_credits', 'length', 'max'=>12),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('ach_file_id, ach_file_datetime, ach_file_status, ach_file_odfi_branch_id, ach_file_originator_id, ach_file_header_priority_code, ach_file_header_immediate_destination, ach_file_header_immediate_origin, ach_file_header_file_creation_date, ach_file_header_file_creation_time, ach_file_header_file_id_modifier, ach_file_header_record_size, ach_file_header_blocking_factor, ach_file_header_format_code, ach_file_header_immediate_destination_name, ach_file_header_immediate_origin_name, ach_file_header_reference_code, ach_file_control_batch_count, ach_file_control_block_count, ach_file_control_entry_addenda_count, ach_file_control_entry_hash, ach_file_control_total_debits, ach_file_control_total_credits', 'safe', 'on'=>'search'),
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
			'ach_batches' => array(
					self::HAS_MANY,
					'AchBatch',
					'ach_batch_ach_file_id'
				),
			'odfi_branch' => array(
					self::BELONGS_TO,
					'OdfiBranch',
					'ach_file_odfi_branch_id'
				),
			'originator' => array(
					self::BELONGS_TO,
					'OriginatorInfo',
					'ach_file_originator_id',
				),
			'file_transfer' => array(
					self::HAS_MANY,
					'FileTransfer',
					'file_transfer_file_id',
					'condition' => 'file_transfer.file_transfer_model = :file_transfer_model',
					'params' => array( 'file_transfer_model' => 'AchFile' ),
				),
		);
	}


	public function behaviors(){
		return array(
			'CEncryptionBehavior' => array(
				'class' => 'application.behaviors.CEncryptionBehavior',
				'attributeList' => array (
					'ach_file_header_immediate_origin'	=> 'crypt',
					'ach_file_header_immediate_origin_name'	=> 'crypt',
					'ach_file_header_immediate_destination'      => 'crypt',
					'ach_file_header_immediate_destination_name' => 'crypt',
				),
			),
			'CUuidKeyBehavior' => array(
				'class' => 'application.behaviors.CUuidKeyBehavior',
				'attributeList' => array (
					'ach_file_id',
				),
			),
                        'CEntityIndexIncrementingBehavior' => array(
                                'class' => 'application.behaviors.CEntityIndexIncrementingBehavior',
                                'attributeList' => array (
                                        'ach_file_header_reference_code',
                                ),
                        ),
			'CDatetimeBehavior' => array(
				'class' => 'application.behaviors.CDatetimeBehavior',
				'attributeList' => array(
					'ach_file_datetime',
				),
			),
                        'CActiveLogBehavior' => array(
                                'class' => 'application.behaviors.CActiveLogBehavior',
                                'attributeList' => array (
					'ach_file_id',
					'ach_file_status',
					'ach_file_header_file_creation_date',
					'ach_file_header_file_creation_time',
					'ach_file_header_file_id_modifier',
					'ach_file_header_reference_code',
					'ach_file_control_batch_count',
					'ach_file_control_block_count',
					'ach_file_control_entry_addenda_count',
					'ach_file_control_entry_hash',
					'ach_file_control_total_debits',
					'ach_file_control_total_credits',
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
			'ach_file_id' => 'Ach File',
			'ach_file_datetime' => 'Datetime',
			'ach_file_status' => 'Status',
			'ach_file_odfi_branch_id' => 'Bank Branch',
			'ach_file_originator_id' => 'Originator Account',
			'ach_file_header_priority_code' => 'Priority Code',
			'ach_file_header_immediate_destination' => 'Immediate Destination',
			'ach_file_header_immediate_origin' => 'Immediate Origin',
			'ach_file_header_file_creation_date' => 'File Creation Date',
			'ach_file_header_file_creation_time' => 'File Creation Time',
			'ach_file_header_file_id_modifier' => 'File Id Modifier',
			'ach_file_header_record_size' => 'Record Size',
			'ach_file_header_blocking_factor' => 'Blocking Factor',
			'ach_file_header_format_code' => 'Format Code',
			'ach_file_header_immediate_destination_name' => 'Immediate Destination Name',
			'ach_file_header_immediate_origin_name' => 'Immediate Origin Name',
			'ach_file_header_reference_code' => 'Reference Code',
			'ach_file_control_batch_count' => 'Batch Count',
			'ach_file_control_block_count' => 'Block Count',
			'ach_file_control_entry_addenda_count' => 'Entry Addenda Count',
			'ach_file_control_entry_hash' => 'Entry Hash',
			'ach_file_control_total_debits' => 'Total Debits',
			'ach_file_control_total_credits' => 'Total Credits',
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

		$criteria->compare('ach_file_id',$this->ach_file_id,true);
		$criteria->compare('ach_file_datetime',$this->ach_file_datetime,true);
		$criteria->compare('ach_file_status',$this->ach_file_status,true);
		$criteria->compare('ach_file_odfi_branch_id',$this->ach_file_odfi_branch_id,true);
		$criteria->compare('ach_file_originator_id',$this->ach_file_originator_id,true);
		$criteria->compare('ach_file_header_priority_code',$this->ach_file_header_priority_code,true);
		$criteria->compare('ach_file_header_immediate_destination',$this->ach_file_header_immediate_destination,true);
		$criteria->compare('ach_file_header_immediate_origin',$this->ach_file_header_immediate_origin,true);
		$criteria->compare('ach_file_header_file_creation_date',$this->ach_file_header_file_creation_date,true);
		$criteria->compare('ach_file_header_file_creation_time',$this->ach_file_header_file_creation_time,true);
		$criteria->compare('ach_file_header_file_id_modifier',$this->ach_file_header_file_id_modifier,true);
		$criteria->compare('ach_file_header_record_size',$this->ach_file_header_record_size,true);
		$criteria->compare('ach_file_header_blocking_factor',$this->ach_file_header_blocking_factor,true);
		$criteria->compare('ach_file_header_format_code',$this->ach_file_header_format_code,true);
		$criteria->compare('ach_file_header_immediate_destination_name',$this->ach_file_header_immediate_destination_name,true);
		$criteria->compare('ach_file_header_immediate_origin_name',$this->ach_file_header_immediate_origin_name,true);
		$criteria->compare('ach_file_header_reference_code',$this->ach_file_header_reference_code,true);
		$criteria->compare('ach_file_control_batch_count',$this->ach_file_control_batch_count,true);
		$criteria->compare('ach_file_control_block_count',$this->ach_file_control_block_count,true);
		$criteria->compare('ach_file_control_entry_addenda_count',$this->ach_file_control_entry_addenda_count,true);
		$criteria->compare('ach_file_control_entry_hash',$this->ach_file_control_entry_hash,true);
		$criteria->compare('ach_file_control_total_debits',$this->ach_file_control_total_debits,true);
		$criteria->compare('ach_file_control_total_credits',$this->ach_file_control_total_credits,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}

        public static function addUserJoin( CDbCriteria $criteria )
        {
                $criteria->join .= ' INNER JOIN originator ON ( originator_id = ach_file_originator_id ) ';
                Originator::addUserJoin( $criteria );
        }

	public function createFromOriginatorInfo( $originatorInfo )
	{
		// TODO:  This needs to be fixed.  Instead of originator info, we'll need the originator and the odfi_branch we're processing through.
		// This is fixed by using createFromOdfiBranch instead of this method
		throw new Exception( 'This no longer works because AchFiles are linked to originators, not originator infos.  Use createFromOdfiBranch instead.' );
		$this->ach_file_odfi_branch_id = $originatorInfo->odfi_branch->odfi_branch_id;
		$this->ach_file_originator_id = $originatorInfo->originator_id;
		$this->ach_file_header_immediate_destination = $originatorInfo->odfi_branch->odfi_branch_dfi_id;
		$this->ach_file_header_immediate_origin = $originatorInfo->originator_info_identification;
		$this->ach_file_header_immediate_destination_name = $originatorInfo->odfi_branch->odfi_branch_name;
		$this->ach_file_header_immediate_origin_name = $originatorInfo->originator_info_name;
		return $this;
	}

	public function createFromOdfiBranch( $odfiBranch )
	{
		$this->ach_file_odfi_branch_id = $odfiBranch->odfi_branch_id;
		$this->ach_file_originator_id = $odfiBranch->originator->originator_id;
		$this->ach_file_header_immediate_destination = $odfiBranch->odfi_branch_dfi_id;
		$this->ach_file_header_immediate_origin = $odfiBranch->originator->originator_identification;
		$this->ach_file_header_immediate_destination_name = $odfiBranch->odfi_branch_name;
		$this->ach_file_header_immediate_origin_name = $odfiBranch->originator->originator_name;
		return $this;
	}

	public function setFileCreationDate( DateTime $dateTime )
	{
		$this->ach_file_header_file_creation_date = $dateTime->format( 'ymd' );
		$this->ach_file_header_file_creation_time = $dateTime->format( 'Hi' );
		$this->ach_file_header_file_id_modifier = $this->getFirstUnusedIdModifier();
	}

	public function getFirstUnusedIdModifier()
	{
		// The easiest way to find the next available modifier is to count how many files
		// already exist for the current odfi_branch_id, and use that number to pick the
		// next modifier from an array.  For instance, if there are 3 files, the modifier
		// index of 3 will give us 'D' (zero-based index means 3 is the 4th item)
		// The NACHA spec allows up to 36 files with the same file creation date/time
		// You can expect the modifier to stay as A unless you split processing over
		// multiple files and generate them all at the exact same time.

		$command = Yii::app()->db->createCommand();
		$command->select = 'COUNT( ach_file_id ) AS file_count';
		$command->from( 'ach_file' )
			->where(
				array(
					'AND', 'ach_file_odfi_branch_id = :ach_file_odfi_branch_id',
					'ach_file_header_file_creation_date = :ach_file_header_file_creation_date',
					'ach_file_header_file_creation_time = :ach_file_header_file_creation_time',
					'ach_file_id != :ach_file_id', // In the off chance that we find the current file (e.g. regeneration of the same file)
				),
				array(
					':ach_file_odfi_branch_id'=>$this->ach_file_odfi_branch_id,
					':ach_file_header_file_creation_date'=>$this->ach_file_header_file_creation_date,
					':ach_file_header_file_creation_time'=>$this->ach_file_header_file_creation_time,
					':ach_file_id'=>$this->ach_file_id,
				)
			);

		$result = $command->queryRow();
		if ( ! $result )
		{
			throw new Exception( 'Unable to obtain ACH file count.' );
		}
		else
		{
			$modifiers = array( 
					'A', 'B', 'C', 'D', 'E', 
					'F', 'G', 'H', 'I', 'J', 
					'K', 'L', 'M', 'N', 'O', 
					'P', 'Q', 'R', 'S', 'T', 
					'U', 'V', 'W', 'X', 'Y', 
					'Z', '0', '1', '2', '3', 
					'4', '5', '6', '7', '8', '9' 
				);
			if ( $result['file_count'] >= count( $modifiers ) )
			{
				throw new Exception( 'No file ID modifiers remaining for this ODFI branch for the current file date/time.' );
			}
			else
			{
				return $modifiers[ $result['file_count'] ];
			}
		}
	}

	public function displayDate()
	{
		return $this->formatDate( $this->ach_file_datetime );
	}

	public function displayStatus()
	{
		return ucfirst( $this->ach_file_status );
	}

	public function displayFileId()
	{
		if ( ! $this->ach_file_header_file_creation_date || ! $this->ach_file_header_file_creation_time || ! $this->ach_file_header_file_id_modifier )
		{
			$fileDate = new DateTime( $this->ach_file_datetime );
			return 'New File (' . $fileDate->format( 'm/d/Y') . ')';
		}
		return 'File ID: ' . $this->ach_file_header_file_creation_date . $this->ach_file_header_file_creation_time . $this->ach_file_header_file_id_modifier;
	}

	public function displayDebits()
	{
		return 'Total Debits: $' . number_format( (double) $this->ach_file_control_total_debits / 100, 2 );
	}

	public function displayCredits()
	{
		return 'Total Credits: $' . number_format( (double) $this->ach_file_control_total_credits / 100, 2 );
	}

	public function displayEntryHash()
	{
		return 'Entry Hash: ' . ( $this->ach_file_control_entry_hash ? $this->ach_file_control_entry_hash : 'n/a' );
	}

	public function displayBatchCount()
	{
		return 'Batch Count: ' . $this->ach_file_control_batch_count;
	}

	public function displayEntryAddendaCount()
	{
		return 'Entry/Addenda Count: ' . ( $this->ach_file_control_entry_addenda_count ? $this->ach_file_control_entry_addenda_count : 'n/a' );
	}

	public function displayReferenceCode()
	{
		return 'Reference #' . ( $this->ach_file_header_reference_code ? $this->ach_file_header_reference_code : 'n/a' );
	}

	public function getCalculateQuery()
	{
		if ( Yii::app()->db->schema instanceof CMysqlSchema )
		{
			$debitsField = 'ach_batch_control_total_debits';
			$creditsField = 'ach_batch_control_total_credits';
		}
		if ( Yii::app()->db->schema instanceof CPgsqlSchema )
		{
			$debitsField = "to_number( ach_batch_control_total_debits, '999999999999' )";
			$creditsField = "to_number( ach_batch_control_total_credits, '999999999999' )";
		}
		if ( Yii::app()->db->schema instanceof CSqliteSchema )
		{
			$debitsField = 'cast( ach_batch_control_total_debits AS INTEGER )';
			$creditsField = 'cast( ach_batch_control_total_credits AS INTEGER )';
		}

		return Yii::app()->db->createCommand()
			->select('SUM( ' . $debitsField . ' ) AS total_debits, SUM( ' . $creditsField . ' ) AS total_credits' )
			->from( 'ach_batch' )
			->join( 'ach_file', 'ach_batch_ach_file_id = ach_file_id AND ach_file_id = :ach_file_id', array(':ach_file_id'=>$this->ach_file_id) );
	}

        public function calculateTotals( $recalculate=false )
        {

                if ( ! $recalculate && ( $this->ach_file_control_total_debits != 0 || $this->ach_file_control_total_debits != 0 ) )
                {
                        throw new Exception( 'Attempted to calculate non-zero file totals without specifying recalculate.' );
                }

		$command = $this->getCalculateQuery();

                if ( ! $result = $command->queryRow() )
                {
                        $this->ach_file_control_total_credits = 0;
			$this->ach_file_control_total_debits = 0;
                }
                else
                {
                        $this->ach_file_control_total_credits = ( $result['total_credits'] ? $result['total_credits'] : 0 );
			$this->ach_file_control_total_debits = ( $result['total_debits'] ? $result['total_debits'] : 0 );
                }

        }

	public function calculateEntryHash()
	{
		if ( Yii::app()->db->schema instanceof CMysqlSchema )
		{
			$sumField = 'ach_batch_control_entry_hash';
		}
		if ( Yii::app()->db->schema instanceof CPgsqlSchema )
		{
			$sumField = "to_number( ach_batch_control_entry_hash, '9999999999' )";
		}
		if ( Yii::app()->db->schema instanceof CSqliteSchema )
		{
			$sumField = 'cast( ach_batch_control_entry_hash as INTEGER)';
		}

		$command = Yii::app()->db->createCommand()
			->select('SUM( ' . $sumField . ' ) AS hash' )
			->from( 'ach_batch' )
			->join( 'ach_file', 'ach_batch_ach_file_id = ach_file_id AND ach_file_id = :ach_file_id' );

		if ( ! $hashResult = $command->queryRow( true, array( ':ach_file_id'=>$this->ach_file_id ) ) )
		{
			throw new Exception( 'Unable to calculate entry hash for file.' );
		}
		else
		{
			$this->ach_file_control_entry_hash = substr( $hashResult['hash'], -10 );
		}
	}


	public function build()
	{
		if ( ! $this->odfi_branch )
		{
			throw new Exception( 'This file has not been assigned an odfi_branch.' );
		}
		
		$bankConfig = $this->odfi_branch->getBankConfig();

		// set the date/time and modifier ID
		$this->setFileCreationDate( new DateTime() );
		
		if ( ! $bankConfig )
		{
			throw new Exception( 'Unable to load the bank config for the odfi_branch.' );
		}

		$fileBuilder = new OAFileBuilder( $bankConfig );

		return $fileBuilder->build( $this );
	}
}
