<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

Yii::import('application.components.MenuItemNavigation');

class AdminPanelNavigation extends MenuItemNavigation
{
	public function init()
	{
		$this->linkClass = 'fromContent';
		$this->itemClass = 'panelNavLink';
		$this->iconClass = '';
		$this->displayText = true;
		$this->listHtmlOptions = array( 'data-inset' => 'true' );
		parent::init();
	}
}
