<?php

/**
 * This is the model class for table "ofac_sdn".
 *
 * The followings are the available columns in table 'ofac_sdn':
 * @property integer $ofac_sdn_ent_num
 * @property string $ofac_sdn_name
 * @property string $ofac_sdn_type
 * @property string $ofac_sdn_program
 * @property string $ofac_sdn_title
 * @property string $ofac_sdn_call_sign
 * @property string $ofac_sdn_vess_type
 * @property string $ofac_sdn_tonnage
 * @property string $ofac_sdn_grt
 * @property string $ofac_sdn_vess_flag
 * @property string $ofac_sdn_vess_owner
 * @property string $ofac_sdn_remarks
 */
class OfacSdn extends OADataSource
{
	// Properties for meta-data columns and hashing
	public $ofac_sdn_name_last;
	public $ofac_sdn_name_first;
	public $ofac_sdn_name_company;

	/**
	 * Returns the static model of the specified AR class.
	 * @return OfacSdn the static model class
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
		return 'ofac_sdn';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ofac_sdn_ent_num', 'required' ),
			array('ofac_sdn_ent_num', 'numerical', 'integerOnly'=>true),
			array('ofac_sdn_name', 'length', 'max'=>350),
			array('ofac_sdn_type', 'length', 'max'=>12),
			array('ofac_sdn_program', 'length', 'max'=>50),
			array('ofac_sdn_title', 'length', 'max'=>200),
			array('ofac_sdn_call_sign, ofac_sdn_grt', 'length', 'max'=>8),
			array('ofac_sdn_vess_type', 'length', 'max'=>25),
			array('ofac_sdn_tonnage', 'length', 'max'=>14),
			array('ofac_sdn_vess_flag', 'length', 'max'=>40),
			array('ofac_sdn_vess_owner', 'length', 'max'=>150),
			array('ofac_sdn_remarks', 'length', 'max'=>1000),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('ofac_sdn_ent_num, ofac_sdn_name, ofac_sdn_type, ofac_sdn_program, ofac_sdn_title, ofac_sdn_call_sign, ofac_sdn_vess_type, ofac_sdn_tonnage, ofac_sdn_grt, ofac_sdn_vess_flag, ofac_sdn_vess_owner, ofac_sdn_remarks', 'safe', 'on'=>'search'),
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
			'ofac_sdn_ent_num' => 'Ofac Sdn Ent Num',
			'ofac_sdn_name' => 'Ofac Sdn Name',
			'ofac_sdn_type' => 'Ofac Sdn Type',
			'ofac_sdn_program' => 'Ofac Sdn Program',
			'ofac_sdn_title' => 'Ofac Sdn Title',
			'ofac_sdn_call_sign' => 'Ofac Sdn Call Sign',
			'ofac_sdn_vess_type' => 'Ofac Sdn Vess Type',
			'ofac_sdn_tonnage' => 'Ofac Sdn Tonnage',
			'ofac_sdn_grt' => 'Ofac Sdn Grt',
			'ofac_sdn_vess_flag' => 'Ofac Sdn Vess Flag',
			'ofac_sdn_vess_owner' => 'Ofac Sdn Vess Owner',
			'ofac_sdn_remarks' => 'Ofac Sdn Remarks',
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

		$criteria->compare('ofac_sdn_ent_num',$this->ofac_sdn_ent_num);
		$criteria->compare('ofac_sdn_name',$this->ofac_sdn_name,true);
		$criteria->compare('ofac_sdn_type',$this->ofac_sdn_type,true);
		$criteria->compare('ofac_sdn_program',$this->ofac_sdn_program,true);
		$criteria->compare('ofac_sdn_title',$this->ofac_sdn_title,true);
		$criteria->compare('ofac_sdn_call_sign',$this->ofac_sdn_call_sign,true);
		$criteria->compare('ofac_sdn_vess_type',$this->ofac_sdn_vess_type,true);
		$criteria->compare('ofac_sdn_tonnage',$this->ofac_sdn_tonnage,true);
		$criteria->compare('ofac_sdn_grt',$this->ofac_sdn_grt,true);
		$criteria->compare('ofac_sdn_vess_flag',$this->ofac_sdn_vess_flag,true);
		$criteria->compare('ofac_sdn_vess_owner',$this->ofac_sdn_vess_owner,true);
		$criteria->compare('ofac_sdn_remarks',$this->ofac_sdn_remarks,true);

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
						'attribute'=>'ofac_sdn_name',
				       		'delimiter'=>',',
				       		'targets'=>array('ofac_sdn_name_last','ofac_sdn_name_first'),
				       		'isEqual'=>array('ofac_sdn_type','individual'),
					),
					array( 
						'attribute'=>'ofac_sdn_name',
						'delimiter'=>',',
						'targets'=>array('ofac_sdn_name_company'),
						'isEqual'=>array('ofac_sdn_type',''),
					),
				),
			),
			'CPhoneticDataBehavior' => array(
				'class' => 'application.behaviors.CPhoneticDataBehavior',
				'attributeList' => array (
					array( 'attribute'=>'ofac_sdn_name_last', 'dataType'=>'last_name', 'method'=>'soundex' ),
					array( 'attribute'=>'ofac_sdn_name_last', 'dataType'=>'last_name', 'method'=>'nysiis' ),
					array( 'attribute'=>'ofac_sdn_name_last', 'dataType'=>'last_name', 'method'=>'metaphone2' ),
					array( 'attribute'=>'ofac_sdn_name_first', 'dataType'=>'first_name', 'method'=>'soundex' ),
					array( 'attribute'=>'ofac_sdn_name_first', 'dataType'=>'first_name', 'method'=>'nysiis' ),
					array( 'attribute'=>'ofac_sdn_name_first', 'dataType'=>'first_name', 'method'=>'metaphone2' ),
					array( 'attribute'=>'ofac_sdn_name_company', 'dataType'=>'company', 'method'=>'soundex' ),
					array( 'attribute'=>'ofac_sdn_name_company', 'dataType'=>'company', 'method'=>'nysiis' ),
					array( 'attribute'=>'ofac_sdn_name_company', 'dataType'=>'company', 'method'=>'metaphone2' ),
				),
				'targetModel' => 'PhoneticData',
			)
		);
	}

}
