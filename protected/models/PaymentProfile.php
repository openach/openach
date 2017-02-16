<?php

/**
 * This is the model class for table "payment_profile".
 *
 * The followings are the available columns in table 'payment_profile':
 * @property string $payment_profile_id
 * @property string $payment_profile_originator_info_id
 * @property string $payment_profile_external_id
 * @property string $payment_profile_password
 * @property string $payment_profile_first_name
 * @property string $payment_profile_last_name
 * @property string $payment_profile_email_address
 * @property string $payment_profile_security_question_1
 * @property string $payment_profile_security_question_2
 * @property string $payment_profile_security_question_3
 * @property string $payment_profile_security_answer_1
 * @property string $payment_profile_security_answer_2
 * @property string $payment_profile_security_answer_3
 * @property string $payment_profile_status
 */
class PaymentProfile extends OADataSource
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return PaymentProfile the static model class
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
		return 'payment_profile';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('payment_profile_id, payment_profile_originator_info_id, payment_profile_external_id, payment_profile_email_address', 'required'),
			array('payment_profile_id, payment_profile_originator_info_id', 'length', 'max'=>36),
			array('payment_profile_first_name, payment_profile_last_name', 'length', 'max'=>50),
			array('payment_profile_external_id, payment_profile_password', 'length', 'max'=>125),
			array('payment_profile_email_address, payment_profile_security_question_1, payment_profile_security_question_2, payment_profile_security_question_3, payment_profile_security_answer_1, payment_profile_security_answer_2, payment_profile_security_answer_3', 'length', 'max'=>255),
			array('payment_profile_status', 'length', 'max'=>9),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('payment_profile_id, payment_profile_originator_info_id, payment_profile_external_id, payment_profile_password, payment_profile_first_name, payment_profile_last_name, payment_profile_email_address, payment_profile_security_question_1, payment_profile_security_question_2, payment_profile_security_question_3, payment_profile_security_answer_1, payment_profile_security_answer_2, payment_profile_security_answer_3, payment_profile_status', 'safe', 'on'=>'search'),
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
					'payment_profile_originator_info_id'
				),
			'external_accounts' => array(
					self::HAS_MANY,
					'ExternalAccount',
					'external_account_payment_profile_id',
					//'alias' => 'external_account',
				),
//			'active_payment_schedule' => array(
//					self::HAS_MANY,
//					'PaymentSchedule',
//					'payment_schedule_payment_profile_id',
//					//'condition' => 'payment_schedule_status = "enabled" AND payment_schedule_end_date >= NOW()',
//					'alias' => 'payment_schedule',
//				),
		);
	}

	public function behaviors(){
		return array(
			// Hashed data is used for freeSearch to enable searching on encrypted values
			'CHashDataBehavior' => array(
				'class' => 'application.behaviors.CHashDataBehavior',
				'attributeList' => array(
					'payment_profile_first_name'	=>	array(
						'method' => 'sha1',
						'target' => 'payment_profile_first_name_hash',
					),
					'payment_profile_last_name'	=>	array(
						'method' => 'sha1',
						'target' => 'payment_profile_last_name_hash',
					),
				),
			),
			'CEncryptionBehavior' => array(
				'class' => 'application.behaviors.CEncryptionBehavior',
				'attributeList' => array (
					'payment_profile_first_name'		=> 'crypt',
					'payment_profile_last_name'		=> 'crypt',
					'payment_profile_password'		=> 'crypt',
					'payment_profile_security_question_1'      => 'crypt',
					'payment_profile_security_question_2'      => 'crypt',
					'payment_profile_security_question_3'      => 'crypt',
					'payment_profile_security_answer_1'	=> 'crypt',
					'payment_profile_security_answer_2'	=> 'crypt',
					'payment_profile_security_answer_3'	=> 'crypt',
				),
			),
			'CUuidKeyBehavior' => array(
				'class' => 'application.behaviors.CUuidKeyBehavior',
				'attributeList' => array (
					'payment_profile_id',
				),
			),
			'CPhoneticDataBehavior' => array(
				'class' => 'application.behaviors.CPhoneticDataBehavior',
				'attributeList' => array (
					array( 'attribute'=>'payment_profile_first_name', 'dataType'=>'first_name', 'method'=>'soundex' ),
					array( 'attribute'=>'payment_profile_first_name', 'dataType'=>'first_name', 'method'=>'nysiis' ),
					array( 'attribute'=>'payment_profile_first_name', 'dataType'=>'first_name', 'method'=>'metaphone2' ),
					array( 'attribute'=>'payment_profile_last_name', 'dataType'=>'last_name', 'method'=>'soundex' ),
					array( 'attribute'=>'payment_profile_last_name', 'dataType'=>'last_name', 'method'=>'nysiis' ),
					array( 'attribute'=>'payment_profile_last_name', 'dataType'=>'last_name', 'method'=>'metaphone2' ),
				),
				'targetModel' => 'PhoneticData',
			),
                        'CActiveLogBehavior' => array(
                                'class' => 'application.behaviors.CActiveLogBehavior',
                                'attributeList' => array (
					'payment_profile_id',
					'payment_profile_external_id',
					'payment_profile_first_name',
					'payment_profile_last_name',
					'payment_profile_email_address',
					'payment_profile_status',
				),
			),
			'CValidateOwnershipBehavior' => array(
				'class' => 'application.behaviors.CValidateOwnershipBehavior',
				'modelList' => array (
					'OriginatorInfo' => 'payment_profile_originator_info_id',
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
			'payment_profile_id' => 'Payment Profile',
			'payment_profile_originator_info_id' => 'Originator Account',
			'payment_profile_external_id' => 'External ID',
			'payment_profile_password' => 'Password',
			'payment_profile_first_name' => 'First Name',
			'payment_profile_last_name' => 'Last Name',
			'payment_profile_email_address' => 'Email',
			'payment_profile_security_question_1' => 'Security Question 1',
			'payment_profile_security_question_2' => 'Security Question 2',
			'payment_profile_security_question_3' => 'Security Question 3',
			'payment_profile_security_answer_1' => 'Security Answer 1',
			'payment_profile_security_answer_2' => 'Security Answer 2',
			'payment_profile_security_answer_3' => 'Security Answer 3',
			'payment_profile_status' => 'Status',
		);
	}

	public function apiFields()
	{
		return array(
			'payment_profile_id' => 'read',
			'payment_profile_external_id' => 'edit',
			'payment_profile_first_name' => 'edit',
			'payment_profile_last_name' => 'edit',
			'payment_profile_email_address' => 'edit',
			'payment_profile_password' => 'edit',
			'payment_profile_security_question_1' => 'edit',
			'payment_profile_security_question_2' => 'edit',
			'payment_profile_security_question_3' => 'edit',
			'payment_profile_security_answer_1' => 'edit',
			'payment_profile_security_answer_2' => 'edit',
			'payment_profile_security_answer_3' => 'edit',
			'payment_profile_status' => 'read',
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

		$criteria->compare('payment_profile_id',$this->payment_profile_id,true);
		$criteria->compare('payment_profile_originator_info_id',$this->payment_profile_originator_info_id,true);
		$criteria->compare('payment_profile_external_id',$this->payment_profile_external_id,true);
		$criteria->compare('payment_profile_password',$this->payment_profile_password,true);
		$criteria->compare('payment_profile_first_name',$this->payment_profile_first_name,true);
		$criteria->compare('payment_profile_last_name',$this->payment_profile_last_name,true);
		$criteria->compare('payment_profile_email_address',$this->payment_profile_email_address,true);
		$criteria->compare('payment_profile_security_question_1',$this->payment_profile_security_question_1,true);
		$criteria->compare('payment_profile_security_question_2',$this->payment_profile_security_question_2,true);
		$criteria->compare('payment_profile_security_question_3',$this->payment_profile_security_question_3,true);
		$criteria->compare('payment_profile_security_answer_1',$this->payment_profile_security_answer_1,true);
		$criteria->compare('payment_profile_security_answer_2',$this->payment_profile_security_answer_2,true);
		$criteria->compare('payment_profile_security_answer_3',$this->payment_profile_security_answer_3,true);
		$criteria->compare('payment_profile_status',$this->payment_profile_status,true);

		return new CActiveDataProvider($this, array(
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
					'payment_profile_first_name_hash' => sha1( strtolower( $keyword ) ), // enables searching on normally encrypted values
					'payment_profile_last_name_hash' => sha1( strtolower( $keyword ) ), // enables searching on normally encrypted values
					'payment_profile_external_id' => $keyword,
					'payment_profile_email_address' => $keyword,
				);
			$criteria->addColumnSearchCondition( $condition, 'OR' );
		}

		self::addUserJoin( $criteria );

		$criteria->limit = 20;

		return new CActiveDataProvider( $this, array( 'criteria'=>$criteria) );
	}

	public static function addUserJoin( CDbCriteria $criteria )
	{
		$criteria->join .= ' INNER JOIN originator_info ON ( originator_info_id = payment_profile_originator_info_id ) ';
		OriginatorInfo::addUserJoin( $criteria );
	}

	public function displayCustomer()
	{
		return $this->payment_profile_first_name . ' ' . $this->payment_profile_last_name;
	}

	public function displayEmailAddress()
	{
		return $this->payment_profile_email_address;
	}

	public function displayStatus()
	{
		return 'Status: ' . ucfirst( $this->payment_profile_status );
	}

	public function displayExternalId()
	{
		return 'External ID: ' . ( $this->payment_profile_external_id ? $this->payment_profile_external_id : '<em>not set</em>' );
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



}
