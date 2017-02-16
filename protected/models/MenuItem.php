<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

/**
 * This is the model class for table "menu_item".
 *
 * The followings are the available columns in table 'menu_item':
 * @property string $menu_item_id
 * @property string $menu_item_component
 * @property string $menu_item_group
 * @property string $menu_item_parent_id
 * @property string $menu_item_path
 * @property string $menu_item_class
 * @property string $menu_item_icon
 * @property string $menu_item_label
 * @property string $menu_item_text
 * @property integer $menu_item_weight
 */
class MenuItem extends OADataSource
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return MenuItem the static model class
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
		return 'menu_item';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('menu_item_id, menu_item_component, menu_item_group, menu_item_label', 'required'),
			array('menu_item_weight', 'numerical', 'integerOnly'=>true),
			array('menu_item_id, menu_item_parent_id', 'length', 'max'=>36),
			array('menu_item_component, menu_item_group, menu_item_path, menu_item_class', 'length', 'max'=>50),
			array('menu_item_label, menu_item_icon', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('menu_item_id, menu_item_component, menu_item_group, menu_item_parent_id, menu_item_path, menu_item_class, menu_item_icon, menu_item_label, menu_item_text, menu_item_weight', 'safe', 'on'=>'search'),
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
			'parent' => array(
					self::BELONGS_TO,
					'MenuItem',
					'menu_item_parent_id'
				),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'menu_item_id' => 'Menu Item',
			'menu_item_component' => 'Menu Item Component',
			'menu_item_group' => 'Menu Item Group',
			'menu_item_parent_id' => 'Menu Item Parent',
			'menu_item_path' => 'Menu Item Path',
			'menu_item_class' => 'Menu Item Class',
			'menu_item_icon' => 'Menu Item Icon',
			'menu_item_label' => 'Menu Item Label',
			'menu_item_text' => 'Menu Item Text',
			'menu_item_weight' => 'Menu Item Weight',
			'menu_item_require_role' => 'Menu Item Requires Role',
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

		$criteria->compare('menu_item_id',$this->menu_item_id,true);
		$criteria->compare('menu_item_component',$this->menu_item_component,true);
		$criteria->compare('menu_item_group',$this->menu_item_group,true);
		$criteria->compare('menu_item_parent_id',$this->menu_item_parent_id,true);
		$criteria->compare('menu_item_path',$this->menu_item_path,true);
		$criteria->compare('menu_item_class',$this->menu_item_class,true);
		$criteria->compare('menu_item_icon',$this->menu_item_icon,true);
		$criteria->compare('menu_item_label',$this->menu_item_label,true);
		$criteria->compare('menu_item_text',$this->menu_item_text,true);
		$criteria->compare('menu_item_weight',$this->menu_item_weight);
		$criteria->compare('menu_item_require_role',$this->menu_item_require_role);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Retrieves all active records using the given component name
	 * @return CActiveRecord the 
	 */
	public function findByComponent( $componentName )
	{
		return self::model()->findAllByAttributes( array( 'menu_item_component' => $componentName ), array( 'order' => 'menu_item_group, menu_item_weight' ) );
	}
}
