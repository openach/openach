<?php

/**
 * This is the model class for table "file_transfer".
 *
 * The followings are the available columns in table 'file_transfer':
 * @property string $file_transfer_id
 * @property string $file_transfer_datetime
 * @property string $file_transfer_file_id
 * @property string $file_transfer_model
 * @property string $file_transfer_status
 * @property string $file_transfer_plugin
 * @property string $file_transfer_message
 * @property string $file_transfer_data
 */
class FileTransfer extends OADataSource
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return FileTransfer the static model class
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
		return 'file_transfer';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('file_transfer_id, file_transfer_datetime, file_transfer_file_id, file_transfer_model, file_transfer_plugin', 'required'),
			array('file_transfer_id, file_transfer_file_id, file_transfer_plugin', 'length', 'max'=>36),
			array('file_transfer_model', 'length', 'max'=>50),
			array('file_transfer_status', 'length', 'max'=>11),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('file_transfer_id, file_transfer_datetime, file_transfer_file_id, file_transfer_model, file_transfer_status, file_transfer_plugin', 'safe', 'on'=>'search'),
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
			'ach_file' => array(
					self::BELONGS_TO,
					'AchFile',
					'file_transfer_file_id',
				),
			'ach_file_conf' => array(
					self::BELONGS_TO,
					'AchFileConf',
					'file_transfer_file_id',
				),
		);
	}

	public function behaviors()
	{
		return array(
			'CUuidKeyBehavior' => array(
				'class' => 'application.behaviors.CUuidKeyBehavior',
				'attributeList' => array (
					'file_transfer_id',
				),
			),
			'CDatetimeBehavior' => array(
				'class' => 'application.behaviors.CDatetimeBehavior',
				'attributeList' => array(
					'file_transfer_datetime',
				),
			),
			'CCompressedEncryptionBehavior' => array(
				'class' => 'application.behaviors.CCompressedEncryptionBehavior',
				'attributeList' => array (
					'file_transfer_data' => 'crypt',
				),
			),
                        'CActiveLogBehavior' => array(
                                'class' => 'application.behaviors.CActiveLogBehavior',
                                'attributeList' => array (
					'file_transfer_id',
					'file_transfer_status',
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
			'file_transfer_id' => 'File Transfer',
			'file_transfer_datetime' => 'Datetime',
			'file_transfer_file_id' => 'File',
			'file_transfer_model' => 'File Model',
			'file_transfer_status' => 'Status',
			'file_transfer_plugin' => 'Plugin',
			'file_transfer_message' => 'Message',
			'file_transfer_data' => 'Data',
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

		$criteria->compare('file_transfer_id',$this->file_transfer_id,true);
		$criteria->compare('file_transfer_datetime',$this->file_transfer_datetime,true);
		$criteria->compare('file_transfer_file_id',$this->file_transfer_file_id,true);
		$criteria->compare('file_transfer_model',$this->file_transfer_model,true);
		$criteria->compare('file_transfer_status',$this->file_transfer_status,true);
		$criteria->compare('file_transfer_plugin',$this->file_transfer_plugin,true);
		$criteria->compare('file_transfer_message',$this->file_transfer_message,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function displayStatus()
	{
		return 'Status: ' . ucfirst( $this->file_transfer_status );
	}

	public function displayDate()
	{
		return $this->formatDate( $this->file_transfer_datetime );
	}

	public function displayMessage()
	{
		return $this->file_transfer_message ? $this->file_transfer_message : '<em>no message</em>';
	}

	public function displayPlugin()
	{
		return 'Using Plugin: ' . $this->file_transfer_plugin;
	}

	static public function createNewTransfer( OADataSource $fileModel, OABankConfig $bankConfig,  OATransferAgent $transferAgent, $fileData )
	{
		$fileTransfer = new FileTransfer();
		$fileTransfer->file_transfer_file_id = $fileModel->getPrimaryKey();
		$fileTransfer->file_transfer_model = get_class( $fileModel );
		$fileTransfer->file_transfer_status = $transferAgent->getTransferStatus();
		$fileTransfer->file_transfer_plugin = get_class( $bankConfig );
		$fileTransfer->file_transfer_message = $transferAgent->getTransferMessage();
		$fileTransfer->file_transfer_data = $fileData;
		return $fileTransfer;
	}
}
