<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

$menuItems = array(
		array( 
			'component' => 'BottomNavigation',
			'group' => 'Administration',
			'path' => 'admin/',
			'class' => '',
			'icon' => '',
			'label' => 'Administration',
			'text' => '',
			'weight' => 0,
			'require_role' => 'admin',
		),
		array( 
			'component' => 'ProfileNavigation',
			'group' => 'Settings',
			'path' => 'user/profile/',
			'class' => '',
			'icon' => '/images/icons/large/user.png',
			'label' => 'Profile',
			'text' => '',
			'weight' => 0,
			'require_role' => '',
		),
		array( 
			'component' => 'AdminPanelNavigation',
			'group' => 'Administration',
			'path' => 'user/index/',
			'class' => '',
			'icon' => '/images/icons/large/user.png',
			'label' => 'Users',
			'text' => 'Manage user accounts',
			'weight' => 0,
			'require_role' => 'admin',
		),
		array( 
			'component' => 'ProfileNavigation',
			'group' => 'Settings',
			'path' => 'user/password/',
			'class' => '',
			'icon' => '',
			'label' => 'Password',
			'text' => '',
			'weight' => 0,
			'require_role' => '',
		),
		array( 
			'component' => 'ProfileNavigation',
			'group' => 'Settings',
			'path' => 'user/security/',
			'class' => '',
			'icon' => '',
			'label' => 'Security',
			'text' => '',
			'weight' => 0,
			'require_role' => '',
		),
		array( 
			'component' => 'AdminPanelNavigation',
			'group' => 'Administration',
			'path' => 'role/index/',
			'class' => '',
			'icon' => '/images/icons/large/role.png',
			'label' => 'Roles',
			'text' => 'Manage user roles',
			'weight' => 0,
			'require_role' => 'admin',
		),
		array( 
			'component' => 'ProfileNavigation',
			'group' => 'Settings',
			'path' => 'user/preferences/',
			'class' => '',
			'icon' => '',
			'label' => 'Preferences',
			'text' => '',
			'weight' => 0,
			'require_role' => '',
		),
		array( 
			'component' => 'AdminPanelNavigation',
			'group' => 'Administration',
			'path' => 'originator/index/',
			'class' => '',
			'icon' => '/images/icons/large/originator.png',
			'label' => 'Originators',
			'text' => 'Manage ACH originators',
			'weight' => 0,
			'require_role' => 'admin',
		),
		array(
			'component' => 'AdminPanelNavigation',
			'group' => 'Administration',
			'path' => 'site/logout/',
			'class' => '',
			'icon' => '/images/icons/large/secure.png',
			'label' => 'Log Out',
			'text' => 'Log out of OpenACH ',
			'weight' => 0,
			'require_role' => '',
		),

/*		array(
			'component' => 'AdminPanelNavigation',
			'group' => 'Administration',
			'path' => 'paymentProfile/index/',
			'class' => '',
			'icon' => '/images/icons/large/customer.png',
			'label' => 'Payment Profiles',
			'text' => 'Manage payment profiles',
			'weight' => 0,
			'require_role' => 'admin',
		),
		array( 
			'component' => 'AdminPanelNavigation',
			'group' => 'Administration',
			'path' => 'paymentSchedule/index/',
			'class' => '',
			'icon' => '/images/icons/large/schedule.png',
			'label' => 'Payment Schedules',
			'text' => 'Manage payment schedules',
			'weight' => 0,
			'require_role' => 'admin',
		),
*/
		array(
			'component' => 'BottomNavigation',
			'group' => 'Administration',
			'path' => 'achFile/index',
			'class' => '',
			'icon' => '/images/icons/large/achfile.png',
			'label' => 'ACH Files',
			'text' => '',
			'weight' => 0,
			'require_role' => '',
		),
		array(
			'component' => 'BottomNavigation',
			'group' => 'Administration',
			'path' => 'paymentSchedule/index',
			'class' => '',
			'icon' => '/images/icons/large/schedule.png',
			'label' => 'Payment Schedules',
			'text' => '',
			'weight' => 0,
			'require_role' => '',
		),

		array(
			'component' => 'OriginatorInfoPanelNavigation',
			'group' => 'OriginatorInfo',
			'path' => 'achBatch/index/',
			'class' => '',
			'icon' => '/images/icons/large/achbatch.png',
			'label' => 'Batches',
			'text' => 'ACH Batches',
			'weight' => 1,
			'require_role' => '',
		),
		array(
			'component' => 'OriginatorInfoPanelNavigation',
			'group' => 'OriginatorInfo',
			'path' => 'paymentProfile/index/',
			'class' => '',
			'icon' => '/images/icons/large/customer.png',
			'label' => 'Payment Profiles',
			'text' => 'Manage payment profiles',
			'weight' => 0,
			'require_role' => '',
		),




	);

$fixtures = array();
foreach ( $menuItems as $menuItem )
{
	$fixtures['MenuItem_' . count( $fixtures ) ] = array(
		'menu_item_id' => UUID::mint()->string,
		'menu_item_component' => $menuItem['component'],
		'menu_item_group' => $menuItem['group'],
		'menu_item_parent_id' => '',
		'menu_item_path' => $menuItem['path'],
		'menu_item_class' => $menuItem['class'],
		'menu_item_icon' => $menuItem['icon'],
		'menu_item_label' => $menuItem['label'],
		'menu_item_text' => $menuItem['text'],
		'menu_item_weight' => $menuItem['weight'],
		'menu_item_require_role' => $menuItem['require_role'],
	);
}
return $fixtures;

