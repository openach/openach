<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/


$this->breadcrumbs=array(
	'Originators'=>array('index'),
	$model->originator_id=>array('view','id'=>$model->originator_id),
	'Update',
);

$this->stockMenus( array( 'list','create','view','delete','search' ), $model->originator_id );

?>

<h1>Update <?php echo $model->originator_name; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
