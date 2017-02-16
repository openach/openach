<?php

/**
 * This is the model class for table "phonetic_data".
 *
 * The followings are the available columns in table 'phonetic_data':
 * @property string $phonetic_data_id
 * @property string $phonetic_data_datetime
 * @property string $phonetic_data_entity_class
 * @property string $phonetic_data_entity_id
 * @property string $phonetic_data_entity_field
 * @property string $phonetic_data_encoding_method
 * @property string $phonetic_data_key
 * @property string $phonetic_data_type
 */
class PhoneticData extends OADataSource
{
	protected $entityModel;

	/**
	 * Returns the static model of the specified AR class.
	 * @return PhoneticData the static model class
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
		return 'phonetic_data';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('phonetic_data_id, phonetic_data_datetime, phonetic_data_entity_class, phonetic_data_entity_id, phonetic_data_encoding_method, phonetic_data_key, phonetic_data_type', 'required'),
			array('phonetic_data_id, phonetic_data_entity_id', 'length', 'max'=>36),
			array('phonetic_data_entity_class, phonetic_data_entity_field, phonetic_data_type', 'length', 'max'=>50),
			array('phonetic_data_encoding_method', 'length', 'max'=>10),
			array('phonetic_data_key', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('phonetic_data_id, phonetic_data_datetime, phonetic_data_entity_class, phonetic_data_entity_id, phonetic_data_entity_field, phonetic_data_encoding_method, phonetic_data_key', 'safe', 'on'=>'search'),
		);
	}
	public function behaviors()
	{
		return array( 
			'CUuidKeyBehavior' => array(
				'class' => 'application.behaviors.CUuidKeyBehavior',
				'attributeList' => array(
					'phonetic_data_id',
				),
			),
			'CDatetimeBehavior' => array(
				'class' => 'application.behaviors.CDatetimeBehavior',
				'attributeList' => array(
					'phonetic_data_datetime',
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'phonetic_data_id' => 'Phonetic Data',
			'phonetic_data_datetime' => 'Phonetic Data Datetime',
			'phonetic_data_entity_class' => 'Phonetic Data Entity Class',
			'phonetic_data_entity_id' => 'Phonetic Data Entity',
			'phonetic_data_entity_field' => 'Phonetic Data Source Field',
			'phonetic_data_encoding_method' => 'Phonetic Data Encoding Method',
			'phonetic_data_key' => 'Phonetic Data Key',
			'phonetic_data_type' => 'Phonetic Data Type',
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

		$criteria->compare('phonetic_data_id',$this->phonetic_data_id,true);
		$criteria->compare('phonetic_data_datetime',$this->phonetic_data_datetime,true);
		$criteria->compare('phonetic_data_entity_class',$this->phonetic_data_entity_class,true);
		$criteria->compare('phonetic_data_entity_id',$this->phonetic_data_entity_id,true);
		$criteria->compare('phonetic_data_entity_field',$this->phonetic_data_entity_field,true);
		$criteria->compare('phonetic_data_encoding_method',$this->phonetic_data_encoding_method,true);
		$criteria->compare('phonetic_data_key',$this->phonetic_data_key,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function setEntityModel( $entityModel )
	{
		$this->entityModel = $entityModel;
		$this->setEntityClass( get_class( $this->entityModel ) );
		$this->setEntityId( $this->entityModel->getPrimaryKey() );
	}

	public function setEntityClass( $entityClass )
	{
		$this->phonetic_data_entity_class = $entityClass;
	}

	public function setEntityId( $entityId )
	{
		$this->phonetic_data_entity_id = $entityId;
	}

	public function setEntityField( $entityField )
	{
		$this->phonetic_data_entity_field = $entityField;
	}

	public function setMethod( $encodingMethod )
	{
		$this->phonetic_data_encoding_method = $encodingMethod;
	}

	public function setKey( $encodedKey )
	{
		$this->phonetic_data_key = $encodedKey;
	}

	public function setDataType( $dataType )
	{
		$this->phonetic_data_type = $dataType;
	}

	public function deleteForEntity( $entityClass, $entityId )
	{
		$sql = "DELETE FROM " . $this->tableName() . "
			WHERE phonetic_data_entity_class = :phonetic_data_entity_class
			AND phonetic_data_entity_id = :phonetic_data_entity_id";

		$command = Yii::app()->db->createCommand($sql);
		$command->bindValue(':phonetic_data_entity_class', $entityClass, PDO::PARAM_STR);
		$command->bindValue(':phonetic_data_entity_id', $entityId, PDO::PARAM_STR);

		$result = $command->execute();

		if ( ! $result )
		{
			//throw new Exception( 'Unable to delete phonetic data for entity ' . $entityClass . ' with id ' . $entityId );
		}

		return $result;
	}
	
}
