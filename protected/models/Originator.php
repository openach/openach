<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

/**
 * This is the model class for table "originator".
 *
 * The followings are the available columns in table 'originator':
 * @property string $originator_id
 * @property string $originator_datetime
 * @property string $originator_user_id
 * @property string $originator_name
 * @property string $originator_identification
 * @property string $originator_address
 * @property string $originator_city
 * @property string $originator_state_province
 * @property string $originator_postal_code
 * @property string $originator_country_code
 */
class Originator extends OADataSource
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Originator the static model class
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
		return 'originator';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		$rules = array(
			array('originator_id, originator_user_id, originator_name, originator_identification', 'required'),
			array('originator_id, originator_user_id', 'length', 'max'=>36),
			array('originator_name, originator_address, originator_city, originator_state_province, originator_postal_code', 'length', 'max'=>35),
			array('originator_identification', 'length', 'max'=>10),
			array('originator_country_code', 'length', 'max'=>2),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('originator_id, originator_datetime, originator_user_id, originator_name, originator_identification, originator_address, originator_city, originator_state_province, originator_postal_code, originator_country_code', 'safe', 'on'=>'search'),
		);


		if ( Yii::app() instanceof CConsoleApplication )
		{
			return $rules;
		}

		// if not an administrator, restrict originator_user_id to own user_id
		// and don't allow it to change
		$currentUser = Yii::app()->user->model();
		if ( $currentUser && ! $currentUser->hasRole('administrator') )
		{
			$message = 'Only an administrator can change ownership.';
			$rules[] = array('originator_user_id', 'compare', 'compareAttribute'=>'originator_user_id', 'on'=>'save', 'message'=>$message);
			$rules[] = array('originator_user_id', 'compare', 'compareValue'=>$currentUser->user_id, 'on'=>'save', 'message'=>$message);
		}

		return $rules;
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'odfi_branches' => array(
					self::HAS_MANY,
					'OdfiBranch',
					'odfi_branch_originator_id'
				),
			'originator_info' => array(
					self::HAS_MANY,
					'OriginatorInfo',
					'originator_info_originator_id'
				),
			'user' => array(
					self::BELONGS_TO,
					'User',
					'originator_user_id'
				),
		);
	}

	public function behaviors(){
		return array(
			'CUuidKeyBehavior' => array(
				'class' => 'application.behaviors.CUuidKeyBehavior',
				'attributeList' => array (
					'originator_id',
				),
			),
			'CEncryptionBehavior' => array(
				'class' => 'application.behaviors.CEncryptionBehavior',
				'attributeList' => array (
					'originator_name'      => 'crypt',
					'originator_identification'	=> 'crypt',
					'originator_address'		=> 'crypt',
				),
			),
 			'CPhoneticDataBehavior' => array(
 				'class' => 'application.behaviors.CPhoneticDataBehavior',
 				'attributeList' => array (
					array( 'attribute'=>'originator_name', 'dataType'=>'company', 'method'=>'soundex' ),
					array( 'attribute'=>'originator_name', 'dataType'=>'company', 'method'=>'nysiis' ),
					array( 'attribute'=>'originator_name', 'dataType'=>'company', 'method'=>'metaphone2' ),
				),
 				'targetModel' => 'PhoneticData',
			),
                        'CActiveLogBehavior' => array(
                                'class' => 'application.behaviors.CActiveLogBehavior',
                                'attributeList' => array (
					'originator_id',
					'originator_user_id',
					'originator_name',
					'originator_identification',
					'originator_address',
					'originator_city',
					'originator_state_province',
					'originator_postal_code',
					'originator_country_code',
				),
			),
			'CValidateOwnershipBehavior' => array(
				'class' => 'application.behaviors.CValidateOwnershipBehavior',
				'modelList' => array (
					'User' => 'originator_user_id',
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
			'originator_id' => 'Originator',
			'originator_datetime' => 'Created',
			'originator_user_id' => 'User',
			'originator_name' => 'Name',
			'originator_identification' => 'Tax ID',
			'originator_address' => 'Address',
			'originator_city' => 'City',
			'originator_state_province' => 'State/Province',
			'originator_postal_code' => 'Postal Code',
			'originator_country_code' => 'Country',
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

		$criteria->compare('originator_id',$this->originator_id,true);
		$criteria->compare('originator_datetime',$this->originator_datetime,true);
		$criteria->compare('originator_user_id',$this->originator_user_id,true);
		$criteria->compare('originator_name',$this->originator_name,true);
		$criteria->compare('originator_identification',$this->originator_identification,true);
		$criteria->compare('originator_address',$this->originator_address,true);
		$criteria->compare('originator_city',$this->originator_city,true);
		$criteria->compare('originator_state_province',$this->originator_state_province,true);
		$criteria->compare('originator_postal_code',$this->originator_postal_code,true);
		$criteria->compare('originator_country_code',$this->originator_country_code,true);
		$dataProvider = new CActiveDataProvider('Originator', array(
			'criteria'=>$criteria,
		));

		$dataProvider->sort->defaultOrder='originator_name ASC';

		return $dataProvider;

	}

	public function freeSearch( $query )
	{
		$keywords = explode( ' ', $query );
		
		$criteria = new OADbCriteria();

		foreach ( $keywords as $keyword )
		{
			$condition = array(
					'originator_name' => $keyword,
					'originator_identification' => $keyword,
				);
			$criteria->addColumnSearchCondition( $condition, 'OR' );
		}

		self::addUserJoin( $criteria );

		$criteria->limit = 20;

		return new CActiveDataProvider( $this, array( 'criteria'=>$criteria) );
	}

	public static function addUserJoin( CDbCriteria $criteria )
	{
		$criteria->join .= ' INNER JOIN "user" ON ( user_id = originator_user_id AND user_id = :logged_in_user_id ) ';
		$criteria->params[ ':logged_in_user_id' ] = Yii::app()->user->model()->user_id;
		User::addUserJoin( $criteria );
	}

	public function getOdfiBranchOptions()
	{
		$options = array();
		foreach ( $this->odfi_branches as $odfiBranch )
		{
			$options[ $odfiBranch->odfi_branch_id ] = $odfiBranch->odfi_branch_friendly_name;
		}
		return $options;
	}

	public function getCountryCodeOptions()
	{
		return Yii::app()->params['Country']['Payment'];
	}

	public function displayAddress()
	{
		$display = '';
		$display .= $this->originator_address ? $this->originator_address . '<br />' : '';
		if ( $this->originator_city && $this->originator_state_province )
		{
			$display .= $this->originator_city . ', ' .
				$this->originator_state_province . ' ' .
				$this->originator_postal_code . ' ' .
				$this->originator_country_code;
		}
		return $display;
	}

	public function displayTotals()
	{
		return '<strong>Outstanding</strong><br />' .
			'<strong class="debits">Deposits: $2,150.00</strong><br />' .
			'<strong class="credits">Withdrawals: ($202.00)</strong>';
	}

}
