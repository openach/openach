<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

/**
 * This is the model class for active logging with the CLogBehavior class
 *
 */
class OAActiveLog extends OADataSource
{

	// Our table name is dynamic, use setTableName() to change
	private $tableName = 'app_log';

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
		// We have a dynamic table name
		return $this->tableName;
	}

	public function setTableFromModel( CActiveRecord $model )
	{
		$this->setTableName( $model->tableName() . '_log' );
	}

	public function setTableName( $tableName )
	{
		// Detatch the current behaviors
		$this->detachBehaviors();
		// The naming convention for the log tables is {model_table_name}_log
		$this->tableName = $tableName;
		// Reload the schema for the new table name
		$this->refreshMetaData();
		// Reattach the new behaviors
		$this->attachBehaviors( $this->behaviors() );
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// We trust that the fields are all what they should be
		// as they will all come from a validated data source
		return array();
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array();
	}


	public function behaviors(){
		return array(
			'CDatetimeBehavior' => array(
				'class' => 'application.behaviors.CDatetimeBehavior',
				'attributeList' => array(
					'log_datetime',
				),
			),
			'CRemoteIpBehavior' => array(
				'class' => 'application.behaviors.CRemoteIpBehavior',
				'attributeList' => array(
					'log_remote_ip',
				),
			),
			'CLoggedInUserBehavior' => array(
				'class' => 'application.behaviors.CLoggedInUserBehavior',
				'attributeList' => array(
					'log_user_id',
				),
			),
		);
	}

}
