<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

$this->stockMenus( array( 'create', 'search' ) );

?>

<h1>Roles</h1>

<?php $this->showOAListView( $dataProvider, array( 'role_name', 'role_iat_enabled' ) ); ?>

