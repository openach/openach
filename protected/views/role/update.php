<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

$this->breadcrumbs=array(
	'Roles'=>array('index'),
	$model->role_id=>array('view','id'=>$model->role_id),
	'Update',
);

$this->stockMenus( array( 'list','create','delete','view','search' ), $model->role_id );

?>

<h1>Update Role <?php echo $model->role_name; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
