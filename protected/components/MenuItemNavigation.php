<?php

/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

Yii::import('zii.widgets.CPortlet');

class MenuItemNavigation extends CPortlet
{
	protected $menuItems;
	protected $menuTrees = array();
	protected $linkClass = '';
	protected $itemClass = '';
	protected $iconClass = 'icon';
	protected $displayText = false;
	protected $listHtmlOptions = array();

	public function init()
	{
		$this->menuItems = MenuItem::model()->findByComponent( get_class( $this ) );
		$this->buildMenuTree();
		parent::init();
	}

	protected function renderContent()
	{
		$menuCount = 1;
		foreach ( $this->menuTrees as $menuTree )
		{
			$menuId = get_class( $this ) . '-' . $menuCount;
			$listOptions = array_merge( array( 'data-role' => 'listview' ), $this->listHtmlOptions );
			$this->widget('zii.widgets.CMenu', array( 'id' => $menuId, 'items' => $menuTree, 'encodeLabel' => false, 'htmlOptions' => $listOptions ) );
			$menuCount++;
		}
	}

	protected function buildMenuTree()
	{
		$tempMenuTree = array();
		$menuGroup = '';
		foreach ( $this->menuItems as $menuItem )
		{
			if ( $menuGroup && $menuGroup != $menuItem->menu_item_group )
			{
				$menuGroup = $menuItem->menu_item_group;
				$this->menuTrees[] = $tempMenuTree;
				$tempMenuTree = array();
			}
			elseif ( ! $menuGroup )
			{
				$menuGroup = $menuItem->menu_item_group;
			}
			$menuItemText = '';
			if ( $this->displayText )
			{
				$menuItemText = CHtml::tag('div', array( 'class' => 'text' ), $menuItem->menu_item_text );
			}
			$newMenuItem = array(
					'label' =>      CHtml::tag('h3', array( 'class' => 'label' ), $menuItem->menu_item_label ) . $menuItemText,
					'url' => Yii::app()->createUrl( $menuItem->menu_item_path, $this->getUrlParams() ),
					'items' => array(),
					'itemOptions' => array( 'class' => $this->itemClass . ' ' . $menuItem->menu_item_class ),
					'linkOptions' => array( 'class' => $this->linkClass ),
				);

			if ( $menuItem->menu_item_icon )
			{
				$newMenuItem['label'] = CHtml::tag('img', array( 'src' => $menuItem->menu_item_icon, 'class' => $this->iconClass . ' ' . $menuItem->menu_item_class ) )
							. $newMenuItem['label'];
			}

			if ( $menuItem->menu_item_parent_id  && isset( $tempMenuTree[ $menuItem->menu_item_parent_id ] ) )
			{
				$tempMenuTree[ $menuItem->menu_item_parent_id ]['items'][] = $newMenuItem;
			}
			else
			{
				$tempMenuTree[ $menuItem->menu_item_id ] = $newMenuItem;
			}
		
		}

		$this->menuTrees[] = $tempMenuTree;
	}

	protected function getUrlParams()
	{
		return array();
	}

}
