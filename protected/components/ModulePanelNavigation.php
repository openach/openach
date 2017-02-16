<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

Yii::import('application.components.MenuItemNavigation');

class ModulePanelNavigation extends MenuItemNavigation
{
	public $fieldName = '';
	public $model = null;

	public function init()
	{
		$this->linkClass = 'fromContent';
		$this->itemClass = 'panelNavLink';
		$this->iconClass = 'icon-64';
		$this->displayText = true;
		$this->listHtmlOptions = array( 'data-inset' => 'true' );
		parent::init();
	}

	protected function getUrlParams()
	{
		$params = array();
		if ( $this->fieldName && $this->model && isset( $this->model->{$this->fieldName} ) )
		{
			$params[ $this->fieldName ] = $this->model->{$this->fieldName};
		}
		return $params;
	}
}
