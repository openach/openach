<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

$this->breadcrumbs=array(
	'Users'=>array('index'),
	'Create',
);

$this->stockMenus( array( 'list', 'search' ) );

?>

<h1>Create User</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model, 'create'=>true)); ?>
