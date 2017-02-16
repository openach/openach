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
	$model->user_id=>array('view','id'=>$model->user_id),
	'Update',
);

$this->stockMenus( array( 'list', 'create', 'delete', 'view', 'search' ), $model->user_id );

?>

<h1>Update <?php echo $model->user_login; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model, 'create'=>false)); ?>
