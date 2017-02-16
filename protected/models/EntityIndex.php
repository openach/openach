<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

/**
 * This is the model class for table "entity_index".
 *
 * The followings are the available columns in table 'role':
 * @property string $entity_index_id
 * @property string $entity_index_next_id
 */
class EntityIndex extends OADataSource
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Role the static model class
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
		return 'entity_index';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('entity_index_id, entity_index_next_id', 'required'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'entity_index_id' => 'Index Identifier',
			'entity_index_next_id' => 'Next Index ID',
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

		$criteria->compare('entity_index_id',$this->entity_index_id,true);

		$criteria->compare('entity_index_next_id',$this->entity_index_next_id,true);

		return new CActiveDataProvider('Role', array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Retrieves the next ID for the entity, and increments the next ID
	 */
	static public function getNextId( $entityIndexId )
	{
		//$dbTrans = Yii::app()->db->beginTransaction();
		$updateNextIdSql = 'UPDATE entity_index SET entity_index_next_id = :entity_index_next_id WHERE entity_index_id = :entity_index_id';
		try
		{
			$entityIndex = EntityIndex::model()->find( 'entity_index_id=:entity_index_id', array( ':entity_index_id' => $entityIndexId ) );

			// If there's no existing index, initialize one 
			if ( ! $entityIndex )
			{
				$entityIndex = new EntityIndex();
				$entityIndex->entity_index_id = $entityIndexId;
				$entityIndex->entity_index_next_id = 0;
			}

			$entityIndex->entity_index_next_id++;

			if ( ! $entityIndex->save() )
			{
				throw new CDbException( 'Unable to update entity index.' );
			}

			//$dbTrans->commit();
		}
		catch(Exception $e) // an exception is raised if a query fails
		{
			//$dbTrans->rollBack();
			throw $e;
		}

		return $entityIndex->entity_index_next_id;
	}

}
