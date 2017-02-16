<?php

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
class User extends CActiveRecord
{

	// Class Constants
	// For DB enums
	const statusENABLED = 'enabled';
	const statusDISABLED = 'disabled';

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
			array('user_password', 'length', 'max'=>32),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'user_id' => 'User',
			'user_login' => 'User Login',
			'user_password' => 'User Password',
			'user_first_name' => 'User First Name',
			'user_last_name' => 'User Last Name',
			'user_email_address' => 'User Email Address',
			'user_security_question_1' => 'User Security Question 1',
			'user_security_question_2' => 'User Security Question 2',
			'user_security_question_3' => 'User Security Question 3',
			'user_security_answer_1' => 'User Security Answer 1',
			'user_security_answer_2' => 'User Security Answer 2',
			'user_security_answer_3' => 'User Security Answer 3',
			'user_status' => 'User Status',
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

		return new CActiveDataProvider('User', array(
			'criteria'=>$criteria,
		));
	}

	public function validatePassword( $password )
	{
		if ( $this->user_password == sha1( $password ) )
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
}
