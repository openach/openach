<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

$this->breadcrumbs=array(
	'Originators',
);

$this->stockMenus( array( 'create','search' ) );

?>

<h1>Originators</h1>

<?php $this->showOAListView( $dataProvider,  array( 'originator_name', 'originator_city', 'originator_state_province' ) ); ?>

