<?php

/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

Yii::import('zii.widgets.CPortlet');

class MobileMenuItemNavigation extends CPortlet
{
	protected $menuItems;
	protected $menuTrees = array();
	protected $linkClass = '';
	protected $itemClass = '';
	protected $iconClass = 'icon';
	protected $displayText = false;
	protected $requireAuthentication = false;

	public function init()
	{
		$this->menuItems = MenuItem::model()->findByComponent( get_class( $this ) );
		$this->buildMenuTree();
		parent::init();
	}

	protected function renderContent()
	{
		if ( $this->requireAuthentication && ! Yii::app()->user->getId() )
		{
			return;
		}
		$menuCount = 1;
		foreach ( $this->menuTrees as $menuTree )
		{
			$menuId = get_class( $this ) . '-' . $menuCount;
			$this->widget('zii.widgets.CMenu', array( 'id' => $menuId, 'items' => $menuTree, 'encodeLabel' => false, /*'htmlOptions' => array( 'data-role' => 'listview' ) */ ) );
			$menuCount++;
		}
	}

	protected function buildMenuTree()
	{
		$tempMenuTree = array();
		$menuGroup = '';
		foreach ( $this->menuItems as $menuItem )
		{

			if ( $menuItem->menu_item_require_role && ! Yii::app()->user->checkAccess( $menuItem->menu_item_require_role ) )
			{
				continue;
			}
			$menuGroupHeader = false;
			if ( $menuGroup && $menuGroup != $menuItem->menu_item_group )
			{
				$menuGroup = $menuItem->menu_item_group;
				$this->menuTrees[] = $tempMenuTree;
				$tempMenuTree = array();
				$menuGroupHeader = true;
			}
			elseif ( ! $menuGroup )
			{
				$menuGroup = $menuItem->menu_item_group;
				$menuGroupHeader = true;
			}
			$menuItemText = '';
			if ( $this->displayText )
			{
				$menuItemText = CHtml::tag('span', array( 'class' => 'text' ), $menuItem->menu_item_text );
			}
			$urlParts = explode( '/', $_SERVER['REQUEST_URI'] );
			$controller = ( isset( $urlParts[1] ) ) ? $urlParts[1] : ''; 
			if ( $menuItem->menu_item_path == $controller )
			{
				$selectedClass = 'ui-btn-active';
			}
			else
			{
				$selectedClass = '';
			}
			$itemOptions = array( 'class' => $this->itemClass . ' ' . $menuItem->menu_item_class );
			if ( $menuGroupHeader )
			{
				$itemOptions['data-role'] = 'list-divider';
				$itemOptions['data-theme'] = 'a';
			}
			$newMenuItem = array(
					'label' => 	CHtml::tag('span', array( 'class' => $this->iconClass . ' ' . $menuItem->menu_item_class ) ) . 
							CHtml::tag('span', array( 'class' => 'label' ), $menuItem->menu_item_label ) . $menuItemText,
					'url' => Yii::app()->createUrl( $menuItem->menu_item_path ),
					'items' => array(),
					'itemOptions' => $itemOptions,
					'linkOptions' => array( 'class' => $this->linkClass . ' ' . $selectedClass ),
				);

			//if ( $menuItem->menu_item_parent_id  && isset( $tempMenuTree[ $menuItem->menu_item_parent_id ] ) )
			//{
			//	$tempMenuTree[ $menuItem->menu_item_parent_id ]['items'][] = $newMenuItem;
			//}
			//else
			//{
				$tempMenuTree[ $menuItem->menu_item_id ] = $newMenuItem;
			//}
		
		}

		$this->menuTrees[] = $tempMenuTree;
	}

}
