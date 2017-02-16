<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

/**
 * OADbAuthManager represents an authorization manager that stores authorization information in database.
 */
class OADbAuthManager extends CDbAuthManager
{
	/**
	 * @var string the name of the table storing authorization items. Defaults to 'AuthItem'.
	 */
	public $itemTable='auth_item';
	/**
	 * @var string the name of the table storing authorization item hierarchy. Defaults to 'AuthItemChild'.
	 */
	public $itemChildTable='auth_item_tree';
	/**
	 * @var string the name of the table storing authorization item assignments. Defaults to 'AuthAssignment'.
	 */
	public $assignmentTable='auth_assignment';

	/**
	 * Performs access check for the specified user.
	 * This method is internally called by {@link checkAccess}.
	 * @param string $itemName the name of the operation that need access check
	 * @param mixed $userId the user ID. This should can be either an integer and a string representing
	 * the unique identifier of a user. See {@link IWebUser::getId}.
	 * @param array $params name-value pairs that would be passed to biz rules associated
	 * with the tasks and roles assigned to the user.
	 * @param array $assignments the assignments to the specified user
	 * @return boolean whether the operations can be performed by the user.
	 * @since 1.1.3
	 */
	protected function checkAccessRecursive($itemName,$userId,$params,$assignments)
	{
		if(($item=$this->getAuthItem($itemName))===null)
			return false;
		Yii::trace('Checking permission "'.$item->getName().'"','OADbAuthManager');
		if($this->executeBizRule($item->getBizRule(),$params,$item->getData()))
		{
			if(in_array($itemName,$this->defaultRoles))
				return true;
			if(isset($assignments[$itemName]))
			{
				$assignment=$assignments[$itemName];
				if($this->executeBizRule($assignment->getBizRule(),$params,$assignment->getData()))
					return true;
			}
			$parents=$this->db->createCommand()
				->select('auth_item_tree_parent')
				->from($this->itemChildTable)
				->where('auth_item_tree_child=:name', array(':name'=>$itemName))
				->queryColumn();
			foreach($parents as $parent)
			{
				if($this->checkAccessRecursive($parent,$userId,$params,$assignments))
					return true;
			}
		}
		return false;
	}

	/**
	 * Adds an item as a child of another item.
	 * @param string $itemName the parent item name
	 * @param string $childName the child item name
	 * @throws CException if either parent or child doesn't exist or if a loop has been detected.
	 */
	public function addItemChild($itemName,$childName)
	{
		if($itemName===$childName)
			throw new CException(Yii::t('yii','Cannot add "{name}" as a child of itself.',
					array('{name}'=>$itemName)));

		$rows=$this->db->createCommand()
			->select()
			->from($this->itemTable)
			->where('auth_item_name=:name1 OR auth_item_name=:name2', array(
				':name1'=>$itemName,
				':name2'=>$childName
			))
			->queryAll();

		if(count($rows)==2)
		{
			if($rows[0]['auth_item_name']===$itemName)
			{
				$parentType=$rows[0]['auth_item_type'];
				$childType=$rows[1]['auth_item_type'];
			}
			else
			{
				$childType=$rows[0]['auth_item_type'];
				$parentType=$rows[1]['auth_item_type'];
			}
			$this->checkItemChildType($parentType,$childType);
			if($this->detectLoop($itemName,$childName))
				throw new CException(Yii::t('yii','Cannot add "{child}" as a child of "{name}". A loop has been detected.',
					array('{child}'=>$childName,'{name}'=>$itemName)));

			$this->db->createCommand()
				->insert($this->itemChildTable, array(
					'auth_item_tree_parent'=>$itemName,
					'auth_item_tree_child'=>$childName,
				));
		}
		else
			throw new CException(Yii::t('yii','Either "{parent}" or "{child}" does not exist.',array('{child}'=>$childName,'{parent}'=>$itemName)));
	}

	/**
	 * Removes a child from its parent.
	 * Note, the child item is not deleted. Only the parent-child relationship is removed.
	 * @param string $itemName the parent item name
	 * @param string $childName the child item name
	 * @return boolean whether the removal is successful
	 */
	public function removeItemChild($itemName,$childName)
	{
		return $this->db->createCommand()
			->delete($this->itemChildTable, 'auth_item_tree_parent=:parent AND auth_item_tree_child=:child', array(
				':parent'=>$itemName,
				':child'=>$childName
			)) > 0;
	}

	/**
	 * Returns a value indicating whether a child exists within a parent.
	 * @param string $itemName the parent item name
	 * @param string $childName the child item name
	 * @return boolean whether the child exists
	 */
	public function hasItemChild($itemName,$childName)
	{
		return $this->db->createCommand()
			->select('auth_item_tree_parent')
			->from($this->itemChildTable)
			->where('auth_item_tree_parent=:parent AND auth_item_tree_child=:child', array(
				':parent'=>$itemName,
				':child'=>$childName))
			->queryScalar() !== false;
	}

	/**
	 * Returns the children of the specified item.
	 * @param mixed $names the parent item name. This can be either a string or an array.
	 * The latter represents a list of item names (available since version 1.0.5).
	 * @return array all child items of the parent
	 */
	public function getItemChildren($names)
	{
		if(is_string($names))
			$condition='auth_item_tree_parent='.$this->db->quoteValue($names);
		else if(is_array($names) && $names!==array())
		{
			foreach($names as &$name)
				$name=$this->db->quoteValue($name);
			$condition='auth_item_tree_parent IN ('.implode(', ',$names).')';
		}

		$rows=$this->db->createCommand()
			->select('auth_item_name, auth_item_type, auth_item_description, auth_item_bizrule, auth_item_data')
			->from(array(
				$this->itemTable,
				$this->itemChildTable
			))
			->where($condition.' AND auth_item_name=auth_item_tree_child')
			->queryAll();

		$children=array();
		foreach($rows as $row)
		{
			if(($data=@unserialize($row['auth_item_data']))===false)
				$data=null;
			$children[$row['auth_item_name']]=new CAuthItem($this,$row['auth_item_name'],$row['auth_item_type'],$row['auth_item_description'],$row['auth_item_bizrule'],$data);
		}
		return $children;
	}

	/**
	 * Assigns an authorization item to a user.
	 * @param string $itemName the item name
	 * @param mixed $userId the user ID (see {@link IWebUser::getId})
	 * @param string $bizRule the business rule to be executed when {@link checkAccess} is called
	 * for this particular authorization item.
	 * @param mixed $data additional data associated with this assignment
	 * @return CAuthAssignment the authorization assignment information.
	 * @throws CException if the item does not exist or if the item has already been assigned to the user
	 */
	public function assign($itemName,$userId,$bizRule=null,$data=null)
	{
		if($this->usingSqlite() && $this->getAuthItem($itemName)===null)
			throw new CException(Yii::t('yii','The item "{name}" does not exist.',array('{name}'=>$itemName)));

		$this->db->createCommand()
			->insert($this->assignmentTable, array(
				'auth_assignment_itemname'=>$itemName,
				'auth_assignment_userid'=>$userId,
				'auth_assignment_bizrule'=>$bizRule,
				'auth_assignment_data'=>serialize($data)
			));
		return new CAuthAssignment($this,$itemName,$userId,$bizRule,$data);
	}

	/**
	 * Revokes an authorization assignment from a user.
	 * @param string $itemName the item name
	 * @param mixed $userId the user ID (see {@link IWebUser::getId})
	 * @return boolean whether removal is successful
	 */
	public function revoke($itemName,$userId)
	{
		return $this->db->createCommand()
			->delete($this->assignmentTable, 'auth_assignment_itemname=:itemname AND auth_assignment_userid=:userid', array(
				':itemname'=>$itemName,
				':userid'=>$userId
			)) > 0;
	}

	/**
	 * Returns a value indicating whether the item has been assigned to the user.
	 * @param string $itemName the item name
	 * @param mixed $userId the user ID (see {@link IWebUser::getId})
	 * @return boolean whether the item has been assigned to the user.
	 */
	public function isAssigned($itemName,$userId)
	{
		return $this->db->createCommand()
			->select('auth_assignment_itemname')
			->from($this->assignmentTable)
			->where('auth_assignment_itemname=:itemname AND auth_assignment_userid=:userid', array(
				':itemname'=>$itemName,
				':userid'=>$userId))
			->queryScalar() !== false;
	}

	/**
	 * Returns the item assignment information.
	 * @param string $itemName the item name
	 * @param mixed $userId the user ID (see {@link IWebUser::getId})
	 * @return CAuthAssignment the item assignment information. Null is returned if
	 * the item is not assigned to the user.
	 */
	public function getAuthAssignment($itemName,$userId)
	{
		$row=$this->db->createCommand()
			->select()
			->from($this->assignmentTable)
			->where('auth_assignment_itemname=:itemname AND auth_assignment_userid=:userid', array(
				':itemname'=>$itemName,
				':userid'=>$userId))
			->queryRow();
		if($row!==false)
		{
			if(($data=@unserialize($row['auth_assignment_data']))===false)
				$data=null;
			return new CAuthAssignment($this,$row['auth_assignment_itemname'],$row['auth_assignment_userid'],$row['auth_assignment_bizrule'],$data);
		}
		else
			return null;
	}

	/**
	 * Returns the item assignments for the specified user.
	 * @param mixed $userId the user ID (see {@link IWebUser::getId})
	 * @return array the item assignment information for the user. An empty array will be
	 * returned if there is no item assigned to the user.
	 */
	public function getAuthAssignments($userId)
	{
		$rows=$this->db->createCommand()
			->select()
			->from($this->assignmentTable)
			->where('auth_assignment_userid=:userid', array(':userid'=>$userId))
			->queryAll();
		$assignments=array();
		foreach($rows as $row)
		{
			if(($data=@unserialize($row['auth_assignment_data']))===false)
				$data=null;
			$assignments[$row['auth_assignment_itemname']]=new CAuthAssignment($this,$row['auth_assignment_itemname'],$row['auth_assignment_userid'],$row['auth_assignment_bizrule'],$data);
		}
		return $assignments;
	}

	/**
	 * Saves the changes to an authorization assignment.
	 * @param CAuthAssignment $assignment the assignment that has been changed.
	 */
	public function saveAuthAssignment($assignment)
	{
		$this->db->createCommand()
			->update($this->assignmentTable, array(
				'auth_assignment_bizrule'=>$assignment->getBizRule(),
				'auth_assignment_data'=>serialize($assignment->getData()),
			), 'auth_assignment_itemname=:itemname AND auth_assignment_userid=:userid', array(
				'auth_assignment_itemname'=>$assignment->getItemName(),
				'auth_assignment_userid'=>$assignment->getUserId()
			));
	}

	/**
	 * Returns the authorization items of the specific type and user.
	 * @param integer $type the item type (0: operation, 1: task, 2: role). Defaults to null,
	 * meaning returning all items regardless of their type.
	 * @param mixed $userId the user ID. Defaults to null, meaning returning all items even if
	 * they are not assigned to a user.
	 * @return array the authorization items of the specific type.
	 */
	public function getAuthItems($type=null,$userId=null)
	{
		if($type===null && $userId===null)
		{
			$command=$this->db->createCommand()
				->select()
				->from($this->itemTable);
		}
		else if($userId===null)
		{
			$command=$this->db->createCommand()
				->select()
				->from($this->itemTable)
				->where('auth_item_type=:type', array(':type'=>$type));
		}
		else if($type===null)
		{
			$command=$this->db->createCommand()
				->select('auth_item_name,auth_item_type,auth_item_description,t1.auth_item_bizrule,t1.auth_item_data')
				->from(array(
					$this->itemTable.' t1',
					$this->assignmentTable.' t2'
				))
				->where('auth_item_name=auth_assignment_itemname AND auth_assignment_userid=:userid', array(':userid'=>$userId));
		}
		else
		{
			$command=$this->db->createCommand()
				->select('auth_item_name,auth_item_type,auth_item_description,t1.auth_item_bizrule,t1.auth_item_data')
				->from(array(
					$this->itemTable.' t1',
					$this->assignmentTable.' t2'
				))
				->where('auth_item_name=auth_assignment_itemname AND auth_item_type=:type AND auth_assignment_userid=:userid', array(
					':type'=>$type,
					':userid'=>$userId
				));
		}
		$items=array();
		foreach($command->queryAll() as $row)
		{
			if(($data=@unserialize($row['data']))===false)
				$data=null;
			$items[$row['name']]=new CAuthItem($this,$row['auth_item_name'],$row['auth_item_type'],$row['auth_item_description'],$row['auth_item_bizrule'],$data);
		}
		return $items;
	}

	/**
	 * Creates an authorization item.
	 * An authorization item represents an action permission (e.g. creating a post).
	 * It has three types: operation, task and role.
	 * Authorization items form a hierarchy. Higher level items inheirt permissions representing
	 * by lower level items.
	 * @param string $name the item name. This must be a unique identifier.
	 * @param integer $type the item type (0: operation, 1: task, 2: role).
	 * @param string $description description of the item
	 * @param string $bizRule business rule associated with the item. This is a piece of
	 * PHP code that will be executed when {@link checkAccess} is called for the item.
	 * @param mixed $data additional data associated with the item.
	 * @return CAuthItem the authorization item
	 * @throws CException if an item with the same name already exists
	 */
	public function createAuthItem($name,$type,$description='',$bizRule=null,$data=null)
	{
		$this->db->createCommand()
			->insert($this->itemTable, array(
				'auth_item_name'=>$name,
				'auth_item_type'=>$type,
				'auth_item_description'=>$description,
				'auth_item_bizrule'=>$bizRule,
				'auth_item_data'=>serialize($data)
			));
		return new CAuthItem($this,$name,$type,$description,$bizRule,$data);
	}

	/**
	 * Removes the specified authorization item.
	 * @param string $name the name of the item to be removed
	 * @return boolean whether the item exists in the storage and has been removed
	 */
	public function removeAuthItem($name)
	{
		if($this->usingSqlite())
		{
			$this->db->createCommand()
				->delete($this->itemChildTable, 'auth_item_tree_parent=:name1 OR auth_item_tree_child=:name2', array(
					':name1'=>$name,
					':name2'=>$name
			));
			$this->db->createCommand()
				->delete($this->assignmentTable, 'auth_assignment_itemname=:name', array(
					':name'=>$name,
			));
		}

		return $this->db->createCommand()
			->delete($this->itemTable, 'auth_item_name=:name', array(
				':name'=>$name
			)) > 0;
	}

	/**
	 * Returns the authorization item with the specified name.
	 * @param string $name the name of the item
	 * @return CAuthItem the authorization item. Null if the item cannot be found.
	 */
	public function getAuthItem($name)
	{
		$row=$this->db->createCommand()
			->select()
			->from($this->itemTable)
			->where('auth_item_name=:name', array(':name'=>$name))
			->queryRow();

		if($row!==false)
		{
			if(($data=@unserialize($row['auth_item_data']))===false)
				$data=null;
			return new CAuthItem($this,$row['auth_item_name'],$row['auth_item_type'],$row['auth_item_description'],$row['auth_item_bizrule'],$data);
		}
		else
			return null;
	}

	/**
	 * Saves an authorization item to persistent storage.
	 * @param CAuthItem $item the item to be saved.
	 * @param string $oldName the old item name. If null, it means the item name is not changed.
	 */
	public function saveAuthItem($item,$oldName=null)
	{
		if($this->usingSqlite() && $oldName!==null && $item->getName()!==$oldName)
		{
			$this->db->createCommand()
				->update($this->itemChildTable, array(
					'auth_item_tree_parent'=>$item->getName(),
				), 'auth_item_tree_parent=:whereName', array(
					':whereName'=>$oldName,
				));
			$this->db->createCommand()
				->update($this->itemChildTable, array(
					'auth_item_tree_child'=>$item->getName(),
				), 'auth_item_tree_child=:whereName', array(
					':whereName'=>$oldName,
				));
			$this->db->createCommand()
				->update($this->assignmentTable, array(
					'auth_assignment_itemname'=>$item->getName(),
				), 'auth_assignment_itemname=:whereName', array(
					':whereName'=>$oldName,
				));
		}

		$this->db->createCommand()
			->update($this->itemTable, array(
				'auth_item_name'=>$item->getName(),
				'auth_item_type'=>$item->getType(),
				'auth_item_description'=>$item->getDescription(),
				'auth_item_bizrule'=>$item->getBizRule(),
				'auth_item_data'=>serialize($item->getData()),
			), 'auth_item_name=:whereName', array(
				':whereName'=>$oldName===null?$item->getName():$oldName,
			));
	}

}
