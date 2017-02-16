<?php

/**
 * This is the model class for table "plugin_config".
 *
 * The followings are the available columns in table 'plugin_config':
 * @property string $plugin_config_id
 * @property string $plugin_config_plugin_id
 * @property string $plugin_config_parent_id
 * @property string $plugin_config_parent_model
 * @property string $plugin_config_key
 * @property string $plugin_config_value
 * @property int $plugin_config_weight
 */
class PluginConfig extends OADataSource
{
	// Set default values
	public $plugin_config_weight = 0;

	/**
	 * Returns the static model of the specified AR class.
	 * @return PluginConfig the static model class
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
		return 'plugin_config';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('plugin_config_plugin_id, plugin_config_parent_model, plugin_config_key', 'required'),
			array('plugin_config_id, plugin_config_plugin_id, plugin_config_parent_id', 'length', 'max'=>36),
			array('plugin_config_parent_model', 'length', 'max'=>50),
			array('plugin_config_key', 'length', 'max'=>255),
			array('plugin_config_value', 'length', 'max'=>2500),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('plugin_config_id, plugin_config_plugin_id, plugin_config_parent_id, plugin_config_parent_model, plugin_config_key, plugin_config_value', 'safe', 'on'=>'search'),
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

	public function behaviors(){
		return array(
			'CUuidKeyBehavior' => array(
				'class' => 'application.behaviors.CUuidKeyBehavior',
				'attributeList' => array (
					'plugin_config_id',
				),
			),
			'CEncryptionBehavior' => array(
				'class' => 'application.behaviors.CEncryptionBehavior',
				'attributeList' => array (
					'plugin_config_value'		 => 'crypt',
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
			'plugin_config_id' => 'Plugin Config',
			'plugin_config_plugin_id' => 'Plugin Config Plugin',
			'plugin_config_parent_id' => 'Plugin Config Parent',
			'plugin_config_parent_model' => 'Plugin Config Parent Model',
			'plugin_config_key' => 'Plugin Config Key',
			'plugin_config_value' => 'Plugin Config Value',
			'plugin_config_weight' => 'Plugin Config Weight',
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

		$criteria->compare('plugin_config_id',$this->plugin_config_id,true);
		$criteria->compare('plugin_config_plugin_id',$this->plugin_config_plugin_id,true);
		$criteria->compare('plugin_config_parent_id',$this->plugin_config_parent_id,true);
		$criteria->compare('plugin_config_parent_model',$this->plugin_config_parent_model,true);
		$criteria->compare('plugin_config_key',$this->plugin_config_key,true);
		$criteria->compare('plugin_config_value',$this->plugin_config_value,true);
		$criteria->compare('plugin_config_weight',$this->plugin_config_weight,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function parentModel()
	{
		$parentClass = $this->plugin_config_parent_model;
		$parentModel = $parentClass::model()->findByPk( $this->plugin_config_parent_id );
		if ( ! $parentModel )
		{
			throw new Exception( 'Unable to load parent for plugin config id ' . $this->plugin_config_id . ' having a parent id of ' . $this->plugin_config_parent_id . ' with class ' . $this->plugin_config_parent_model );
		}
		return $parentModel;
	}
}
