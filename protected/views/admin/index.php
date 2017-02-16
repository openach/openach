<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

$this->breadcrumbs=array(
	'Admin',
);

$this->stockMenus( array() );

?>
<h1>Administration</h1>
<?php
        $this->widget( 'AdminPanelNavigation' );
?>
