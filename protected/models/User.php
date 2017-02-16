<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

/**
 * This is the model class for table "user".
 *
 * The followings are the available columns in table 'user':
 * @property string $user_id
 * @property string $user_login
 * @property string $user_password
 * @property string $user_first_name
 * @property string $user_last_name
 * @property string $user_email_address
 * @property string $user_security_question_1
 * @property string $user_security_question_2
 * @property string $user_security_question_3
 * @property string $user_security_answer_1
 * @property string $user_security_answer_2
 * @property string $user_security_answer_3
 * @property string $user_status
 */
class User extends OADataSource
{

	// Class Constants
	// For DB enums
	const statusENABLED = 'enabled';
	const statusDISABLED = 'disabled';

	// For input validation
	public $user_password_confirm;
	public $user_password_current;

	/**
	 * Returns the static model of the specified AR class.
	 * @return User the static model class
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
		return 'user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, user_login, user_password, user_email_address', 'required'),
			array('user_id', 'length', 'max'=>36),
			array('user_login, user_first_name, user_last_name', 'length', 'max'=>50),
			array('user_email_address, user_security_question_1, user_security_question_2, user_security_question_3, user_security_answer_1, user_security_answer_2, user_security_answer_3', 'length', 'max'=>255),
			array('user_status', 'length', 'max'=>9),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('user_id, user_login, user_password, user_first_name, user_last_name, user_email_address, user_security_question_1, user_security_question_2, user_security_question_3, user_security_answer_1, user_security_answer_2, user_security_answer_3, user_status', 'safe', 'on'=>'search'),
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
			'roles' => array(
					self::MANY_MANY,
					'Role',
					'user_role(user_role_user_id,user_role_role_id)'
				),
			'user_api' => array(
					self::HAS_MANY,
					'UserApi',
					'user_api_user_id'
				),
			'user_history' => array(
					self::HAS_MANY,
					'UserHistory',
					'user_history_user_id'
				),
			'originators' => array(
					self::HAS_MANY,
					'Originator',
					'originator_user_id'
				),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'user_id' => 'User',
			'user_login' => 'Login',
			'user_password' => 'Password',
			'user_first_name' => 'First Name',
			'user_last_name' => 'Last Name',
			'user_email_address' => 'Email',
			'user_security_question_1' => 'Security Question 1',
			'user_security_question_2' => 'Security Question 2',
			'user_security_question_3' => 'Security Question 3',
			'user_security_answer_1' => 'Security Answer 1',
			'user_security_answer_2' => 'Security Answer 2',
			'user_security_answer_3' => 'Security Answer 3',
			'user_status' => 'Status',
		);
	}


	public function behaviors(){
		return array(
			'CEncryptionBehavior' => array(
				'class' => 'application.behaviors.CEncryptionBehavior',
				'attributeList' => array (
					'user_security_question_1'	=> 'crypt',
					'user_security_question_2'	=> 'crypt',
					'user_security_question_3'	=> 'crypt',
					'user_security_answer_1'	=> 'crypt',
					'user_security_answer_2'	=> 'crypt',
					'user_security_answer_3'	=> 'crypt',
				),
			),
			'CPasswordBehavior' => array(
				'class' => 'application.behaviors.CPasswordBehavior',
				'passwordAttribute' => 'user_password',
				'confirmAttribute' => 'user_password_confirm',
				'currentAttribute' => 'user_password_current',
			),
			'CUuidKeyBehavior' => array(
				'class' => 'application.behaviors.CUuidKeyBehavior',
				'attributeList' => array (
					'user_id',
				),
			),
			'CActiveLogBehavior' => array(
				'class' => 'application.behaviors.CActiveLogBehavior',
				'attributeList' => array (
					'user_id',
					'user_login',
					'user_first_name',
					'user_last_name',
					'user_email_address',
					'user_status',
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

		$criteria->compare('user_id',$this->user_id,true);

		$criteria->compare('user_login',$this->user_login,true);

		$criteria->compare('user_password',$this->user_password,true);

		$criteria->compare('user_first_name',$this->user_first_name,true);

		$criteria->compare('user_last_name',$this->user_last_name,true);

		$criteria->compare('user_email_address',$this->user_email_address,true);

		$criteria->compare('user_security_question_1',$this->user_security_question_1,true);

		$criteria->compare('user_security_question_2',$this->user_security_question_2,true);

		$criteria->compare('user_security_question_3',$this->user_security_question_3,true);

		$criteria->compare('user_security_answer_1',$this->user_security_answer_1,true);

		$criteria->compare('user_security_answer_2',$this->user_security_answer_2,true);

		$criteria->compare('user_security_answer_3',$this->user_security_answer_3,true);

		$criteria->compare('user_status',$this->user_status,true);

		$dataProvider = new CActiveDataProvider('User', array(
			'criteria'=>$criteria,
		));

		$dataProvider->sort->defaultOrder='user_login ASC';

		return $dataProvider;
	}

	public function validatePassword( $password )
	{
		$securityManager = Yii::app()->securityManager;
		if ( $this->user_password_current == sha1( $password ) )
		{
			return true;
		}
		if ( $this->user_password_current == hash_hmac( $securityManager->hashAlgorithm, $password, $securityManager->getValidationKey() ) )
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	public function isDisabled()
	{
		if ( $this->user_status == self::statusDISABLED )
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	public function hasRole( $roleName )
	{
		$role = Role::model()->findByName( $roleName );
		if ( $role && $role->isAssignedToUser( $this->user_id ) )
		{
			return true;
		}
	}

	public function grantRole( $roleName )
	{
		if ( ! $this->user_id || $this->hasRole( $roleName ) )
		{
			return;
		}

		if ( ! $role = Role::model()->findByName( $roleName ) )
		{
			throw new Exception( 'The role "' . $roleName . '" does not exist.' );
		}

		$userRole = UserRole::model();
		$userRole->user_role_user_id = $this->user_id;
		$userRole->user_role_role_id = $role->role_id;
		if ( ! $userRole->save() )
		{
			throw new Exception( 'Unable to save user role "' . $roleName . '" for user id ' . $this->user_id );
		}
	}

	public function revokeRole( $roleName )
	{
		if ( ! $this->user_id || $this->hasRole( $roleName ) )
		{
			return;
		}

		if ( ! $role = Role::model()->findByName( $roleName ) )
		{
			throw new Exception( 'The role "' . $roleName . '" does not exist.' );
		}

		$criteria = new CDbCriteria();	
		$criteria->addCondition( 'user_role_user_id = :user_id' );
		$criteria->addCondition( 'user_role_role_id = :role_id' );
		$criteria->params = array( ':user_id' => $this->user_id, ':role_id' => $role->role_id );		
		if ( $userRole = UserRole::model()->find( $criteria ) )
		{
			if ( ! $userRole->delete() )
			{
				throw new Exception( 'Unable to revoke role "' . $roleName . '" from user ' . $this->user_id );
			}
		}
		// Else, silently continue, as the role is no longer there
	}

	public function getUrl()
	{
		return Yii::app()->createUrl( 'user/view', array( 'id' => $this->getPrimaryKey() ) );
	}

	public function getOriginatorOptions()
	{
		$options = array();
		foreach ( $this->originators as $originator )
		{
			$options[ $originator->originator_id ] = $originator->originator_name;
		}
		return $options;
	}

	public function hasIatRole()
	{
		foreach ( $this->roles as $role )
		{
			if ( $role->role_iat_enabled )
			{
				return true;
			}
		}

		return false;
	}

	public function displayName()
	{
		return $this->user_first_name . ' ' . $this->user_last_name;
	}

	public function addRoleJoin( CDbCriteria $criteria )
	{
		$criteria->join .= ' INNER JOIN user_role ON ( user_role_user_id = :user_role_user_id AND user_role_role_id = role_id ) ';
		$criteria->params[ ':user_role_user_id' ] = $this->user_id;
	}

	public function addOriginatorJoin( CDbCriteria $criteria )
	{
		$criteria->join .= ' INNER JOIN originator ON ( originator_user_id = :originator_user_id ) ';
		$criteria->params[ ':originator_user_id' ] = $this->user_id;
	}

	public static function addUserJoin( CDbCriteria $criteria )
	{
		// Do nothing at this level...
	}

	public function isAuthorized( $object )
	{

		// Admin role always is authorized
		if ( $this->hasRole( 'administrator' ) )
		{
			return true;
		}

		if ( $object instanceof User )
		{
			if ( $object->user_id == $this->user_id )
			{
				return true;
			}
		}
		elseif ( $object instanceof Originator )
		{
			if ( $object->originator_user_id == $this->user_id )
			{
				return true;
			}
		}
		elseif ( $object instanceof OriginatorInfo )
		{
			return $this->isAuthorized( $object->originator );
		}
		elseif ( $object instanceof FileTransfer )
		{
			return $this->isAuthorized( $object->ach_file->originator );
		}
		elseif ( $object instanceof AchFile )
		{
			return $this->isAuthorized( $object->originator );
		}
		elseif ( $object instanceof AchBatch )
		{
			if ( $object->originator_info )
			{
				return $this->isAuthorized( $object->originator_info );
			}
			elseif ( $object->ach_file->originator )
			{
				return $this->isAuthorized( $object->ach_file->originator );
			}
		}
		elseif ( $object instanceof AchEntry )
		{
			if ( $object->odfi_branch )
			{
				return $this->isAuthorized( $object->odfi_branch );
			}
			elseif ( $object->external_account )
			{
				return $this->isAuthorized( $object->external_account );
			}
		}
		elseif ( $object instanceof PaymentProfile )
		{
			return $this->isAuthorized( $object->originator_info->originator );
		}
		elseif ( $object instanceof PaymentSchedule )
		{
			return $this->isAuthorized( $object->payment_type->originator_info->originator );
		}
		elseif ( $object instanceof PaymentType )
		{
			return $this->isAuthorized( $object->originator_info->originator );
		}
		elseif ( $object instanceof ExternalAccount )
		{
			if ( $object->payment_profile )
			{
				return $this->isAuthorized( $object->payment_profile->originator_info->originator );
			}
			elseif ( $object->originator_info )
			{
				return $this->isAuthorized( $object->originator_info->originator );
			}
		}
		elseif ( $object instanceof OdfiBranch )
		{
			return $this->isAuthorized( $object->originator );
		}
		elseif ( $object instanceof PluginConfig )
		{
			if ( $object->plugin_config_parent_model == 'OdfiBranch' )
			{
				$odfiBranch = OdfiBranch::model()->findByPk( $object->plugin_config_parent_id );
				return $this->isAuthorized( $odfiBranch->originator );
			}
		}
		elseif ( $object instanceof Settlement )
		{
			return $this->isAuthorized( $object->originator_info->originator );
		}
		elseif ( $object instanceof UserHistory )
		{
			if ( $object->user_history_user_id == $this->user_id )
			{
				return true;
			}
		}

		return false;
	}



}
