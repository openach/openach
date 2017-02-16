<?php

/**
 * This is the model class for table "ofac_alt".
 *
 * The followings are the available columns in table 'ofac_alt':
 * @property integer $ofac_alt_ent_num
 * @property integer $ofac_alt_num
 * @property string $ofac_alt_type
 * @property string $ofac_alt_name
 * @property string $ofac_alt_remarks
 */
class OfacAlt extends OADataSource
{
	// Properties for meta-data columns and hashing
	public $ofac_alt_name_last;
	public $ofac_alt_name_first;
	
	/**
	 * Returns the static model of the specified AR class.
	 * @return OfacAlt the static model class
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
		return 'ofac_alt';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ofac_alt_ent_num, ofac_alt_num', 'required' ),
			array('ofac_alt_ent_num, ofac_alt_num', 'numerical', 'integerOnly'=>true),
			array('ofac_alt_type', 'length', 'max'=>8),
			array('ofac_alt_name', 'length', 'max'=>350),
			array('ofac_alt_remarks', 'length', 'max'=>200),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('ofac_alt_ent_num, ofac_alt_num, ofac_alt_type, ofac_alt_name, ofac_alt_remarks', 'safe', 'on'=>'search'),
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
			'ofac_alt_ent_num' => 'Ofac Alt Ent Num',
			'ofac_alt_num' => 'Ofac Alt Num',
			'ofac_alt_type' => 'Ofac Alt Type',
			'ofac_alt_name' => 'Ofac Alt Name',
			'ofac_alt_remarks' => 'Ofac Alt Remarks',
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

		$criteria->compare('ofac_alt_ent_num',$this->ofac_alt_ent_num);
		$criteria->compare('ofac_alt_num',$this->ofac_alt_num);
		$criteria->compare('ofac_alt_type',$this->ofac_alt_type,true);
		$criteria->compare('ofac_alt_name',$this->ofac_alt_name,true);
		$criteria->compare('ofac_alt_remarks',$this->ofac_alt_remarks,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function behaviors()
	{
		return array(
			'CTokenizerBehavior' => array(
				'class' => 'application.behaviors.CTokenizerBehavior',
				'attributeList' => array (
					array(
						'attribute'=>'ofac_alt_name',
						'delimiter'=>',',
						'targets'=>array('ofac_alt_name_last','ofac_alt_name_first'),
					),
				),
			),
			'CPhoneticDataBehavior' => array(
				'class' => 'application.behaviors.CPhoneticDataBehavior',
				'attributeList' => array (
					array( 'attribute'=>'ofac_alt_name_last', 'dataType'=>'last_name', 'method'=>'soundex' ),
					array( 'attribute'=>'ofac_alt_name_last', 'dataType'=>'last_name', 'method'=>'nysiis' ),
					array( 'attribute'=>'ofac_alt_name_last', 'dataType'=>'last_name', 'method'=>'metaphone2' ),
					array( 'attribute'=>'ofac_alt_name_first', 'dataType'=>'first_name', 'method'=>'soundex' ),
					array( 'attribute'=>'ofac_alt_name_first', 'dataType'=>'first_name', 'method'=>'nysiis' ),
					array( 'attribute'=>'ofac_alt_name_first', 'dataType'=>'first_name', 'method'=>'metaphone2' ),
					array( 'attribute'=>'ofac_alt_name', 'dataType'=>'company', 'method'=>'soundex' ),
					array( 'attribute'=>'ofac_alt_name', 'dataType'=>'company', 'method'=>'nysiis' ),
					array( 'attribute'=>'ofac_alt_name', 'dataType'=>'company', 'method'=>'metaphone2' ),
				),
				'targetModel' => 'PhoneticData',
			)
		);
	}
}
