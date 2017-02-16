<?php

/**
 * This is the model class for table "payment_type".
 *
 * The followings are the available columns in table 'payment_type':
 * @property string $payment_type_id
 * @property string $payment_type_originator_info_id
 * @property string $payment_type_name
 * @property string $payment_type_transaction_type
 * @property string $payment_type_status
 * @property string $payment_type_description
 * @property string $payment_type_external_account_id
 */
class PaymentType extends OADataSource
{
	// Defaults
	public $payment_type_status = 'enabled';
	public $payment_type_transaction_type = 'debit';

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PaymentType the static model class
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
		return 'payment_type';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('payment_type_id, payment_type_originator_info_id, payment_type_name, payment_type_external_account_id', 'required'),
			array('payment_type_id, payment_type_originator_info_id, payment_type_external_account_id', 'length', 'max'=>36),
			array('payment_type_description', 'length', 'max'=>255),
			array('payment_type_name', 'length', 'max'=>10),
			array('payment_type_transaction_type', 'length', 'max'=>6),
			array('payment_type_status', 'length', 'max'=>8),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('payment_type_id, payment_type_originator_info_id, payment_type_name, payment_type_transaction_type, payment_type_status', 'safe', 'on'=>'search'),
		);
	}

	public function behaviors(){
		return array(
			'CUuidKeyBehavior' => array(
				'class' => 'application.behaviors.CUuidKeyBehavior',
				'attributeList' => array (
					'payment_type_id',
				),
			),
                        'CActiveLogBehavior' => array(
                                'class' => 'application.behaviors.CActiveLogBehavior',
                                'attributeList' => array (
					'payment_type_id',
					'payment_type_name',
					'payment_type_transaction_type',
					'payment_type_status',
				),
			),
			'CValidateOwnershipBehavior' => array(
				'class' => 'application.behaviors.CValidateOwnershipBehavior',
				'modelList' => array (
					'OriginatorInfo' => 'payment_type_originator_info_id',
				),
			),
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
					'payment_type_originator_info_id'
				),
			'external_account' => array(
					self::BELONGS_TO,
					'ExternalAccount',
					'payment_type_external_account_id'
				),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'payment_type_id' => 'Payment Type',
			'payment_type_originator_info_id' => 'Origination Account',
			'payment_type_name' => 'Name',
			'payment_type_transaction_type' => 'Transaction Type',
			'payment_type_status' => 'Status',
			'payment_type_description' => 'Description',
			'payment_type_external_account_id' => 'Source/Destination Account',
		);
	}

	public function apiFields()
	{
		return array(
			'payment_type_id' => 'read',
			'payment_type_name' => 'read',
			'payment_type_transaction_type' => 'read',
			'payment_type_status' => 'read',
			'payment_type_description' => 'read',
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

		$criteria->compare('payment_type_id',$this->payment_type_id,true);
		$criteria->compare('payment_type_originator_info_id',$this->payment_type_originator_info_id,true);
		$criteria->compare('payment_type_name',$this->payment_type_name,true);
		$criteria->compare('payment_type_transaction_type',$this->payment_type_transaction_type,true);
		$criteria->compare('payment_type_status',$this->payment_type_status,true);
		$criteria->compare('payment_type_description',$this->payment_type_description,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public static function addUserJoin( CDbCriteria $criteria )
	{
		$criteria->join .= ' INNER JOIN originator_info ON ( originator_info_id = payment_type_originator_info_id ) ';
		OriginatorInfo::addUserJoin( $criteria );
	}

	public function getTransactionTypeOptions()
	{
		return Yii::app()->params['PaymentType']['TransactionType'];
	}

	public function getStatusOptions()
	{
		return Yii::app()->params['PaymentType']['Status'];
	}

	public function getServiceClassCode()
	{
		switch ( $this->payment_type_transaction_type )
		{
			case 'credit':
				return '220';
				break;
			case 'debit':
				return '225';
				break;
			default:
				return '200';
				break;
		}
	}
	
	public function verifyOwnership()
	{
		$user = Yii::app()->user->model();
		if ( ! $user )
		{
			return false;
		}
		if ( $this->originator_info
			&& $this->originator_info->originator
			&& $this->originator_info->originator->user
			&& $this->originator_info->originator->user->user_id == $user->user_id )
		{
			return true;
		}
		return parent::verifyOwnership();
	}

}
